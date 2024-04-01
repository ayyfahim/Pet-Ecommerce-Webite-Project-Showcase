<?php

namespace App\Models;

use App\User;
use App\Models\Traits\HasOrder;

class Cart extends BaseModel
{
    protected $casts = [
        'is_ordered' => 'boolean',
        'discount' => 'boolean',
        'coupon_info' => 'array',
        'additional' => 'array',
        'shipping_info' => 'array',
        'reminder_notified' => 'boolean',
    ];

    /* ========================================================================== */
    /*                                  RELATIONS                                 */
    /* ========================================================================== */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function basket()
    {
        return $this->hasMany(CartBasket::class);
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function payment_method()
    {
        return $this->belongsTo(Status::class, 'payment_method_id');
    }
    public function shipping_method()
    {
        return $this->belongsTo(Status::class, 'shipping_method_id');
    }
    /* ========================================================================== */
    /*                                  SCOPES                                    */
    /* ========================================================================== */

    public function scopeIsOpened($query)
    {
        return $query->where('is_ordered', 0);
    }

    public function getSubTotalAttribute()
    {
        return $this->basket->sum('sub_total');
    }

    public function getVatAttribute()
    {
        return round((ConfigData::findByType('vat')->value * $this->sub_total) / 100, 0);
    }

    public function codFees()
    {
        if ($this->payment_method && $this->payment_method->order == 1) {
            return (float)ConfigData::findByType('cash_on_delivery_fees')->value;
        }
        return 0;
    }

    public function getPointsDiscountAttribute()
    {
        if ($this->use_points && isset($this->points_used)) {
            return -$this->user->getRewardPointsExchangeByPoints($this->points_used);
        }
        return 0;
    }

    public function getTotalQuantityAttribute()
    {
        return $this->basket->sum('quantity');
    }

    public function getTotalAttribute()
    {
        $discount = $this->points_discount;
        if ($this->discount_rule) {
            $discount += $this->discount_rule['amount'];
        }
        if ($this->coupon_info) {
            $discount += $this->coupon_info['amount'];
        }
        $shipping = 0;
        if ($this->shipping_info) {
            $shipping = $this->shipping_info['price'];
        }
        return ($this->sub_total + $shipping + $this->vat + $this->codFees()) + $discount;
    }

    public function doEmptyCart()
    {
        foreach ($this->basket as $basket) {
            $basket->options()->delete();
        };
        $this->basket()->delete();
    }

    public function clearDiscounts()
    {
        $this->update([
            'use_points' => false,
            'points_used' => 0,
            'coupon_id' => null,
            'coupon_info' => null,
        ]);
    }
}
