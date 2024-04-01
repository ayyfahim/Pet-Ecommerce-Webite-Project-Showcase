<?php
namespace Database\Seeders;
use App\Models\SocialFeed;
use Illuminate\Database\Seeder;

class SocialFeedsTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        SocialFeed::create([
            'title' => 'Facebook',
            'frequency' => 24,
        ]);
        SocialFeed::create([
            'title' => 'Google',
            'frequency' => 24,
        ]);
    }
}
