<?php
/**
 * Created by PhpStorm.
 * User: Road9-2
 * Date: 8/20/2020
 * Time: 12:47 PM
 */

namespace App\Models\Traits;


use App\Models\RewardPoint;

trait HasRewardPoints
{

    public function reward_points()
    {
        return $this->hasMany(RewardPoint::class);
    }

    public function reward_point()
    {
        return $this->reward_points()->latest()->first();
    }

    public function get_earned_point()
    {
        return $this->reward_points()->where('points', '>', 0)->first() ? $this->reward_points()->where('points', '>', 0)->first()->points : null;
    }

    public function get_redeemed_point()
    {
        return $this->reward_points()->where('points', '<', 0)->first() ? $this->reward_points()->where('points', '<', 0)->first()->points : null;
    }
}