<?php

namespace App\Transformers;

use App\Models\Cart;
use App\Models\ConfigData;
use App\Models\Product;
use App\Transformers\Traits\CartHelpers;
use App\Transformers\Traits\HasUser;
use App\Transformers\Traits\HasOrder;
use App\User;

class CartTransformer extends BaseTransformer
{
    use CartHelpers;

    protected array $defaultIncludes = [];

    protected array $availableIncludes = [
    ];
    private $changes = [];
    private $totals = false;

    public function __construct($changes = [], $totals = false)
    {
        $this->changes = $changes;
        $this->totals = $totals;
    }

    /**
     * A Fractal transformer.
     *
     * @param Cart $cart
     * @return array
     */
    public function transform(Cart $cart)
    {
        $questions = [];
        foreach ($cart->basket as $item) {
            if($item->product->info->additional){
                if ($additional = array_values($item->product->info->additional)) {
                    foreach ($additional as $additionalItem) {
                        if ($answers = explode(PHP_EOL, $additionalItem['answer'])) {
                            $questions[] = [
                                'question' => $additionalItem['question'],
                                'answers' => array_filter($answers)?$answers:'',
                            ];
                        }
                    }
                }
            }
        }
        $data = [
            'use_points' => $cart->use_points == true,
            'use_coupon' => $cart->coupon_id ? true : false,
            'answers_filled' => ($questions && $cart->additional),
            'shipping_method_id' => $cart->shipping_method_id,
            'items' => $this->getDirectData($cart->basket, CartBasketTransformer::class),
            'questions' => $questions,
            'additional' => $cart->additional,
            'totals' => $this->getTotals($cart),
            'points' => auth()->check() ? $this->getPoints($cart->user) : []
        ];
        return $data;
    }

    /* -------------------------------- helpers -------------------------------- */
    private function getPoints(User $user)
    {
        return [
            'total_reward_points' => $user->total_reward_points ?: 0,
            'total_reward_points_exchange' => $user->total_reward_points_exchange ?: 0,
        ];
    }
}
