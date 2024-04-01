<?php

namespace App\Models;


use App\Models\Traits\HasNotification;
use Illuminate\Database\Eloquent\Model;

class EmailNotificationTemplate extends Model
{
    use HasNotification;

    protected $guarded = ['id'];
}
