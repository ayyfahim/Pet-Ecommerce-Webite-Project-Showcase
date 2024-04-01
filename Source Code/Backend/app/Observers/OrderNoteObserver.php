<?php

namespace App\Observers;

use App\Models\OrderNote;

class OrderNoteObserver
{
    /**
     * Handle the package info "creating" event.
     *
     * @param OrderNote $order_note
     * @return void
     */
    public function creating(OrderNote $order_note)
    {
        $order_note->user_id = auth()->user()->id;
    }

    /**
     * Handle the package info "created" event.
     *
     * @param OrderNote $order_note
     * @return void
     */
    public function created(OrderNote $order_note)
    {
    }

    /**
     * Handle the package info "updating" event.
     *
     * @param OrderNote $order_note
     * @return void
     */
    public function updating(OrderNote $order_note)
    {
        //
    }
    /**
     * Handle the package info "updated" event.
     *
     * @param OrderNote $order_note
     * @return void
     */
    public function updated(OrderNote $order_note)
    {
        //
    }

    /**
     * Handle the package info "deleted" event.
     *
     * @param OrderNote $order_note
     * @return void
     */
    public function deleted(OrderNote $order_note)
    {
        //
    }

    /**
     * Handle the package info "restored" event.
     *
     * @param OrderNote $order_note
     * @return void
     */
    public function restored(OrderNote $order_note)
    {
        //
    }

    /**
     * Handle the package info "force deleted" event.
     *
     * @param OrderNote $order_note
     * @return void
     */
    public function forceDeleted(OrderNote $order_note)
    {
        //
    }
}
