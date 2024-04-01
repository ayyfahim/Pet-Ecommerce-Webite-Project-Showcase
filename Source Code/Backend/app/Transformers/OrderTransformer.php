<?php

namespace App\Transformers;

use App\Acme\Core;
use App\Models\Order;
use App\Transformers\Traits\CartHelpers;
use App\Transformers\Traits\HasUser;
use App\Transformers\Traits\HasStatus;

class OrderTransformer extends BaseTransformer
{
    use HasStatus, CartHelpers;
    protected $single;

    public function __construct($single = false)
    {
        $this->single = $single;
    }

    protected array $defaultIncludes = [
    ];

    protected array $availableIncludes = [
    ];

    /**
     * A Fractal transformer.
     *
     * @param Order $order
     * @return array
     */
    public function transform(Order $order)
    {
        $data = [
            'id' => $order->id,
            'short_id' => $order->short_id,
            'created_at' => $order->created_at->format('d/m/Y'),
            'status' => $this->getStatus($order->status),
            'totals' => $order->totals_info,
            'payment_status' => $order->payment_status,
            'invoice_link' => route('order.print', $order->id),
            'invoice_id' => $order->invoice_number,
            'total_reward_points_earned' => $order->get_earned_point(),
            'total_reward_points_redeemed' => $order->get_redeemed_point(),
            'total_reward_points_exchange' => isset($order->reward_point()?->exchange) ? $order->reward_point()?->exchange : 0,
        ];
        $data['address'] = $order->address_info ? fractal($order->address_info->address, new AddressTransformer())->toArray()['data'] : [];
        $data['products'] = $this->getDirectData($order->cart->basket, new CartBasketTransformer($this->single));

        return $data;
    }

    /* -------------------------------- relation -------------------------------- */

}
