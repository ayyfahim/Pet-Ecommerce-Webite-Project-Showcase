<?php

namespace App\Transformers;

use App\Models\Address;
use App\Models\Brand;
use App\Models\ConfigData;
use App\Transformers\Traits\HasMap;

class ConfigTransformer extends BaseTransformer
{

    protected array $defaultIncludes = [
    ];
    protected array $availableIncludes = [
    ];

    /**
     * A Fractal transformer.
     *
     * @param ConfigData $configData
     * @return array
     */
    public function transform(ConfigData $configData)
    {
        return [
            'type' => $configData->title,
            'value' => $configData->cover ? asset($configData->cover->getUrl()) : $configData->value,
        ];
    }
}
