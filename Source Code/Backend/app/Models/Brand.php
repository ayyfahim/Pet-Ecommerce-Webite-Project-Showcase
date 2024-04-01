<?php

namespace App\Models;

use App\Models\Traits\HasDefault;
use App\Models\Traits\HasMedia;
use App\Models\Traits\HasSlug;

use Spatie\MediaLibrary\HasMedia\HasMedia as HasMediaContract;

class Brand extends BaseModel implements HasMediaContract
{
    use HasMedia,
        HasSlug,
        HasDefault;
    public $translatable = ['name'];
    public $casts = ['default' => 'boolean'];

    public function getProductsAttribute()
    {
        return Product::whereHas('info', function ($query) {
            $query->where('brand_id', $this->id);
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
