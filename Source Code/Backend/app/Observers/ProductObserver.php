<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    /**
     * Handle the order "creating" event.
     * @param Product $product
     */
    public function creating(Product $product)
    {
        if (!$product->status_id) {
            $arr = Product::getStatusFor();
            $product->status_id = $arr['status']->firstWhere('order', 1)->id;
        }
    }

    /**
     * Handle the product "created" event.
     *
     * @param Product $product
     */
    public function created(Product $product)
    {
    }

    /**
     * Handle the product "updating" event.
     *
     * @param Product $product
     */
    public function updating(Product $product)
    {
        if (auth()->check())
            $product->user_id = auth()->user()->id;
    }

    /**
     * Handle the product "updated" event.
     *
     * @param Product $product
     */
    public function updated(Product $product)
    {

    }

    /**
     * Handle the product "deleted" event.
     *
     * @param Product $product
     */
    public function deleted(Product $product)
    {
    }

    /**
     * Handle the product "restored" event.
     *
     * @param Product $product
     */
    public function restored(Product $product)
    {
    }

    /**
     * Handle the product "force deleted" event.
     *
     * @param Product $product
     */
    public function forceDeleted(Product $product)
    {
    }
}
