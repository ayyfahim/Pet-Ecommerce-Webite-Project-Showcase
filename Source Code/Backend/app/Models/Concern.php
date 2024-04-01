<?php

namespace App\Models;

use App\Models\Traits\HasDefault;
use App\Models\Traits\HasMedia;
use App\Models\Traits\HasSlug;

use Spatie\MediaLibrary\HasMedia\HasMedia as HasMediaContract;

class Concern extends BaseModel implements HasMediaContract
{
    use HasMedia,
        HasSlug;

    public function getProductsAttribute()
    {
        return Product::whereHas('info', function ($query) {
            $query->concerns->where('concern_id', $this->id);
        })->get();
    }

    public function product_infos()
    {
        return $this->hasMany(ProductInfo::class);
    }
    public function order_products()
    {
        return $this->hasMany(OrderProduct::class);
    }
    /* ========================================================================== */
    /*                                  ACCESSORS                                 */
    /* ========================================================================== */

    public function getBadgeAttribute()
    {
        return $this->getFirstMedia('badge');
    }
    public function getBannerAttribute()
    {
        return $this->getFirstMedia('banner');
    }
}
