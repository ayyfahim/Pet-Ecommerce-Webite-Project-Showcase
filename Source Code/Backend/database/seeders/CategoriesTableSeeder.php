<?php
namespace Database\Seeders;
use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\MediaLibrary\Models\Media;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run()
    {
        foreach (range(1, 3) as $item) {
            $title = faker()->sentence(rand(1, 2));
            $cat = Category::create([
                'name' => $title,
                'slug' => $title,
                'description' => faker()->sentence(),
                'featured' => faker()->randomElement([true, false])
            ]);
            $cat->addHashedMedia(public_path('images/category-' . $item . '.png'), true)
                ->preservingOriginal()
                ->toMediaCollection('badge');
            $cat->addHashedMedia(public_path('images/category-' . $item . '.png'), true)
                ->preservingOriginal()
                ->toMediaCollection('icon');
            foreach (Attribute::isActive()->where('category', true)->where('name', '!=', 'color')->orderBy('name')->limit(rand(1, 2))->get() as $attribute) {
                $category_attribute = $cat->attributes()->create([
                    'attribute_id' => $attribute->id
                ]);
                for ($cat_c = 1; $cat_c <= rand(2, 4); $cat_c++) {
                    $category_attribute->configurations()->create([
                        'value' => $attribute->name == 'Color' ? faker()->hexColor : $category_attribute->attribute->name . ' #' . $cat_c,
                    ]);
                    sleep(1);
                }
            }
            for ($cat_a = 1; $cat_a < rand(3, 6); $cat_a++) {
                $title = faker()->sentence(rand(1, 2));
                $child = $cat->children()->create([
                    'name' => $title,
                    'slug' => $title,
                    'description' => faker()->sentence(),
                    'featured' => faker()->randomElement([true, false])
                ]);
                $child->addHashedMedia(public_path('assets/admin/img/details/' . rand(1, 5) . '.jpg'), true)
                    ->preservingOriginal()
                    ->toMediaCollection('badge');
                foreach (Attribute::isActive()->whereHas('related_attributes', function ($query) use ($cat) {
                    $query->where('category_id', $cat->id);
                })->where('category', true)->where('name', '!=', 'color')->orderBy('name')->limit(rand(1, 2))->get() as $attribute) {
                    $category_attribute = $child->attributes()->create([
                        'attribute_id' => $attribute->id
                    ]);
                    for ($child_c = 1; $child_c <= 2; $child_c++) {
                        $category_attribute->configurations()->create([
                            'value' => $attribute->name == 'Color' ? faker()->hexColor : $category_attribute->attribute->name . ' #' . $child_c,
                        ]);
                    }
                }
                for ($j = 1; $j < rand(3, 6); $j++) {
                    $title = faker()->sentence(rand(1, 2));
                    $childChild = $child->children()->create([
                        'name' => $title,
                        'slug' => $title,
                        'description' => faker()->sentence(),
                        'featured' => faker()->randomElement([true, false])
                    ]);
                    $childChild->addHashedMedia(public_path('assets/admin/img/details/' . rand(1, 5) . '.jpg'), true)
                        ->preservingOriginal()
                        ->toMediaCollection('badge');
                    foreach (Attribute::isActive()->whereHas('related_attributes', function ($query) use ($cat) {
                        $query->where('category_id', $cat->id);
                    })->where('category', true)->where('name', '!=', 'color')->orderBy('name')->limit(rand(1, 2))->get() as $attribute) {
                        $category_attribute = $childChild->attributes()->create([
                            'attribute_id' => $attribute->id
                        ]);
                        for ($c = 1; $c <= 2; $c++) {
                            $category_attribute->configurations()->create([
                                'value' => $attribute->name == 'Color' ? faker()->hexColor : $category_attribute->attribute->name . ' #' . $c,
                            ]);
                        }
                    }
                }
            }
        }
    }
}
