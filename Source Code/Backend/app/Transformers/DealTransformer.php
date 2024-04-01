<?php

namespace App\Transformers;

use App\Models\Deal;

class DealTransformer extends BaseTransformer
{

    protected array $defaultIncludes = [];

    /**
     * A Fractal transformer.
     *
     * @param Deal $deal
     * @return array
     */
    public function transform(Deal $deal)
    {
        return $this->getDirectData($deal->product, new ProductTransformer());
        return [
            'id' => $deal->id,
            'title' => $deal->title,
            'price' => $deal->price,
            'expiry_date' => $deal->to,
            'product' => $this->getDirectData($deal->product, new ProductTransformer()),
        ];
    }
}
