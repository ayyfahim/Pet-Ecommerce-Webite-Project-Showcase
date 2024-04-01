<?php
/**
 * Created by PhpStorm.
 * User: Road9-2
 * Date: 8/10/2020
 * Time: 5:06 PM
 */

namespace App\Transformers\Traits;


use App\Models\Cart;
use App\Models\Product;

trait CartHelpers
{
    private function getProductData(Product $product, $price)
    {
        return [
            'id' => $product->id,
            'product_info_id' => $product->info->id,
            'slug' => $product->slug,
            'title' => $product->info->title,
            'price' => $price,
            'quantity' => $product->quantity,
            'in_stock' => $product->is_in_stock,
            'cover' => $product->cover ? asset($product->cover->getUrl()) : '',
        ];
    }

    private function getTotals(Cart $cart, $payment_method_id = null)
    {
        $discounts = [];
        if ($cart->use_points && $cart->points_discount) {
            $item['label'] = __('cart.reward_points');
            $item['amount'] = $cart->points_discount;
            $discounts[] = $item;
        }
        if ($cart->coupon && $cart->coupon_info) {
            $discounts[] = $cart->coupon_info;
        }
        return [
            'sub_total' => $cart->sub_total,
            'shipping' => $cart->shipping_info && $cart->shipping_method ? [
                'label' => $cart->shipping_method ? $cart->shipping_method->title : '',
                'amount' => 50
            ] : [],
            'vat' => $cart->vat,
            'cod' => $cart->codFees(),
            'discounts' => $discounts,
            'total' => $cart->total < 0 ? 0 : $cart->total
        ];
    }
}
