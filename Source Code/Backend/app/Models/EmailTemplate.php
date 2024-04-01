<?php

namespace App\Models;

use App\Models\Traits\HasStatus;
use App\Models\Traits\HasSoftDeletes;

class EmailTemplate extends BaseModel
{
    use HasStatus,HasSoftDeletes;
}
