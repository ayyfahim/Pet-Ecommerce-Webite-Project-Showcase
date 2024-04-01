<?php
namespace Database\Seeders;
use App\Models\Icon;
use Illuminate\Database\Seeder;

class IconsTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $config = Icon::getStatusFor();
        foreach (range(1, 4) as $item) {
            $icon = Icon::create([
                'title' => faker()->word,
                'status_id'=>$config['status']->random()->first()->id,
                'created_at' => now()->subDays(rand(1, 10)),
            ]);
            $icon->addHashedMedia(public_path('assets/admin/img/icons/' . $item . '.png'),true)
                ->preservingOriginal()
                ->toMediaCollection('badge');
        }
    }
}
