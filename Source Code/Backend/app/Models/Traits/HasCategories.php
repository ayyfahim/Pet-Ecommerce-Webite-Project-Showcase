<?php

namespace App\Models\Traits;

use App\Models\Category;

trait HasCategories
{
    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorisable');
    }

    public function getCategoryAttribute()
    {
        return $this->categories()->latest()->first();
    }

    public function getParentCategoryAttribute()
    {
        return $this->category ? $this->category->parent : null;
    }
}
