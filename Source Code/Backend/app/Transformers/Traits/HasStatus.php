<?php

namespace App\Transformers\Traits;

use App\Transformers\StatusTransformer;

trait HasStatus
{
    protected function getStatus($item)
    {
        return fractal($item, StatusTransformer::class)->toArray()['data'];
    }
}
