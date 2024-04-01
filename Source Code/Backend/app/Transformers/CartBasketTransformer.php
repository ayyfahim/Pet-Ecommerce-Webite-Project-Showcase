<?php

namespace App\Transformers;

use App\Models\Cart;
use App\Models\CartBasket;
use App\Models\Product;
use App\Transformers\Traits\CartHelpers;
use App\Transformers\Traits\HasUser;
use App\Transformers\Traits\HasOrder;

class CartBasketTransformer extends BaseTransformer
{
    use CartHelpers;
    protected $single;

    public function __construct($single = false)
    {
        $this->single = $single;
    }

    protected array $defaultIncludes = [];

    protected array $availableIncludes = [
    ];

    /**
     * A Fractal transformer.
     *
     * @param CartBasket $cartBasket
     * @return array
     */
    public function transform(CartBasket $cartBasket)
    {
        $price = $cartBasket->variation_price ?: $cartBasket->product->info->price;
        $data = [
            'id' => $cartBasket->id,
            'quantity' => $cartBasket->quantity,
            'product' => fractal($cartBasket->product, new ProductTransformer(false, true))->parseIncludes(['gallery'])->toArray()['data'],
            'variation_id' => $cartBasket->variation_id,
            'variation_options' => [],
            'total' => $cartBasket->quantity * $price,
        ];
        if ($cartBasket->options) {
            foreach ($cartBasket->options->sortBy('sort_order') as $option) {
                $data['variation_options'][] = [
                    'id' => $option->option_id,
                    // 'value' => $option->label ?? ''
                ];
            }
        }
        if ($this->single) {
//            $review = $cartBasket->getReview();
//            $order = $cartBasket->cart->order;
//            $auth = auth()->user();
//            $data['can_add_review'] = $order ? $auth->canReview($cartBasket->product_id, $order->id) : false;
//            $data['can_edit_review'] = $review ? $review->isEditable() : false;
//            $data['review'] = [];
//            if ($review) {
//                $data['review']['id'] = $review->id;
//                $data['review']['body'] = $review->body;
//                $data['review']['rate'] = $review->rate;
//            }
        }
        return $data;
    }

    /* -------------------------------- helpers -------------------------------- */
}
