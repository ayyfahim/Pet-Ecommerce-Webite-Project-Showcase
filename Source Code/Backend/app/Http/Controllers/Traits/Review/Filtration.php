<?php

namespace App\Http\Controllers\Traits\Review;

use Carbon\Carbon;

trait Filtration
{
    protected function filterData($request, $collection)
    {
        $title = $request->q;
        $collection->when($title, function ($query) use ($title) {
            $query->whereHas('product', function ($query) use ($title) {
                $query->whereHas('info', function ($query) use ($title) {
                    $query->whereRaw('lower(title) like ?', ['%' . strtolower($title) . '%']);
                });
            });
            $query->orWhereHas('order', function ($query) use ($title) {
                $query->whereRaw('id like ?', ['%' . $title . '%']);
            });
            $query->orWhereHas('user', function ($query) use ($title) {
                $query->whereRaw('lower(concat(first_name, " ", last_name)) like ?', ['%' . strtolower($title) . '%']);
            });
        });

        return $collection;
    }
}
