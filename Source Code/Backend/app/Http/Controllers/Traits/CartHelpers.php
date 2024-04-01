<?php

/**
 * Created by PhpStorm.
 * User: Road9-2
 * Date: 9/15/2020
 * Time: 5:24 PM
 */

namespace App\Http\Controllers\Traits;


use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\CartBasket;
use App\Models\ConfigData;
use App\Transformers\CartTransformer;

trait CartHelpers
{
    private function getVariationFromProudcts(Product $product, $options)
    {
        $variation = $product->variations()->where(function ($query) use ($options) {
            foreach ($options as $option) {
                $query->whereHas('options', function ($query) use ($option) {
                    $query->where('option_id', $option);
                });
            }
        })->latest()->first();
        if (!$variation) {
            $variations = $product->variations()->whereHas('options', function ($query) use ($options) {
                $query->whereIn('option_id', $options);
            })->latest()->get();
            $variation_options = [];
            foreach ($variations as $variationTemp) {
                $item['variation'] = $variationTemp;
                $item['variation_options'] = $variationTemp->options->pluck('option_id')->toArray();
                $item['variation_options_diff'] = array_diff($item['variation_options'], $options);
                $variation_options[] = $item;
            }
            $variation_options = collect($variation_options)->sortBy(function ($item) {
                return sizeof($item['variation_options_diff']);
            });
            $variation = $variation_options->first() ? $variation_options->first()['variation'] : null;
        }
        if (!$variation) {
            $variation = $product->variations()->whereDoesntHave('options')->latest()->first();
        }
        return $variation;
    }

    // helpers
    public function cartItem(Product $product, $variation = null, $options = [])
    {
        return $this->cartBasketQuery($product, $variation, $options);
    }

    private function cartBasketQuery(Product $product, $variation = null, $options = [])
    {
        $response = null;
        $cartBaskets = CartBasket::query()->latest()->where('cart_id', $this->getCart()->id)->where('product_id', $product->id)->get();
        foreach ($cartBaskets as $cartBasket) {
            if (!array_diff($cartBasket->options->pluck('option_id')->toArray(), $options)) {
                $response = $cartBasket;
            }
        }
        return $response;
    }

    private function getCartResponse($cart = null)
    {
        $cart = $this->getCart($cart);
        return fractal($cart, new CartTransformer($this->applyCartChanges($cart)))->toArray()['data'];
    }

    private function getCart($cart = null, $user = null)
    {
        if (!$cart) {
            if (auth()->check()) {
                $cart = auth()->user()->activeCart;
            } 
            elseif ($user) {
                $cart = $user->activeCart;
            } 
            else {
                if (!Cart::where('session_id', session()->getId())->count()) {
                    Cart::create(['session_id' => session()->getId(), 'user_id' => null]);
                }
                $cart = Cart::where('session_id', session()->getId())->first();
            }
        }
        return $cart;
    }

    private function addToCart($product, $quantityP, $optionsP = null, $cart = null)
    {
        $response = [
            'type' => 'error',
            'msg' => 'Something went to wrong',
            'url' => null
        ];
        $variation = null;
        $quantity = $product->quantity;
        $options = [];
        if ($product->configurations()->count()) {
            if ($optionsP) {
                $options = $optionsP;
            } elseif ($product->first_options) {
                $options = $product->first_options;
            }
            if (!$options || (sizeof($options) != $product->configurations()->count())) {
                $response['msg'] = "Please select all options";
                return $response;
            }
        }
        if ($options) {
            $variation = $this->getVariationFromProudcts($product, $options);
            if ($variation) {
                $quantity = $variation->quantity;
            }
        }
        if (!$quantity) {
            $response['data'] = $product->only(['id', 'title', 'slug']);
            $response['msg'] = __('cart.out_of_stock');
            return $response;
        }
        $cartItem = $this->cartItem($product, $variation, $options, $cart);
        if ($cartItem) {
            if (($cartItem->quantity + $quantityP) > $quantity) {
                $response['data'] = $product->only(['id', 'title', 'slug']);
                $response['msg'] = __('cart.quantity_not_found', ['quantity' => $quantity]);
                return $response;
            }
            $cartItem->increment('quantity', $quantityP);
        } else {
            if ($quantityP > $quantity) {
                $response['data'] = $product->only(['id', 'title', 'slug']);
                $response['msg'] = __('cart.quantity_not_found', ['quantity' => $quantity]);
                return $response;
            }

            if (!$cart) {
                $cart_basket = $product->basket()->create([
                    'quantity' => $quantityP,
                    'variation_id' => $variation ? $variation->id : null,
                    'variation_price' => $variation ? $variation->regular_price : null
                ]);
            } else {
                $cart_basket = $product->basket()->create([
                    'quantity' => $quantityP,
                    'variation_id' => $variation ? $variation->id : null,
                    'variation_price' => $variation ? $variation->regular_price : null,
                    'cart_id' => $cart->id
                ]);
            }

            if ($options) {
                foreach ($options as $optionKey => $option) {
                    $cart_basket->options()->create([
                        'option_id' => $option,
                        'sort_order' => $optionKey
                    ]);
                }
            }
        }

        $response['msg'] = __('cart.cart_added');
        $response['type'] = 'success';

        return $response;
    }

    private function checkOutOfStockProducts($products, $cart = null)
    {
        $response = [
            'type' => 'success',
            'msg' => 'No Out ofStock Products',
            'url' => null
        ];
        $productIds = array_column($products, 'id');
        $outOfStockProducts = Product::whereIn('id', $productIds)
            ->where('quantity', '0')
            ->get();
        if ($outOfStockProducts->count() > 0) {
            $response = [];
            $response["data"] = $outOfStockProducts->pluck('id')->toArray();
            $response['msg'] = __('cart.out_of_stock');
            $response['type'] = 'error';
        }
        return $response;
    }

    private function addToMultipleCart($products, $cart = null)
    {
        $shipping_cost = 0;
        foreach ($products as $cartProduct) {
            $product = Product::findOrFail($cartProduct['id'] ?? '');
            $cartResponse = $this->addToCart($product, $cartProduct['quantity'] ?? 1, $cartProduct['options'] ?? [], $cart);
            if ($cartResponse['type'] == 'error') {
                $cart = $cart ?? $this->getCart();
                $cart->doEmptyCart();
                return $cartResponse;
            }

            if ($product->shipping_cost) {
                $shipping_cost = $shipping_cost + $product->shipping_cost * $cartProduct['quantity'] ?? 1;
            }
        }

        if ($product->shipping_cost) {
            $shipping = [
                "price" => $shipping_cost
            ];

            $cart = $cart ?? $this->getCart();

            if ($cart) {
                $cart->update([
                    'shipping_info' => $shipping
                ]);
            }
        }
        return [
            'msg' => __('cart.cart_added'),
            'type' => 'success',
            'url' => null,
        ];
    }

    private function applyCouponCode(Cart $cart, $code, $products = [], $apply = false)
    {
        $response = [
            'type' => 'error',
            'msg' => 'Something went to wrong',
            'url' => null
        ];
        $error = null;
        $coupon = Coupon::where('code', $code)->isActive()->isValid()->first();
        if (!$coupon) {
            $error = 'invalid_coupon';
        } elseif (!$coupon->isUsable()) {
            $error = 'coupon_usage_exceed';
        } elseif (!$coupon->isUsableByCart($cart)) {
            $error = 'coupon_not_applicable_for_cart';
        } elseif (!$coupon->isUsablePerCoupon()) {
            $error = 'coupon_usage_exceed';
        } elseif (!$coupon->isUsableByProducts($products)) {
            $error = 'coupon_not_valid_for_category_or_product';
        } elseif (!$coupon->isUsableByCategories($products)) {
            $error = 'coupon_not_valid_for_category_or_product';
        }
        // elseif ($coupon->applicableDiscountCart($cart) < 0 || $coupon->applicableDiscountCart($cart) >= $cart->sub_total || $coupon->applicableDiscountCart($cart) == $cart->sub_total) {
        //     $error = 'coupon_amount_exceed';
        // }
        if ($error) {
            $config = ConfigData::findByType($error);
            $error_msg = $config->value ?? 'Error';
            if ($error == 'coupon_not_applicable_for_cart') {
                $error_msg = str_replace('{{target}}', $coupon->min_order, $error_msg);
            }
            $response['msg'] = $error_msg;
            return $response;
        }

        if ($apply) {
            $cart->update(['coupon_id' => $coupon->id]);
            $response['msg'] = 'Coupon code applied';
        } else {
            $response['msg'] = 'Coupon is valid.';
        }


        $response['type'] = 'success';
        $response['data'] = $this->getCartResponse();
        $response['data']['coupon'] = $coupon;

        return $response;
    }

    private function applyRewardPoint(Cart $cart, $points, $apply = true)
    {
        $response = [
            'type' => 'error',
            'msg' => 'Something went to wrong',
            'url' => null
        ];

        // Check auth

        if (!auth()->check()) {
            $response['msg'] = "Not Authenticated.";
            return $response;
        } elseif (auth()->user()->total_reward_points < (integer) $points) {
            // $response['data'] = [auth()->user()->total_reward_points, (int) $points];
            $response['msg'] = "You do not have enough points.";
            return $response;
        }

        // On cart apply, make sure the total is correct

        // Add cart field

        if ($apply) {
            $cart->update(['use_points' => true, 'points_used' => (int) $points]);
            $response['msg'] = 'Reward point applied.';
        } else {
            $response['msg'] = 'Coupon is valid.';
        }

        $response['data'] = $this->getCartResponse();
        $response['type'] = 'success';

        return $response;
    }
}
