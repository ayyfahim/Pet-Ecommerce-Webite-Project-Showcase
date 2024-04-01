<?php

namespace App\Models;

use App\Models\Traits\HasStatus;
use App\Models\Traits\HasSoftDeletes;
use App\User;

class OrderNote extends BaseModel
{
    use HasStatus;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
