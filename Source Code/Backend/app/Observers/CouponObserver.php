<?php

namespace App\Observers;

use App\Models\Coupon;

class CouponObserver
{
    /**
     * Handle the order "creating" event.
     * @param Coupon $coupon
     */
    public function creating(Coupon $coupon)
    {
        if (!$coupon->status_id) {
            $arr = Coupon::getStatusFor();
            $coupon->status_id = $arr['status']->firstWhere('order', 1)->id;
        }
    }

    /**
     * Handle the coupon "created" event.
     *
     * @param Coupon $coupon
     */
    public function created(Coupon $coupon)
    {
    }

    /**
     * Handle the coupon "updated" event.
     *
     * @param Coupon $coupon
     */
    public function updated(Coupon $coupon)
    {

    }

    /**
     * Handle the coupon "deleted" event.
     *
     * @param Coupon $coupon
     */
    public function deleted(Coupon $coupon)
    {
    }

    /**
     * Handle the coupon "restored" event.
     *
     * @param Coupon $coupon
     */
    public function restored(Coupon $coupon)
    {
    }

    /**
     * Handle the coupon "force deleted" event.
     *
     * @param Coupon $coupon
     */
    public function forceDeleted(Coupon $coupon)
    {
    }
}
