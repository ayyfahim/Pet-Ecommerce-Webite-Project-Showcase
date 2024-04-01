<?php


namespace App\Models\Traits;


use App\Models\RelatedAttribute;

trait HasAttributes
{
    public function specifications()
    {
        return $this->attributes()->whereHas('attribute', function ($query) {
            $query->where('configured', false);
        });
    }

    public function configurations()
    {
        return $this->attributes()->whereHas('attribute', function ($query) {
            $query->where('configured', true);
        })->whereHas('configurations');
    }
}
