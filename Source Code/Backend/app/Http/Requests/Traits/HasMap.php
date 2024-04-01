<?php

namespace App\Http\Requests\Traits;

trait HasMap
{
    protected function getLatRules()
    {
        return [
            'sometimes',
            'required',
//            $this->latRegex(),
        ];
    }

    protected function latRegex()
    {
        return 'regex:/^(\+|-)?(?:90(?:(?:\.0{1,8})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,8})?))$/';
    }

    protected function getLongRules()
    {
        return [
            'sometimes',
            'required',
//            $this->longRegex(),
        ];
    }

    protected function longRegex()
    {
        return 'regex:/^(\+|-)?(?:180(?:(?:\.0{1,8})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,8})?))$/';
    }
}
