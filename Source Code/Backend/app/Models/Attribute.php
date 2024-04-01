<?php

namespace App\Models;

use App\Models\Traits\HasCategories;
use App\Models\Traits\HasStatus;


class Attribute extends BaseModel
{
    use HasStatus;
    protected $casts = [
        'configured' => 'boolean',
    ];

    public function related_attributes()
    {
        return $this->hasMany(RelatedAttribute::class);
    }
}
