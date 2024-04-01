<?php

namespace App\Models;

use App\Models\Traits\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMedia as HasMediaContract;

class Author extends BaseModel implements HasMediaContract
{
    use HasMedia;

    public function getAvatarAttribute()
    {
        return $this->getFirstMedia('avatar');
    }
}
