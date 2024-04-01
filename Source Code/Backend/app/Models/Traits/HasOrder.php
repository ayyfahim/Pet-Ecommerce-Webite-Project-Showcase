<?php

namespace App\Models\Traits;

use App\Models\Order;

trait HasOrder
{
    public function order()
    {
        return $this->morphOne(Order::class, 'orderable');
    }
}
