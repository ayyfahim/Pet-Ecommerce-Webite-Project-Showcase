<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Status;
use App\Models\Product;
use App\Models\Variation;
use App\Models\CartBasket;
use App\Models\ConfigData;
use App\Models\AddressInfo;
use Illuminate\Support\Str;
use App\Models\ShippingZone;
use Illuminate\Http\Request;
use App\Http\Requests\CartStore;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Redirector;
use App\Presenters\CommonPresenter;
use App\Transformers\CartTransformer;
use Illuminate\Http\RedirectResponse;
use App\Transformers\ProductTransformer;
use App\Http\Requests\ApplyCouponRequest;
use App\Http\Controllers\Traits\CartChanges;
use App\Http\Controllers\Traits\CartHelpers;
use App\Http\Controllers\Traits\Product\HasVariation;

/**
 * @group Cart
 */
class CartController extends Controller
{
    use CartChanges, CartHelpers, HasVariation;

    public function __construct()
    {
        //        $this->middleware(['auth']);
    }

    /**
     * Cart Listing.
     * @queryParam use_points boolean Send it with TRUE when user click on use points to get discount
     * @queryParam use_coupon boolean Send it with TRUE when user click on use coupon to get discount
     * @queryParam coupon_code
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $cart = $this->getCart();
        $cart->doEmptyCart();
        $cart->clearDiscounts();
        // if (auth()->check()) {
        //     if ($request->has('use_points')) {
        //         $data['use_points'] = (bool)$request->use_points == true;
        //     }
        //     if ($request->use_coupon && $request->coupon_code && !$cart->coupon) {
        //         $error = null;
        //         //                $coupon = Coupon::where('code', $request->coupon_code)->isActive()->isValid()->first();
        //         $coupon = Coupon::where('code', $request->coupon_code)->isActive()->isValid()->first();
        //         if (!$coupon) {
        //             $error = 'invalid_coupon';
        //         } elseif (!$coupon->isUsable()) {
        //             $coupon = 'coupon_usage_exceed';
        //         } elseif (!$coupon->isUsableByCart($cart)) {
        //             $coupon = 'coupon_not_applicable_for_cart';
        //         }
        //         if ($error) {
        //             $config = ConfigData::findByType($error);
        //             $error_msg = $config->value;
        //             if ($error == 'coupon_not_applicable_for_cart') {
        //                 $error_msg = str_replace('{{target}}', $coupon->min_order, $error_msg);
        //             }
        //             return $this->returnCrudData($error_msg, null, 'error');
        //         }
        //         $data['coupon_id'] = $coupon->id;
        //     }
        //     if (isset($data) && $data) {
        //         $cart->update($data);
        //     }
        // }
        if ($request->expectsJson()) {
            return response()->json([
                'cart' => $this->getCartResponse()
            ]);
        }
    }

    /**
     * Cart Store Product.
     * @bodyParam product_id required
     * @bodyParam quantity required
     * @bodyParam options required array
     * @param CartStore $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function store(CartStore $request)
    {
        $product = Product::findOrFail($request->product_id);
        $variation = null;
        $quantity = $product->quantity;
        $options = [];
        if ($product->configurations()->count()) {
            if ($request->options) {
                $options = $request->options;
            } elseif ($product->first_options) {
                $options = $product->first_options;
            }
            if (!$options || (sizeof($options) != $product->configurations()->count())) {
                return $this->returnCrudData("Please select all options", null, 'error');
            }
        }
        if ($options) {
            $variation = $this->getVariation($product, $options);
            if ($variation) {
                $quantity = $variation->quantity;
            }
        }
        if (!$quantity) {
            return $this->returnCrudData(__('cart.out_of_stock'), null, 'error');
        }
        $cartItem = $this->cartItem($product, $variation, $options);
        if ($cartItem) {
            if (($cartItem->quantity + $request->quantity) > $quantity) {
                return $this->returnCrudData(__('cart.quantity_not_found', ['quantity' => $quantity]), null, 'error');
            }
            $cartItem->increment('quantity', $request->quantity);
        } else {
            if ($request->quantity > $quantity) {
                return $this->returnCrudData(__('cart.quantity_not_found', ['quantity' => $quantity]), null, 'error');
            }
            $cart_basket = $product->basket()->create([
                'quantity' => $request->quantity,
                'variation_id' => $variation ? $variation->id : null,
                'variation_price' => $variation ? $variation->regular_price : null
            ]);
            if ($options) {
                foreach ($options as $optionKey => $option) {
                    $cart_basket->options()->create([
                        'option_id' => $option,
                        'sort_order' => $optionKey
                    ]);
                }
            }
        }
        return $this->returnCrudData(__('cart.cart_added'), null, 'success', [
            'product' => fractal($product, ProductTransformer::class)->toArray()['data'],
            'cart' => $this->getCartResponse()
        ]);
    }

    /**
     * Cart Update Product.
     * @bodyParam product_id required
     * @bodyParam quantity required
     * @param CartBasket $cartBasket
     * @param CartStore $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function update(CartBasket $cartBasket, CartStore $request)
    {
        if ($request->quantity > $cartBasket->product_quantity) {
            return $this->returnCrudData(__('cart.quantity_not_found', ['quantity' => $cartBasket->product_quantity]), null, 'error');
        }
        $cartBasket->update($request->only('quantity'));
        return $this->returnCrudData(__('cart.cart_updated'), null, 'success', [
            'cart' => $this->getCartResponse()
        ]);
    }

    /**
     * Cart Delete Product.
     *
     * @param CartBasket $cartBasket
     * @param Request $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy(CartBasket $cartBasket, Request $request)
    {
        $cartBasket->delete();
        return $this->returnCrudData(__('cart.cart_removed'), null, 'success', [
            'cart' => $this->getCartResponse()
        ]);
    }

    /**
     * Clinic MoveToCart.
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function move_to_cart()
    {
        $auth = auth()->user();
        $clinic_list = $auth->clinic;
        foreach ($clinic_list as $productList) {
            $product = $productList->product;
            if (!$product->is_in_stock) {
                continue;
            }
            if ($this->cartItem($product, null, [])) {
                continue;
            } else {
                $product->basket()->create(['quantity' => 1]);
            }
        }

        return $this->returnCrudData(__('cart.cart_added'), null, 'success', [
            'cart' => $this->getCartResponse()
        ]);
    }

    /**
     * Cart Clear.
     *
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function clear()
    {
        $this->getCart()->basket()->delete();
        return $this->returnCrudData(__('cart.cart_cleared'), null, 'success', [
            'cart' => $this->getCartResponse()
        ]);
    }

    /**
     * getShippingMethods.
     *
     * @param AddressInfo $addressInfo
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function getShippingMethods(AddressInfo $addressInfo)
    {
        if ($addressInfo->city) {
            $zone = ShippingZone::whereJsonContains('cities', $addressInfo->city->color)->first();
            $shipping_methods = Order::getStatusFor('shipping_method')->whereIn('order', [1, 2]);
            if ($zone) {
                $methods = [];
                if ($zone->regular_price) {
                    $method = $shipping_methods->firstWhere('order', 1);
                    $methods[] = [
                        'id' => $method->id,
                        'zone_id' => $zone->id,
                        'title' => $method->title,
                        'price' => $zone->regular_price
                    ];
                }
                if ($zone->quick_price) {
                    $method = $shipping_methods->firstWhere('order', 2);
                    if ($method) {
                        $methods[] = [
                            'id' => $method->id,
                            'zone_id' => $zone->id,
                            'title' => $method->title,
                            'price' => $zone->quick_price
                        ];
                    }
                }
                return $this->returnCrudData("", null, 'success', $methods);
            }
        }

        return $this->returnCrudData("There's no shipping methods for this city", null, 'error');
    }

    /**
     * setShippingMethod.
     *
     * @param Request $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @queryParam zone_id required
     * @queryParam shipping_method_id required
     */
    public function setShippingMethod(Request $request)
    {
        $request->validate([
            'shipping_method_id' => 'required',
        ]);
        $shipping_method = Status::findOrFail($request->shipping_method_id);
        $cart = $this->getCart();
        $cart->update([
            'shipping_method_id' => $shipping_method->id,
            'shipping_info' => [
                'title' => $shipping_method->title,
                'order' => $shipping_method->order,
                'price' => 10
            ],
        ]);
        return $this->returnCrudData('', null, 'success', [
            'cart' => $this->getCartResponse()
        ]);
    }
    /**
     * setAdditional.
     *
     * @param Request $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @queryParam zone_id required
     * @queryParam shipping_method_id required
     */
    public function setAdditional(Request $request)
    {
        $request->validate([
            'additional' => 'required',
        ]);
        $cart = $this->getCart();
        $cart->update([
            'additional' => $request->additional,
        ]);
        return $this->returnCrudData('', null, 'success', [
            'cart' => $this->getCartResponse()
        ]);
    }

    /**
     * Apply Coupon Code.

     * @queryParam code
     * @param ApplyCouponRequest $request
     * @return JsonResponse
     */
    public function applyCartCouponCode(ApplyCouponRequest $request)
    {
        if ($request->has('products')) {
            $this->getCart()->doEmptyCart();

            $checkForStockResponse = $this->checkOutOfStockProducts($request->products);
            if ($checkForStockResponse['type'] == 'error') {
                return $this->returnCrudData($checkForStockResponse['msg'], null, $checkForStockResponse['type'], $checkForStockResponse['data'] ?? []);
            }

            $cartResponse = $this->addToMultipleCart($request->products);
            if ($cartResponse['type'] == 'error') {
                return $this->returnCrudData($cartResponse['msg'], null, $cartResponse['type']);
            }
        }

        $cart = $this->getCart();
        if ($request->has('code') && isset($request->code) && $request->code != '' && is_numeric($request->code)) {
            $couponResponse = $this->applyRewardPoint($cart, (int) $request->code, true);
            if ($couponResponse['type'] == 'error') {
                return $this->returnCrudData($couponResponse['msg'], null, $couponResponse['type'], array_key_exists('data', $couponResponse) ? $couponResponse['data'] : []);
            }
        } else {
            $couponResponse = $this->applyCouponCode($cart, $request->code, $request->products ?? [], true);
            if ($couponResponse['type'] == 'error') {
                return $this->returnCrudData($couponResponse['msg'], null, $couponResponse['type']);
            }
        }

        if (!auth()->check()) {
            $this->getCart()->doEmptyCart();
            $this->getCart()->delete();
        }
        return response()->json([
            'cart' => $couponResponse['data'],
            'coupon' => array_key_exists('coupon', $couponResponse['data']) ? $couponResponse['data']['coupon'] : [],
        ]);
    }
}
