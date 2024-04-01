<?php

namespace App\Models;

use App\Models\Traits\HasStatus;
use App\Models\Traits\HasSoftDeletes;

class SocialProvider extends BaseModel
{

    protected $fillable = ['provider', 'provider_id', 'user_id', 'avatar'];
    protected $hidden = ['created_at', 'updated_at'];
    
}
