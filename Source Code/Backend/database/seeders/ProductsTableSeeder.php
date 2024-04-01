<?php
namespace Database\Seeders;
use App\Models\Attribute;
use App\Models\Icon;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductInfo;
use App\Models\Category;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $arr = Product::getStatusFor();
        for ($c = 1; $c < 25; $c++) {
            $faq = [];
            for ($j = 0; $j < rand(2, 5); $j++) {
                $faq[] = [
                    'question' => faker()->sentence,
                    'answer' => faker()->paragraph,
                ];
            }
            $title = faker()->sentence(rand(2, 5));
            $product = Product::create([
                'slug' => $title,
                'sku' => trimfy(strtoupper(faker()->slug), rand(6, 15), ''),
                'quantity' => rand(100, 100),
                'status_id' => $arr['status']->random()->id,
                'featured' => faker()->randomElement([true, false]),
            ]);
            $info = $product->info()->create([
                'title' => $title,
                'description' => faker()->paragraph(rand(2, 5)),
                'excerpt' => "Includes one year warranty.",
                'regular_price' => round(rand(1000, 10000), -3),
                'weight' => rand(400, 1000),
                'length' => rand(100, 500),
                'width' => rand(100, 500),
                'height' => rand(100, 500),
                'brand_id' => \App\Models\Brand::inRandomOrder()->first()->id,
                'vendor_id' => \App\Models\Vendor::inRandomOrder()->first()->id,
                'delivery_information' => faker()->sentence(rand(10, 30)),
                'warranty_information' => faker()->sentence(rand(10, 30)),
                'faq' => $faq,
            ]);
            foreach (Icon::get()->take(3) as $key => $icon) {
                $product->product_icons()->create([
                    'icon_id' => $icon->id,
                    'label' => faker()->sentence(rand(1, 2)),
                    'helper' => faker()->sentence(rand(2, 3)),
                    'listing' => $key == 0,
                    'enabled' => faker()->randomElement([true, false]),
                ]);
            }
            $info->update([
                'cost_price' => $info->regular_price - round(rand(300, 800), -2)
            ]);
            if (in_array($c, [1, 5, 10, 12, 6])) {
                $info->update([
                    'sale_price' => $info->regular_price - round(rand(100, 800), -2)
                ]);
            }
//            foreach (Attribute::isActive()->where('product', true)->orderByDesc('name')->limit(rand(2, 3))->get() as $attribute) {
            $attribute = Attribute::where('name', '!=', 'color')->first();
            $product_attribute = $product->attributes()->create([
                'attribute_id' => $attribute->id
            ]);
            for ($i = 1; $i <= rand(2, 5); $i++) {
                $product_attribute->configurations()->create([
                    'value' => $attribute->name == 'Color' ? faker()->hexColor : $product_attribute->attribute->name . ' #' . $i,
                ]);
                sleep(1);
            }
            $attribute = Attribute::where('name', 'color')->first();
            $product_attribute = $product->attributes()->create([
                'attribute_id' => $attribute->id
            ]);
            for ($i = 1; $i <= rand(2, 5); $i++) {
                $product_attribute->configurations()->create([
                    'value' => $attribute->name == 'Color' ? faker()->hexColor : $product_attribute->attribute->name . ' #' . $i,
                ]);
                sleep(1);
            }
//            }
            // category
            $info->categories()
                ->attach(Category::lastLevel()->inRandomOrder()->first()->id);
            $rand = rand(1, 7);
            $product = $product->fresh();
            if ($categories_ids = $product->categories_ids_attribute) {
                $data['categories_ids'] = $categories_ids;
            }
            if ($product->info->brand_id) {
                $data['brand_id'] = $product->info->brand_id;
            }
            $data['price'] = $product->info->price;
            $data['title'] = $product->info->title;
            $product->update($data);
            // media
            for ($ca = 1; $ca < 6; $ca++) {
                $main_c = rand(1, 5);
                $is_main = $ca == $main_c;
                $product->addHashedMedia(public_path('assets/admin/img/products/' . $ca . '.jpg'), true,
                    [
                        'alt' => faker()->sentence(rand(1, 3)),
                        'main' => $is_main
                    ])
                    ->preservingOriginal()
                    ->toMediaCollection('gallery');
            }
        }
    }
}
