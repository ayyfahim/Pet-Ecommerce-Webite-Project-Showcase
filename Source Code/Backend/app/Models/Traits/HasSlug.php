<?php

namespace App\Models\Traits;


use Illuminate\Support\Str;

trait HasSlug
{
    public function setSlugAttribute($value)
    {
        if ($value) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }

    public function scopeFindBySlug($query, $slug)
    {
        return $query->where('slug', $slug)->firstOrFail();
    }
}
