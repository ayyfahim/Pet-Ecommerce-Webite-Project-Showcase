<?php
/**
 * Created by PhpStorm.
 * User: Road9-2
 * Date: 8/10/2020
 * Time: 4:53 PM
 */

namespace App\Http\Controllers\Traits;


use App\Models\Cart;
use App\Models\DiscountRule;
use App\Models\ProductInfo;

trait CartChanges
{
    private function applyCartChanges(Cart $cart)
    {
        $changes = [];
        foreach ($cart->basket as $cartBasket) {
            // deleted
            if (!$cartBasket->product) {
                $deletedProduct = ProductInfo::withTrashed()->where('id', $cartBasket->product_info->id)->first();
                $item['product_title'] = $deletedProduct ? $deletedProduct->title : '';
                $item['change'] = 'product_deleted';
                $changes[] = $item;
                $cartBasket->delete();
                continue;
            }
            // out of stock
            if ($cartBasket->product_quantity <= 0) {
                $item['product_title'] = $cartBasket->product->info->title;
                $item['change'] = 'out_of_stock';
                $changes[] = $item;
                $cartBasket->delete();
                continue;
            }
            // price updated
            if ($cartBasket->product->info->price != $cartBasket->price) {
                $item['product_title'] = $cartBasket->product->info->title;
                $item['change'] = 'price';
                $changes[] = $item;
                $cartBasket->update(['product_info_id' => $cartBasket->product->info->id]);
            }
            // quantity updated
            if ($cartBasket->quantity > $cartBasket->product_quantity) {
                $item['product_title'] = $cartBasket->product->info->title;
                $item['change'] = 'quantity';
                $cartBasket->update(['quantity' => $cartBasket->product_quantity]);
                $changes[] = $item;
            }
        }
        if ($coupon = $cart->coupon) {
            $couponInfo = null;
            if ($coupon->isUsable()) {
                if ($applicableDiscount = $coupon->applicableDiscount($cart)) {
                    $couponInfo = [
                        'label' => "Discount - $coupon->code",
                        'amount' => -$applicableDiscount
                    ];
                }
            }
            if ($couponInfo && $cart->coupon_info != $couponInfo) {
                $cart->update([
                    'coupon_info' => $couponInfo,
                ]);
            }
        } else {
            $cart->update([
                'coupon_info' => null,
            ]);
        }
        return $changes;
    }

    private function applyDiscountRules(Cart $cart)
    {
        if (auth()->check()) {
            // discount rule
            $discount_rule_id = null;
            $discountObj = null;
            $discount_rules = DiscountRule::isActive()->isValid()->orderByDesc('priority')->get();
            foreach ($discount_rules as $key => $discount_rule) {
                if ($discount_rule->isUsable()) {
                    if ($applicableDiscount = $discount_rule->applicableDiscount($cart)) {
                        $discount_rule_id = $discount_rule->id;
                        $discountObj = [
                            'label' => $discount_rule->title,
                            'amount' => -$applicableDiscount
                        ];
                        break;
                    }
                }
            }
            if ($cart->discount_rule_id != $discount_rule_id || $cart->discount_rule != $discountObj) {
                $cart->update([
                    'discount_rule_id' => $discount_rule_id,
                    'discount_rule' => $discountObj,
                ]);
            }

            // Coupon

        }
    }
}
