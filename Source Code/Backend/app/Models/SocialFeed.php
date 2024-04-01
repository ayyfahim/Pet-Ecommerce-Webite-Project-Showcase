<?php

namespace App\Models;

use App\Models\Traits\HasStatus;
use App\Models\Traits\HasSoftDeletes;

class SocialFeed extends BaseModel
{
    protected $dates = ['next_run_at'];
    protected $casts = [
        'excluded_categories' => 'array',
        'excluded_products' => 'array',
        'enabled' => 'boolean'
    ];
}
