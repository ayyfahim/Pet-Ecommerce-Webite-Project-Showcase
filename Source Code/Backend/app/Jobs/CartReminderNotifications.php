<?php
/**
 * Created by PhpStorm.
 * User: Road9-2
 * Date: 11/28/2019
 * Time: 4:47 PM
 */

namespace App\Jobs;

use App\Models\DiscountRule;
use App\Notifications\SendNotification;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CartReminderNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $users = User::withRole('customer')->isActive()->whereHas('carts', function ($query) {
            $query->isOpened();
            $query->whereHas('basket', function ($query) {
                $query->where('created_at', '<', now()->subHours(1));
            });
        })->get();
        foreach ($users as $user) {
            new SendNotification('cart_reminder', $user, [
                'cart-link' => route('cart.index')
            ]);
        }
    }
}
