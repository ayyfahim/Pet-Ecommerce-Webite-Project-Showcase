<?php

namespace App\Http\Controllers\Traits\Report;

trait Filtration
{
    protected function filterData($request, $collection)
    {
        $created_at_from = $request->created_at_from;
        $created_at_to = $request->created_at_to;
        $collection->when($created_at_from, function ($query) use ($created_at_from) {
            $query->where('created_at', '>=', $created_at_from);
        });
        $collection->when($created_at_to, function ($query) use ($created_at_to) {
            $query->where('created_at', '<=', $created_at_to);
        });
        return $collection;
    }
}
