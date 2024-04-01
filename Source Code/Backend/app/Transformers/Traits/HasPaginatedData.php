<?php

namespace App\Transformers\Traits;

use League\Fractal\Pagination\IlluminatePaginatorAdapter;

trait HasPaginatedData
{
    protected function getPaginatedData($collection, $transformer, bool $simple = true, array $metaData = [])
    {
        if ($simple) {
            return $this->collection($collection->getCollection(), $transformer)
                        ->setPaginator(new IlluminatePaginatorAdapter($collection))
                        ->setMeta($metaData);
        }

        return fractal($collection->getCollection(), $transformer)
                ->paginateWith(new IlluminatePaginatorAdapter($collection))
                ->addMeta($metaData)
                ->toArray();
    }
}
