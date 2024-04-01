<?php

namespace App\Services\PaymentGateways;

use App\Acme\Core;
use Illuminate\Support\Str;

trait CommonOpsTrait
{
    /**
     * formatAmount.
     *
     * @param mixed $amount
     * @return string
     */
    public function formatAmount($amount)
    {
        return (new Core())->currency($amount, 0, '.', '');
    }

    public function getTitle($item)
    {
        return Str::slug(substr($item->info->title, 0, 40));
    }

    public function getRefNumber($item)
    {
        return $item->id . "_" . rand(0, 99);
    }

    /**
     * getCancelUrl.
     *
     * @param $method
     * @param mixed $id
     * @return string
     */
    public function getCancelUrl($method, $type, $id)
    {
        return route('request.payment.callback_fail', [
            'method' => $method,
            'type' => $type,
            'serviceRequest' => $id
        ]);
    }

    /**
     * getReturnUrl.
     *
     * @param mixed $id
     * @return string
     */
    public function getReturnUrl($id)
    {
        return route('paymentHandler.callback_success', [
            'order_id' => $id,
        ]);

    }
}
