<?php

namespace App\Transformers;

use App\Models\Address;
use App\Models\Brand;
use App\Models\Concern;
use App\Transformers\Traits\HasMap;

class ConcernTransformer extends BaseTransformer
{

    protected array $defaultIncludes = [
    ];
    protected array $availableIncludes = [
    ];

    /**
     * A Fractal transformer.
     *
     * @param Brand $brand
     * @return array
     */
    public function transform(Concern $concern)
    {
        return [
            'id' => $concern->id,
            'name' => $concern->name,
            'slug' => $concern->slug,
            'banner_title' => $concern->banner_title,
            'banner_description' => $concern->banner_description,
            'banner' => asset($concern->getUrlFor('badge')),
        ];
    }
}
