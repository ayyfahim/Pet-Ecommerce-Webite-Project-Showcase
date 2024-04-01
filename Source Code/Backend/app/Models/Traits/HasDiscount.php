<?php


namespace App\Models\Traits;


use App\Models\Cart;

trait HasDiscount
{
    public function scopeIsValid($query)
    {
        return $query->whereDate('to', '>=', today()->toDateString())->whereDate('from', '<=', today()->toDateString());
    }
    public function getDiscountLabelAttribute()
    {
        if ($this->discount_type == 'Percentage') {
            return $this->discount_amount . "%";
        }
        return $this->discount_amount;
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function isUsable($user = null)
    {
        if ($this->uses_per_customer == -1) {
            return true;
        }
        if ($this->uses_per_customer == 0) {
            return false;
        }
        $user = $user ?: auth()->user();
        return $this->carts()->where('user_id', $user->id)->where('is_ordered', 1)->count() < $this->uses_per_customer;
    }
    public function isUsableByCart(Cart $cart)
    {
        if (!$this->min_order)
            return true;
        return $cart->sub_total >= $this->min_order;
    }
    public function isUsablePerCoupon($user = null)
    {
        if ($this->uses_per_coupon == -1) {
            return true;
        }
        if ($this->uses_per_coupon == 0) {
            return false;
        }
        $user = $user ?: auth()->user();
        if (!$user) {
            return true;
        }
        return $this->carts()->where('is_ordered', 1)->count() < $this->uses_per_coupon;
    }
    private function calculateDiscount($sub_total)
    {
        if ($this->discount_type == 'Percentage') {
            $discount = $this->discount_amount * $sub_total / 100;
        } else {
            $discount = $this->discount_amount;
        }
        return $discount;
    }
}
