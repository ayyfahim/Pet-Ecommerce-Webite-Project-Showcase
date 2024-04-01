<?php

namespace App\Models;

use App\User;
use App\Models\Traits\HasStatus;
use App\Models\Traits\HasSortings;

class StatusTrackingPoints extends BaseModel
{
    use HasStatus;


    /* ========================================================================== */
    /*                                  RELATIONS                                 */
    /* ========================================================================== */

    public function trackable()
    {
        return $this->morphTo();
    }


    public function getTrackableTypeClassAttribute()
    {
        return class_basename($this->trackable_type);
    }
}
