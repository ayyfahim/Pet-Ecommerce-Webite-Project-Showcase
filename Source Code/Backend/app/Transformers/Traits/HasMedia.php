<?php

namespace App\Transformers\Traits;

use App\Transformers\ImageTransformer;

trait HasMedia
{
    public function getMedia($collection, $single = true)
    {
        if ($collection) {
            return $single
                ? $this->getPrimitive($collection, new ImageTransformer())
                : $this->collection($collection, new ImageTransformer());
        }

        return $this->null();
    }
}
