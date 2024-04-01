<?php

namespace App\Http\Controllers\Traits;

trait ConcernFiltration
{
    protected function filterData($request, $collection)
    {
        $title = $request->q;
        $collection->when($title, function ($query) use ($title) {
            $query->where(function ($query) use ($title) {
                $query->orWhereRaw('lower(name) like ?', ['%' . strtolower($title) . '%']);
            });

        });

        return $collection;
    }
}
