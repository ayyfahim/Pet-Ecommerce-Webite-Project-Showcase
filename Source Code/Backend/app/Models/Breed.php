<?php

namespace App\Models;

use App\Models\Traits\HasDefault;
use App\Models\Traits\HasMedia;
use App\Models\Traits\HasSlug;

use Spatie\MediaLibrary\HasMedia\HasMedia as HasMediaContract;

class Breed extends BaseModel implements HasMediaContract
{
    use HasMedia,
        HasSlug;
    public static $animals = ['Cats', 'Dogs', 'Birds', 'Rabbits', 'Guinea Pigs', 'Fish'];

    public function getProductsAttribute()
    {
        return Product::whereHas('info', function ($query) {
            $query->where('breed_id', $this->id);
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
}
