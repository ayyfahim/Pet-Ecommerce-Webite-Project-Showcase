<?php

namespace App\Http\Controllers\Traits;

trait AttributeFiltration
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
                $query->whereRaw('lower(name) like ?', ['%' . strtolower($title) . '%']);
            });

        });

        return $collection;
    }
}
