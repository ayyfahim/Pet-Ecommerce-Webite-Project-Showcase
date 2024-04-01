<?php

namespace App\Observers;

use App\Notifications\SendNotification;
use App\User;
use App\Models\PackageInfo;
use App\Notifications\SendMobileVerificationCodeSms;

class UserObserver
{
    /**
     * Handle the order "creating" event.
     */
    public function creating(User $user)
    {
        $arr = User::getStatusFor();
        $user->status_id = $user->status_id?:$arr['status']->firstWhere('order', 1)->id;

    }

    /**
     * Handle the user "created" event.
     *
     * @return [type] [description]
     */
    public function created(User $user)
    {
        // auto create cart
        if (!$user->carts()->count())
            $user->carts()->create();

        if (!app()->runningInConsole()) {
            // notify for email verification
            if (!$user->hasVerifiedEmail()) {
                $user->sendEmailVerificationNotification();
            }
        }
    }

    /**
     * Handle the user "updated" event.
     */
    public function updated(User $user)
    {

    }

    /**
     * Handle the user "deleted" event.
     */
    public function deleted(User $user)
    {
    }

    /**
     * Handle the user "restored" event.
     */
    public function restored(User $user)
    {
    }

    /**
     * Handle the user "force deleted" event.
     */
    public function forceDeleted(User $user)
    {
    }
}
