<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $guarded = ['id'];

    public function cities()
    {
        return $this->hasMany(City::class, 'country_code', 'iso2');
    }

    public function scopeCode($query, $value)
    {
        return $query->where('iso2', 'EG');
    }
}
