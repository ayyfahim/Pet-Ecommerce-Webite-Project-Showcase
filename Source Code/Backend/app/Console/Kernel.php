<?php

namespace App\Console;

use App\Jobs\AdminProductOutOfStockNotifications;
use App\Jobs\AdminSyncProducts;
use App\Jobs\CartReminderNotifications;
use App\Jobs\EventNotifications;
use App\Jobs\GroupedProductNotifications;
use App\Jobs\HotDealNotifications;
use App\Jobs\PointsReminderNotifications;
use App\Jobs\ProductOutOfStockNotifications;
use App\Jobs\ProductUpdatedNotifications;
use App\Jobs\ReviewReminderNotifications;
use App\Jobs\SendEventNotifications;
use App\Jobs\WishlistReminderNotifications;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     */
    protected function schedule(Schedule $schedule)
    {
        $this->minutely($schedule);
        $this->hourly($schedule);
        $this->daily($schedule);
        $this->weekly($schedule);

    }

    protected function minutely($schedule)
    {
    }

    protected function hourly($schedule)
    {
        $schedule->job(new CartReminderNotifications())->hourly();
//        $schedule->command('translation_sheet:sync')->hourly();
    }

    protected function daily($schedule)
    {
        $schedule->job(new ProductOutOfStockNotifications())->daily();
        $schedule->job(new AdminProductOutOfStockNotifications())->daily();
    }

    protected function weekly($schedule)
    {
    }

    protected function monthly($schedule)
    {
//        $schedule->job(new PointsReminderNotifications())->monthly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
