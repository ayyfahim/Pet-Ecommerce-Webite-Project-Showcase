<?php

namespace App\Observers;

use App\Models\Feed;

class FeedObserver
{
    /**
     * Handle the package info "creating" event.
     *
     * @param Feed $feed
     * @return void
     */
    public function creating(Feed $feed)
    {
//        $arr = Feed::getStatusFor();
//        $feed->status_id = $arr['status']->firstWhere('order', 1)->id;
    }

    /**
     * Handle the package info "created" event.
     *
     * @param Feed $feed
     * @return void
     */
    public function created(Feed $feed)
    {
    }

    /**
     * Handle the package info "updating" event.
     *
     * @param Feed $feed
     * @return void
     */
    public function updating(Feed $feed)
    {
    }

    /**
     * Handle the package info "updated" event.
     *
     * @param Feed $feed
     * @return void
     */
    public function updated(Feed $feed)
    {
    }

    /**
     * Handle the package info "deleted" event.
     *
     * @param Feed $feed
     * @return void
     */
    public function deleted(Feed $feed)
    {
        //
    }

    /**
     * Handle the package info "restored" event.
     *
     * @param Feed $feed
     * @return void
     */
    public function restored(Feed $feed)
    {
        //
    }

    /**
     * Handle the package info "force deleted" event.
     *
     * @param Feed $feed
     * @return void
     */
    public function forceDeleted(Feed $feed)
    {
        //
    }
}
