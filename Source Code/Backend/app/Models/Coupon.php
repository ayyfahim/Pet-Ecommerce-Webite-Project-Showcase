<?php

namespace App\Models;

use App\Models\Traits\HasCategories;
use App\Models\Traits\HasDiscount;
use App\Models\Traits\HasStatus;
use App\Models\Traits\HasSoftDeletes;

class Coupon extends BaseModel
{
    use HasStatus, HasSoftDeletes, HasDiscount, HasCategories;
    protected $dates = [
        'from',
        'to',
    ];

    public function applicableDiscount(Cart $cart)
    {
        return $this->calculateDiscount($cart->sub_total);
    }

    public function products()
    {
        return $this->hasMany(CouponProduct::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function getOrdersAttribute()
    {
        $ids = $this->carts->pluck('order.id');
        return Order::where('is_temp', false)->whereIn('id', $ids)->get();
    }
    public function isUsableByProducts($products = [])
    {
        if (empty($products))
            return true;
        if ($this->products->count() <= 0)
            return true;

        $productIds = \Illuminate\Support\Arr::pluck($products, 'id');
        $couponProductIds = $this->products->pluck('product_id')->toArray();
        return empty(array_diff($productIds, $couponProductIds));
    }

    public function isUsableByCategories($products = [])
    {
        if (empty($products))
            return true;

        if ($this->categories->count() <= 0)
            return true;

        $couponCategoryIds = $this->categories->pluck('id')->toArray();

        foreach ($products as $cartProduct) {
            $prodCategoryIds = Product::findOrFail($cartProduct['id'] ?? '')->categories_ids;
            if (empty(array_intersect($prodCategoryIds, $couponCategoryIds))) {
                return false;
            }
        }

        return true;
    }
}
