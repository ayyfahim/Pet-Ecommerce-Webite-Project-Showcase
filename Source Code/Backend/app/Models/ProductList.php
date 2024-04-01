<?php

namespace App\Models;

use App\User;

class ProductList extends BaseModel
{
    protected $casts = ['out_of_stock_notified' => 'boolean'];
    public $types = ['wishlist', 'compare', 'clinic'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function product_info()
    {
        return $this->belongsTo(ProductInfo::class)->withTrashed();
    }
}
