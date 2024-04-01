<?php

namespace App\Http\Controllers\Traits\Order;

use App\Models\Cart;
use App\Models\Order;
use App\Models\RfpProposal;
use App\Models\ServiceRequest;
use App\Transformers\AddressTransformer;
use App\Transformers\OrderTransformer;

trait Creation
{
    private function successResponse(Order $order, $valU_message = null)
    {
        return [
            'id' => $order->id,
            'short_id' => $order->short_id,
            'points' => $order->reward_points()->where('points', '>', 0)->sum('points'),
            'order' => fractal($order, new OrderTransformer(true)),
        ];
    }
}
