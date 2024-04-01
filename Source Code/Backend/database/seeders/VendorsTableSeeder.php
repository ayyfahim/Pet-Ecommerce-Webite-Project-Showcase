<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Vendor;

class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 20) as $item) {
            Vendor::create([
                'name' => faker()->sentence(rand(1, 3)),
                'contact_name' => faker()->sentence(rand(1, 3)),
                'email' => faker()->email,
                'contact_phone' => faker()->phoneNumber,
                'type' => faker()->randomElement(['Type #1','Type #2']),
            ]);
        }
    }
}
