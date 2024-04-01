<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CartBasket extends BaseModel
{
    protected $table = 'cart_product';

    /* ========================================================================== */
    /*                                  RELATIONS                                 */
    /* ========================================================================== */

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function product_info()
    {
        return $this->belongsTo(ProductInfo::class);
    }

    public function variation()
    {
        return $this->belongsTo(Variation::class);
    }

    public function options()
    {
        return $this->hasMany(CartBasketOption::class, 'cart_product_id');
    }

    public function getSubTotalAttribute()
    {
        return $this->quantity * $this->price;
    }
    public function getPriceAttribute()
    {
        // return $this->variation_price ?: $this->product_info->price;
        return $this->product_info->price;
    }

    public function getProductQuantityAttribute()
    {
        if ($this->variation) {
            $quantity = $this->variation->quantity;
        } else {
            $quantity = $this->product->quantity;
        }
        return $quantity;
    }

    public function getReview()
    {
        $order = $this->cart->order;
        if ($order) {
            return $order->reviews()->where('product_id', $this->product_id)->first();
        }
    }
}
