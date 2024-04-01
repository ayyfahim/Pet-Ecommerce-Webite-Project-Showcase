<?php

namespace App\Transformers;

use App\Models\Address;
use App\Models\Article;
use App\Models\FrontendAboutUs;
use App\Models\FrontendHomepage;
use App\Models\FrontendRewardProgram;
use App\Models\PetType;
use Illuminate\Support\Str;
use App\Transformers\Traits\HasMap;

class PetTypeTransformer extends BaseTransformer
{

    protected array $defaultIncludes = [
    ];
    protected array $availableIncludes = [
    ];

    /**
     * A Fractal transformer.
     *
     * @param Article $article
     * @return array
     */
    public function transform(PetType $pet)
    {
        return [
            'id' => $pet->id,
            'name' => $pet->name,
            'cover' => $pet->badge ? asset($pet->badge->getUrl()) : '',
        ];
    }
}
