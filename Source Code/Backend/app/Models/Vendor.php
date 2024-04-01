<?php

namespace App\Models;

use App\Models\Traits\HasCategories;
use App\Models\Traits\HasMedia;
use App\Models\Traits\HasStatus;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia\HasMedia as HasMediaContract;


class Vendor extends BaseModel implements HasMediaContract
{
    use Notifiable,HasStatus,HasMedia;

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function order_products()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function getCoverAttribute()
    {
        return $this->getFirstMedia('cover');
    }
}
