<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Vendor;

class RewardTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::where('email', 'customer@dealaday.co.nz')->first();
        $user->reward_points()->create([
            'points' => 2087
        ]);
    }
}
