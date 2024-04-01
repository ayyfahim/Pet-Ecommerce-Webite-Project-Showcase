<?php

namespace App\Models\Traits;

use App\Models\StatusTrackingPoints;

trait HasProgressTimeline
{
    public function statusTrackingPoints()
    {
        return $this->morphMany(StatusTrackingPoints::class, 'trackable')->orderBy('created_at');
    }
}
