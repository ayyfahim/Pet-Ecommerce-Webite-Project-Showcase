<?php

namespace App\Observers;

use App\Http\Controllers\Traits\CartHelpers;
use App\Models\CartBasket;

class CartBasketObserver
{
    use CartHelpers;
    /**
     * Handle the cart "creating" event.
     *
     * @param CartBasket $cartBasket
     */
    public function creating(CartBasket $cartBasket)
    {
        $cartBasket->product_info_id = $cartBasket->product->info->id;
        $cartBasket->cart_id = $this->getCart()->id;
    }

    /**
     * Handle the cart "created" event.
     *
     * @param CartBasket $cartBasket
     */
    public function created(CartBasket $cartBasket)
    {
    }

    /**
     * Handle the cart "updated" event.
     *
     * @param CartBasket $cartBasket
     */
    public function updated(CartBasket $cartBasket)
    {

    }

    /**
     * Handle the cart "deleted" event.
     *
     * @param CartBasket $cartBasket
     */
    public function deleted(CartBasket $cartBasket)
    {
    }

    /**
     * Handle the cart "restored" event.
     *
     * @param CartBasket $cartBasket
     */
    public function restored(CartBasket $cartBasket)
    {
    }

    /**
     * Handle the cart "force deleted" event.
     *
     * @param CartBasket $cartBasket
     */
    public function forceDeleted(CartBasket $cartBasket)
    {
    }
}
