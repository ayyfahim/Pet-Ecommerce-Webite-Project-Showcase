<?php
namespace Database\Seeders;
use App\User;
use App\Models\Service;
use Illuminate\Database\Seeder;

class BookmarksTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run()
    {
        for ($i = 0; $i < 20; $i++) {
            User::inRandomOrder()
                ->first()
                ->bookmarks()
                ->attach(Service::inRandomOrder()->first()->id);
        }
    }
}
