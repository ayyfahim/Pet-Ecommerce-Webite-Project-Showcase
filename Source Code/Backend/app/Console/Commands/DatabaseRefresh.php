<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class DatabaseRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reseeding important data';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Artisan::call('db:seed --class=StatusesTableSeeder');
//        Artisan::call('db:seed --class=NotificationSeeder');
//        Artisan::call('db:seed --class=ConfigTableSeeder');
        $this->info('Database Refreshed Successfully');
    }
}
