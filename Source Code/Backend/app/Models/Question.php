<?php

namespace App\Models;

use App\Models\Traits\HasStatus;
use App\Models\Traits\HasSoftDeletes;

class Question extends BaseModel
{
    public $categories = [
        'General Questions','Buying','My Account',
        'Customer Support','Shipping & Returns','Payments',
        'Company',
    ];
}
