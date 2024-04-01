<?php

namespace App\Observers;

use App\Models\Cart;

class CartObserver
{
    /**
     * Handle the cart "created" event.
     *
     * @param \App\Cart $cart
     */
    public function created(Cart $cart)
    {
    }

    /**
     * Handle the cart "updated" event.
     *
     * @param \App\Cart $cart
     */
    public function updated(Cart $cart)
    {
        // create new cart when prev is closed
        if ($cart->wasChanged('is_ordered')) {
            if ($cart->is_ordered) {
                $cart->user->carts()->create(['additional'=>[]]);
            }
        }
    }

    /**
     * Handle the cart "deleted" event.
     *
     * @param \App\Cart $cart
     */
    public function deleted(Cart $cart)
    {
    }

    /**
     * Handle the cart "restored" event.
     *
     * @param \App\Cart $cart
     */
    public function restored(Cart $cart)
    {
    }

    /**
     * Handle the cart "force deleted" event.
     *
     * @param \App\Cart $cart
     */
    public function forceDeleted(Cart $cart)
    {
    }
}
