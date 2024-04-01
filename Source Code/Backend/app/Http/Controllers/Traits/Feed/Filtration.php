<?php

namespace App\Http\Controllers\Traits\Feed;

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
                $query->orWhereRaw('lower(title) like ?', ['%' . strtolower($title) . '%']);
            });
        });

        return $collection;
    }
}
