<?php

namespace App\Models\Traits;

trait HasDefault
{
    public function scopeIsSearchable($query)
    {
        return $query->where('default', false);
    }
}
