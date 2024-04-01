<?php

namespace App\Models;

class OrderProduct extends BaseModel
{
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getTotalAttribute()
    {
        return $this->amount * $this->quantity;
    }

    public function getParentCategoryAttribute()
    {
        return $this->category ? $this->category->parent : '';
    }
}
