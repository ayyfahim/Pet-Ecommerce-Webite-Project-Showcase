<?php

namespace App\Transformers;

use App\Models\Address;
use App\Models\Brand;
use App\Transformers\Traits\HasMap;

class BrandTransformer extends BaseTransformer
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
    public function transform(Brand $brand)
    {
        return [
            'id' => $brand->id,
            'name' => $brand->name,
            'badge' => $brand->badge ? asset($brand->badge->getUrl()) : '',
        ];
    }
}
