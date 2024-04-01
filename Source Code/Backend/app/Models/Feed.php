<?php

namespace App\Models;

use App\Models\Traits\HasStatus;
use App\Models\Traits\HasSoftDeletes;

class Feed extends BaseModel
{
    use HasStatus, HasSoftDeletes;
    protected $casts = [
        'fields' => 'array'
    ];
    protected $dates = ['next_run_at'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
