<?php

namespace App\Observers;

use App\Http\Controllers\Traits\Order\HasEmails;
use App\Models\ConfigData;
use App\Models\RewardPoint;
use App\Notifications\SendNotification;

class RewardPointObserver
{
    use HasEmails;

    /**
     * Handle the package info "creating" event.
     *
     * @param RewardPoint $rewardpoint
     * @return void
     */
    public function creating(RewardPoint $rewardpoint)
    {
        $rewardpoint->exchange = ConfigData::findByType('reward_point_exchange')->value;
    }

    /**
     * Handle the package info "created" event.
     *
     * @param RewardPoint $rewardpoint
     * @return void
     */
    public function created(RewardPoint $rewardpoint)
    {
        if ($rewardpoint->order && $rewardpoint->points > 0) {
            $this->points_create($rewardpoint);
        }
    }

    /**
     * Handle the package info "updating" event.
     *
     * @param RewardPoint $rewardpoint
     * @return void
     */
    public function updating(RewardPoint $rewardpoint)
    {
        //
    }

    /**
     * Handle the package info "updated" event.
     *
     * @param RewardPoint $rewardpoint
     * @return void
     */
    public function updated(RewardPoint $rewardpoint)
    {
        //
    }

    /**
     * Handle the package info "deleted" event.
     *
     * @param RewardPoint $rewardpoint
     * @return void
     */
    public function deleted(RewardPoint $rewardpoint)
    {
        //
    }

    /**
     * Handle the package info "restored" event.
     *
     * @param RewardPoint $rewardpoint
     * @return void
     */
    public function restored(RewardPoint $rewardpoint)
    {
        //
    }

    /**
     * Handle the package info "force deleted" event.
     *
     * @param RewardPoint $rewardpoint
     * @return void
     */
    public function forceDeleted(RewardPoint $rewardpoint)
    {
        //
    }
}
