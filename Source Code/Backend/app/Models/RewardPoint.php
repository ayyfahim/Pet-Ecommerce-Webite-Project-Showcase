<?php

namespace App\Models;

use App\Models\Traits\HasSoftDeletes;
use App\Models\Traits\HasSortings;
use App\User;

class RewardPoint extends BaseModel
{
    use HasSoftDeletes, HasSortings;
    protected static $sorting_options = [3, 2];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function review()
    {
        return $this->belongsTo(Review::class);
    }

    public function getEventAttribute()
    {
        if ($this->order) {
            if ($this->points > 0) {
                return 'Earned From Order #' . $this->order->short_id;
            } else {
                return 'Redeemed For Order #' . $this->order->short_id;
            }
        } else {
            return $this->reason ?: 'Manual By Admin';
        }
    }
}
