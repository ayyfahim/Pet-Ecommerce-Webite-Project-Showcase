<?php

namespace App\Http\Controllers\Traits;

trait DiscountRuleFiltration
{
    protected function filterData($request, $collection)
    {
        $title = $request->q;
        $collection->when($title, function ($query) use ($title) {
            $query->where(function ($query) use ($title) {
                $query->whereRaw('lower(JSON_EXTRACT(title, "$.' . $this->getCurrentLocale() . '")) like "%' . strtolower($title) . '%"');
            });

        });

        return $collection;
    }
}
