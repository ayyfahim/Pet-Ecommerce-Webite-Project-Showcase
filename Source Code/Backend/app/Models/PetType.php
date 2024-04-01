<?php

namespace App\Models;

use App\Models\Traits\HasDefault;
use App\Models\Traits\HasMedia;
use App\Models\Traits\HasSlug;

use Spatie\MediaLibrary\HasMedia\HasMedia as HasMediaContract;

class PetType extends BaseModel implements HasMediaContract
{
    use HasMedia,
        HasSlug;

    public function breeds()
    {
        return $this->hasMany(Breed::class);
    }
    
    /* ========================================================================== */
    /*                                  ACCESSORS                                 */
    /* ========================================================================== */

    public function getBadgeAttribute()
    {
        return $this->getFirstMedia('badge');
    }
}
