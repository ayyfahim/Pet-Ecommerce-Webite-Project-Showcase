<?php

namespace App\Http\Controllers\Traits\RewardPoint;

use Carbon\Carbon;

trait Filtration
{
    protected function filterData($request, $collection)
    {
        $title = $request->q;
        $collection->when($title, function ($query) use ($title) {
            $query->where(function ($query) use ($title) {
                $query->whereRaw('lower(full_name) like ?', ['%' . strtolower($title) . '%']);
                $query->orWhereRaw('lower(email) like ?', ['%' . strtolower($title) . '%']);
                $query->orWhereRaw('lower(mobile) like ?', ['%' . strtolower($title) . '%']);
            });
        });

        return $collection;
    }
}
