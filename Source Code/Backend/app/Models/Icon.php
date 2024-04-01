<?php

namespace App\Models;

use App\Models\Traits\HasMedia;
use App\Models\Traits\HasStatus;
use App\Models\Traits\HasSoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia as HasMediaContract;

class Icon extends BaseModel implements HasMediaContract
{
    use HasStatus, HasSoftDeletes, HasMedia;

    public function getBadgeAttribute()
    {
        return $this->getFirstMedia('badge');
    }
}
