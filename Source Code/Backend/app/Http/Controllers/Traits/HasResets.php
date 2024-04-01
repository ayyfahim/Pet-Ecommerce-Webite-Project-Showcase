<?php

namespace App\Http\Controllers\Traits;

trait HasResets
{
    protected function resetFilterFor($request, $arr)
    {
        foreach ($arr as $item) {
            if ($request->{$item} == 'all') {
                $request->offsetUnset($item);
            }
        }

        return $request;
    }
}
