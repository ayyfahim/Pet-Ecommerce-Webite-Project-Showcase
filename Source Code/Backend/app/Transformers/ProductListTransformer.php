<?php

namespace App\Transformers;

use App\Models\ProductList;

class ProductListTransformer extends BaseTransformer
{

    protected array $defaultIncludes = [];

    /**
     * A Fractal transformer.
     *
     * @param ProductList $productList
     * @return array
     */
    public function transform(ProductList $productList)
    {
        return $this->getDirectData($productList->product,
            new ProductTransformer($productList->type == 'compare'));
        return [
            'id' => $productList->id,
            'type' => $productList->type,
            'product' => $this->getDirectData($productList->product,
                new ProductTransformer($productList->type == 'compare')),
        ];
    }
}
