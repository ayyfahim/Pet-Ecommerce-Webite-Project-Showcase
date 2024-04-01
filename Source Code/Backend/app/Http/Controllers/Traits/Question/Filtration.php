<?php

namespace App\Http\Controllers\Traits\Question;

use Carbon\Carbon;

trait Filtration
{
    protected function filterData($request, $collection)
    {
        $title = $request->q;
        $category = $request->category == 'all' ? null : $request->category;
        $collection->when($category, function ($query) use ($category) {
            $query->where('category', $category);
        });
        $collection->when($title, function ($query) use ($title) {
            $query->where(function ($query) use ($title) {
                $query->orWhereRaw('lower(question) like ?', ['%' . strtolower($title) . '%']);
            });
        });

        return $collection;
    }
}
