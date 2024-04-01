<?php

namespace App\Models;

use App\Models\Traits\HasStatus;
use App\Models\Traits\HasSoftDeletes;
use Spatie\MediaLibrary\Models\Media;

class Variation extends BaseModel
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function options()
    {
        return $this->hasMany(VariationOption::class);
    }
}
