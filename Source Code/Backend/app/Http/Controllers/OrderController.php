<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use App\Models\Order;
use App\Models\Status;
use App\Models\Product;
use Stripe\StripeClient;
use Illuminate\View\View;
use App\Models\ConfigData;
use App\Models\AddressInfo;
use App\Models\ProductList;
use App\Models\RfpProposal;
use Illuminate\Support\Str;
use App\Models\ShippingZone;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\ServiceRequest;
use App\Http\Requests\OrderPay;
use App\Http\Requests\OrderStore;
use Illuminate\Http\JsonResponse;
use App\Presenters\OrderPresenter;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use App\Presenters\CommonPresenter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Transformers\UserTransformer;
use Illuminate\Http\RedirectResponse;
use App\Transformers\OrderTransformer;
use Illuminate\Contracts\View\Factory;
use App\Http\Requests\OrderPayCheckout;
use App\Transformers\ProductTransformer;
use App\Services\PaymentGateways\WeAccept;
use App\Http\Controllers\Traits\CartChanges;
use App\Http\Controllers\Traits\CartHelpers;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Traits\Order\Checkout;
use App\Http\Controllers\Traits\Order\Creation;
use App\Http\Controllers\Traits\Order\Filtration;

/**
 * @group Order
 */
class OrderController extends Controller
{
    use CartChanges, Creation, CartHelpers;

    public function __construct()
    {
        $this->middleware(['auth.frontend:api'])->only('print');
        $this->middleware(['auth'])->except('checkoutSuccess', 'payCheckout', 'orderPaySuccess', 'getTotalRewardPoint', 'print');
    }

    /**
     * Order Listing.
     *
     * @param Request $request
     * @return Factory|JsonResponse|View
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $orders = $user->orders()->isPersisted();
        $orders = app(CommonPresenter::class)->paginate($orders->get());

        if ($request->expectsJson()) {
            return $this->returnPaginatedApiData(
                $orders,
                new OrderTransformer()
            );
        }
    }

    /**
     * Order Single.
     *
     * @param Request $request
     * @param Order $order
     * @return Factory|JsonResponse|View
     */
    public function show(Request $request, Order $order)
    {
        $auth = auth()->user();
        if ($auth->id != $order->cart->user->id) {
            abort(403);
        }
        if ($request->expectsJson()) {
            return fractal($order, new OrderTransformer(true))->toArray()['data'];
        }
    }

    /**
     * Order Store.
     *
     * @param OrderStore $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @bodyParam payment_method_id required get from global data
     * @bodyParam shipping_method_id required get from global data
     * @bodyParam address_info_id required
     * @bodyParam mobile boolean required for mobile only
     */
    public function store(OrderStore $request)
    {
        $cart = auth()->user()->activeCart;
        $this->applyCartChanges($cart);
        $payment_method = Status::findOrFail($request->payment_method_id);
        if ($cart->basket->count()) {
            $order = $cart->order()->create(
                $request->only(['payment_method_id', 'address_info_id', 'shipping_method_id'])
            );
            switch ($payment_method->order) {
                case 1:
                    $url = $this->getCheckoutURL($order);
                    if ($url) {
                        return response()->json([
                            'session_id' => $url,
                        ]);
                    }
                    break;
            }
        }
    }

    private function getCheckoutURL($order)
    {
        try {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'client_reference_id' => $order->id . '_' . rand(1111, 9999),
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => 'Order #' . $order->short_id,
                            ],
                            'unit_amount' => $order->amount * 100,
                        ],
                        'quantity' => 1,
                    ]
                ],
                'mode' => 'payment',
                'success_url' => route('paymentHandler.callback_success') . "?session_id={CHECKOUT_SESSION_ID}",
                'cancel_url' => route('paymentHandler.callback_success') . "?session_id={CHECKOUT_SESSION_ID}",
            ]);
            return $session->id;
            if ($session->id) {
                return "https://checkout.stripe.com/pay/" . $session->id;
            }
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return false;
        }
        return false;
    }

    public function pay(OrderPay $request)
    {
        try {
            $user = auth()->user();
            $addressInfo = AddressInfo::find($request->address_info_id);

            if (isset($request->full_name) && $request->full_name !== $user->full_name) {
                $updateData['full_name'] = $request->full_name;
            }
            if (isset($request->mobile) && $request->mobile !== $user->mobile) {
                $updateData['mobile'] = $request->mobile;
            }
            $user->update($updateData ?? []);
            if (!$user->carts()->count()) {
                $user->carts()->create();
            }

            $cart = $this->getCart(null, $user);
            if ($request->has('products')) {
                $this->getCart()->doEmptyCart();
                // Check Out of Stocks
                $checkForStockResponse = $this->checkOutOfStockProducts($request->products);
                if ($checkForStockResponse['type'] == 'error') {
                    return $this->returnCrudData($checkForStockResponse['msg'], null, $checkForStockResponse['type'], $checkForStockResponse['data'] ?? []);
                }
                // Add to Carts
                $cartResponse = $this->addToMultipleCart($request->products, $cart);
                if ($cartResponse['type'] == 'error') {
                    return $this->returnCrudData($cartResponse['msg'], null, $cartResponse['type'], $cartResponse['data'] ?? []);
                }
            }

            $cart = $user->activeCart;
            if (!$cart) {
                return $this->returnCrudData("Cart is empty", null, 'error');
            }

            if ($request->has('code') && isset($request->code) && $request->code != '' && is_numeric($request->code)) {
                $couponResponse = $this->applyRewardPoint($cart, (integer) $request->code, true);
                if ($couponResponse['type'] == 'error') {
                    return $this->returnCrudData($couponResponse['msg'], null, $couponResponse['type']);
                }
            } elseif ($request->has('code') && isset($request->code) && $request->code != '') {
                $couponResponse = $this->applyCouponCode($cart, $request->code, $request->products ?? [], true);
                if ($couponResponse['type'] == 'error') {
                    return $this->returnCrudData($couponResponse['msg'], null, $couponResponse['type']);
                }
            } 
            // else {
            //     $cart->update(['coupon_id' => null]);
            // }

            // if ($request->has('code') && isset($request->code) && $request->code != '' && is_numeric($request->code)) {
            //     $couponResponse = $this->applyRewardPoint($cart, $request->code, true);
            //     if ($couponResponse['type'] == 'error') {
            //         return $this->returnCrudData($couponResponse['msg'], null, $couponResponse['type']);
            //     }
            // } else {
            //     $cart->update(['use_points' => false]);
            // }

            $this->applyCartChanges($cart);

            if (!$cart->basket->count()) {
                return $this->returnCrudData("Cart is empty. No products given.", null, 'error');
            }

            if ($cart->order) {
                $cart->order()->delete();
            }

            $order = $cart->order()->create(
                array_merge($cart->only(['shipping_method_id']), [
                    'address_info_id' => $request->address_info_id,
                ])
            );

            $stripe = new StripeClient(env('STRIPE_SECRET'));

            if ($request->payment_type == "card") {
                $intent = $stripe->paymentIntents->retrieve(
                    $request->clientSecret,
                    []
                );

                if ($intent->status == "succeeded") {
                } else {
                    return $this->returnCrudData("Payment failed", null, 'error');
                }

                $status = Order::getStatusFor('payment_method');
                $status_id = $status->firstWhere('order', 1)->id;

                $getStatus = Order::getStatusFor('status');

                $order->update([
                    'payment_id' => $request->clientSecret,
                    'payment_method_id' => $status_id,

                    'payment_info' =>  $intent->charges->data[0]->toArray(),
                    'is_temp' => false,

                    'status_id' => $getStatus->firstWhere('order', 6)->id
                ]);

                $order = $order->fresh();

                $points = ConfigData::findByType('order_reward_point')->value;

                // if ($cart->temporary_cart->count()) {
                //     $cart->temporary_cart()->delete();
                // }
                return $this->returnCrudData("Your order placed successfully", null, 'success', [
                    'order' => fractal($order, new OrderTransformer(true))->toArray()['data'],
                    'recently_viewed' => fractal(Product::isSearchable()->whereNotIn('id', $order->cart->basket->pluck("product_id")->toArray())->where('views', '>', 0)->orderBy('views', 'DESC')->take(5)->get(), new ProductTransformer())->toArray()['data'],
                    // 'user' => $user->fresh(),
                    'user' => fractal($user->fresh(), new UserTransformer())->toArray()['data'],
                    'points' => $points * (int) $order->totals_info['total'],
                ]);
            } else if ($request->payment_type == "paypal") {
                //{"id":"9958520953453802A","intent":"CAPTURE","status":"COMPLETED","purchase_units":[{"reference_id":"default","amount":{"currency_code":"USD","value":"1.99"},"payee":{"email_address":"sb-noxvy20836565@business.example.com","merchant_id":"MVT3EWG3Y4NYN"},"soft_descriptor":"PAYPAL *TEST STORE","shipping":{"name":{"full_name":"Dinesh Kaku"},"address":{"address_line_1":"2 Peppercorn Court","address_line_2":"Point Cook","admin_area_2":"Melbourne","postal_code":"3030","country_code":"NZ"}},"payments":{"captures":[{"id":"88Y76457L6552461W","status":"COMPLETED","amount":{"currency_code":"USD","value":"1.99"},"final_capture":true,"seller_protection":{"status":"ELIGIBLE","dispute_categories":["ITEM_NOT_RECEIVED","UNAUTHORIZED_TRANSACTION"]},"create_time":"2022-10-28T23:04:01Z","update_time":"2022-10-28T23:04:01Z"}]}}],"payer":{"name":{"given_name":"Dinesh","surname":"Kaku"},"email_address":"support@dealaday.co.nz","payer_id":"3DN84TN9UKF8S","address":{"country_code":"NZ"}},"create_time":"2022-10-28T23:03:47Z","update_time":"2022-10-28T23:04:01Z","links":[{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/9958520953453802A","rel":"self","method":"GET"}]}
                $status = Order::getStatusFor('payment_method');
                $status_id = $status->firstWhere('order', 3)->id;
                $paypal_data = $request->payment_data;
                if ($paypal_data['status'] == 'COMPLETED') {
                    $order->update([
                        'payment_id' => $paypal_data['id'],
                        'payment_method_id' => $status_id,
                        'payment_info' => $paypal_data,
                        'is_temp' => false
                    ]);
                } else {
                    $order->update([
                        'payment_id' => $paypal_data['id'],
                        'payment_method_id' => $status_id,
                        'payment_info' => $paypal_data,
                        'is_temp' => true
                    ]);
                }

                if ($cart->temporary_cart->count()) {
                    $cart->temporary_cart()->delete();
                }

                return $this->returnCrudData("Your order placed successfully", null, 'success', [
                    'order' => fractal($order, new OrderTransformer(true))->toArray()['data'],
                    'user' => $user->fresh()
                ]);
            } else {
                return $this->returnCrudData("Unsuppoerted payment method", null, 'error');
            }
        } catch (\Exception $exception) {
            return $this->returnCrudData($exception->getMessage(), null, 'error');
        }
        return $this->returnCrudData('Order placed successfully');
    }

    public function payCheckout(OrderPayCheckout $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            Auth::login($user, true);
            $authUser = auth()->user();
            $updateData = [];
            $updateData['last_login'] = now();
            if (isset($request->full_name)) {
                $updateData['full_name'] = $request->full_name;
            }
            if (isset($request->mobile)) {
                $updateData['mobile'] = $request->mobile;
            }
            $authUser->update($updateData);
            $this->saveToken($request, $authUser);
            if (!$user->carts()->count()) {
                $user->carts()->create();
            }
        } else {
            $data = $request->only('email', 'full_name', 'mobile');
            $data['email_verified_at'] = now();
            $user = User::create($data);
            $user->attachRoleOf('customer');
            $this->saveToken($request, $user);
        }

        $token = auth()->fromUser($user);
        $cart = $this->getCart(null, $user);
        if ($request->has('products')) {
            $this->getCart()->doEmptyCart();
            // Check Out of Stocks
            $checkForStockResponse = $this->checkOutOfStockProducts($request->products);
            if ($checkForStockResponse['type'] == 'error') {
                return $this->returnCrudData($checkForStockResponse['msg'], null, $checkForStockResponse['type'], $checkForStockResponse['data'] ?? []);
            }
            // Add to Carts
            $cartResponse = $this->addToMultipleCart($request->products, $cart);
            if ($cartResponse['type'] == 'error') {
                return $this->returnCrudData($cartResponse['msg'], null, $cartResponse['type'], $cartResponse['data'] ?? []);
            }
        }

        if ($request->has('code') && isset($request->code) && $request->code != '') {
            $cart = $this->getCart(null, $user);
            $couponResponse = $this->applyCouponCode($cart, $request->code, $request->products, true);
            if ($couponResponse['type'] == 'error') {
                return $this->returnCrudData($couponResponse['msg'], null, $couponResponse['type']);
            }
        }

        $this->applyCartChanges($cart);

        if (!$cart->basket->count()) {
            return $this->returnCrudData("Cart is empty. No products given.", null, 'error');
        }

        if ($cart->order) {
            $cart->order()->delete();
        }

        try {
            $address_info_id = DB::transaction(function () use ($request) {
                $authUser = auth()->user();
                $address = $authUser->addresses()->create([
                    'default' => $authUser->addresses()->count() == 0
                ]);
                $address_info = $address->infos()->create($request->except('default'));
                return $address_info->id;
            });
        } catch (Exception $exception) {
            return $this->returnCrudData($exception->getMessage(), null, 'error');
        }

        $order = $cart->order()->create(
            array_merge($cart->only(['shipping_method_id']), [
                'address_info_id' => $address_info_id,
            ])
        );

        switch ($request->payment_type) {
            case 'card':
                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET', 'sk_test_51GuuiiCB2udiApBimTAbIM8MkV7QfR3h6TWHHkFb3duVVHCz7PVGxDtfIJG3Yf8Ky9EUCo6fqC9n4Wr1CrdekSlW009TU9VAey'));

                $cart = $this->getCartResponse();
                // dd($cart["items"]);
                $lineItems = [];
                foreach ($cart["items"] as $product) {
                    $lineItems[] = [
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => $product['product']['title'],
                                'images' => [$product['product']['cover']]
                            ],
                            'unit_amount' => $product['product']['price'] * 100,
                        ],
                        'quantity' => $product['quantity'],
                    ];
                }
                $session = \Stripe\Checkout\Session::create([
                    'line_items' => $lineItems,
                    'mode' => 'payment',
                    'success_url' => config('app.frontend_url') . "/cart-checkout/checkout?session_id={CHECKOUT_SESSION_ID}",
                    'cancel_url' => config('app.frontend_url'),
                ]);

                $order->update(['session_id' => $session->id]);

                return $this->returnCrudData('', '', '', $session);
                break;

            default:
                return $this->returnCrudData('Please select a valid payment type', null);
                break;
        }
    }

    public function orderPaySuccess(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET', 'sk_test_51GuuiiCB2udiApBimTAbIM8MkV7QfR3h6TWHHkFb3duVVHCz7PVGxDtfIJG3Yf8Ky9EUCo6fqC9n4Wr1CrdekSlW009TU9VAey'));
        $sessionId = $request->get('session_id');

        try {
            $session = \Stripe\Checkout\Session::retrieve($sessionId);
            if (!$session) {
                return $this->returnCrudData('Session not found', null, 'error');
            }
            $payment_intent = \Stripe\PaymentIntent::retrieve($session->payment_intent);

            $order = Order::where('session_id', $session->id)->first();
            if (!$order) {
                return $this->returnCrudData('Order not found', null, 'error');
            }

            $status = Order::getStatusFor('status');
            $status_id = $status->firstWhere('order', 1)->id;

            if ($order->status->id === $status_id) {

                $status = Order::getStatusFor('payment_method');
                $status_id = $status->firstWhere('order', 1)->id;

                $order->update([
                    'payment_id' => $payment_intent->client_secret,
                    'payment_method_id' => $status_id,

                    'payment_info' =>  $payment_intent->charges->data[0]->toArray(),
                    'is_temp' => false
                ]);
            }

            return $this->returnCrudData("Your order placed successfully", null, 'success', [
                'order' => fractal($order, new OrderTransformer(true))->toArray()['data']
            ]);
        } catch (\Exception $e) {
            dd($e);
            return $this->returnCrudData($e->getMessage(), null, 'error');
        }
    }

    /**
     * print.
     *
     * @param mixed $order
     * @return Factory|View
     */
    public function print(Order $order)
    {
        return view('pages.orders.manager.print', [
            'order' => $order,
            'site_title' => ConfigData::findByType('title')->value,
            'site_logo' => ConfigData::findByType('logo')->cover->getUrl(),
            'site_address' => ConfigData::findByType('address')->value,
            'contact_number' => ConfigData::findByType('contact_numbers')->value,
            'email' => ConfigData::findByType('emails')->value,
        ]);
    }

    public function getTotalRewardPoint() {
        try {
            if ($points = ConfigData::findByType('order_reward_point')->value) {
                $exchange = isset(ConfigData::findByType('reward_point_exchange')->value) ? ConfigData::findByType('reward_point_exchange')->value : 0;
                return $this->returnCrudData("", null, 'success', [
                    'points' => (int) $points,
                    'exchange' => $exchange,
                ]);
            }
        } catch (\Throwable $e) {
            return $this->returnCrudData($e->getMessage(), null, 'error');
        }
        
    }
}
