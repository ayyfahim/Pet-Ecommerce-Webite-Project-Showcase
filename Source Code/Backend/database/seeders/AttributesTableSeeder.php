<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\Categorisable;

class AttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $attributes = ['Package', 'Size', 'Storage', 'Gender', 'Color', 'Volt'];
        foreach ($attributes as $item) {
            Attribute::create([
                'name' => $item,
                'status_id' => Attribute::getStatusFor('status')->firstWhere('order', 1)->id,
                'configured' => true,
                'category' => faker()->randomElement([true, false]),
                'product' => true,
            ]);
        }
    }
}
