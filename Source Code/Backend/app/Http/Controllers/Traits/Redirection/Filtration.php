<?php

namespace App\Http\Controllers\Traits\Redirection;

use Carbon\Carbon;

trait Filtration
{
    protected function filterData($request, $collection)
    {
        $title = $request->q;
        $status_id = $request->status_id == 'all' ? null : $request->status_id;
        $collection->when($status_id, function ($query) use ($status_id) {
            $query->where('status_id', $status_id);
        });
        $collection->when($title, function ($query) use ($title) {
            $query->where(function ($query) use ($title) {
                $query->whereRaw('lower(from) like ?', ['%' . strtolower($title) . '%']);
                $query->orWhereRaw('lower(to) like ?', ['%' . strtolower($title) . '%']);
            });
        });

        return $collection;
    }
}
