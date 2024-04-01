<?php

namespace App\Transformers;

use Spatie\MediaLibrary\Models\Media;

class ImageTransformer extends BaseTransformer
{
    /**
     * A Fractal transformer.
     *
     * @param Media $media
     * @return array
     */
    public function transform(Media $media)
    {
        return [
            'id' => $media->id,
            'name' => $media->name,
            'url' => asset($media->getUrl()),
        ];
    }
}
