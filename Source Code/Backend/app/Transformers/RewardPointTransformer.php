<?php

namespace App\Transformers;

use App\Models\Address;
use App\Models\Brand;
use App\Models\RewardPoint;
use App\Transformers\Traits\HasMap;

class RewardPointTransformer extends BaseTransformer
{

    protected array $defaultIncludes = [
    ];
    protected array $availableIncludes = [
    ];

    /**
     * A Fractal transformer.
     *
     * @param Brand $brand
     * @return array
     */
    public function transform(RewardPoint $rewardPoint)
    {
        return [
            'id' => $rewardPoint->id,
            'invoice_link' => route('order.print', $rewardPoint?->order?->id),
            'event' => $rewardPoint->event,
            'point' => $rewardPoint->points,
            'total_items' => $rewardPoint->order->cart->basket->sum('quantity'),
            'order_total' => number_format($rewardPoint->order->amount, 2),
            'created_at' => $rewardPoint->created_at->format('d/m/y, h:i A')
        ];
    }
}
