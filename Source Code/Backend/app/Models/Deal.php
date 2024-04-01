<?php

namespace App\Models;

use App\Models\Traits\HasStatus;
use App\Models\Traits\HasSoftDeletes;

class Deal extends BaseModel
{
    use HasSoftDeletes;
    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
