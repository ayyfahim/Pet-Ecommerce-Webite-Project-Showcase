<?php

namespace App\Http\Controllers\Traits;

trait CategoryFiltration
{
    protected function filterData($request, $collection)
    {
        $title = $request->q;
        $sub_categories = $request->sub_categories;
        $attributes = $request->attributes;
        $status_id = $request->status_id == 'all' ? null : $request->status_id;
        $collection->when($status_id, function ($query) use ($status_id) {
            $query->where('status_id', $status_id);
        });
        $collection->when($title, function ($query) use ($title) {
            $query->where(function ($query) use ($title) {
                $query->whereRaw('lower(name) like ?', ['%' . strtolower($title) . '%'])
                    ->orWhereHas('children', function ($query) use ($title) {
                        $query->whereRaw('lower(name) like ?', ['%' . strtolower($title) . '%']);
                        $query->orWhereHas('children', function ($query) use ($title) {
                            $query->whereRaw('lower(name) like ?', ['%' . strtolower($title) . '%']);
                        });
                    });
            });
        });
        $collection->when($sub_categories, function ($query) use ($sub_categories) {
            $query->where(function ($query) use ($sub_categories) {
                $query->whereHas('children', function ($query) use ($sub_categories) {
                    $query->whereIn('id', $sub_categories);
                });
            });
        });
        $collection->when($attributes, function ($query) use ($attributes) {
            $query->where(function ($query) use ($attributes) {
                $query->whereHas('configurations', function ($query) use ($attributes) {
                    foreach ($attributes as $key => $attribute) {
                        if ($key == 0) {
                            $query->whereRaw('lower(value) like ?', ['%' . strtolower($attribute) . '%']);
                        } else {
                            $query->orWhereRaw('lower(value) like ?', ['%' . strtolower($attribute) . '%']);
                        }
                    }
                });
            });
        });
        return $collection;
    }
}
