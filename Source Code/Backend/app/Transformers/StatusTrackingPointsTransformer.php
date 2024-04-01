<?php

namespace App\Transformers;

use App\Http\Controllers\EventController;
use App\Models\Event;
use App\Models\StatusTrackingPoints;
use App\Transformers\Traits\HasMap;

class StatusTrackingPointsTransformer extends BaseTransformer
{

    /**
     * A Fractal transformer.
     *
     * @param StatusTrackingPoints $statusTrackingPoints
     * @return array
     */
    public function transform(StatusTrackingPoints $statusTrackingPoints)
    {
        return [
            'status' => $this->getDirectData($statusTrackingPoints->status, StatusTransformer::class),
            'reason' => $statusTrackingPoints->reason ?: ''
        ];
    }
}
