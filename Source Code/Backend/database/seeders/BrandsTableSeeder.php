<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 20) as $item) {
            Brand::create([
                'name' => faker()->word,
                'created_at' => now()->subDays(rand(1, 10)),
            ]);
        }
    }
}
