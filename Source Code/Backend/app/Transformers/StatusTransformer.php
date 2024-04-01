<?php

namespace App\Transformers;

use App\Models\Status;

class StatusTransformer extends BaseTransformer
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Status $status)
    {
        return [
            'id' => $status->id,
            'color' => $status->color,
            'title' => $status->title,
        ];
    }
}
