<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        config(['mail.driver' => 'log']);

        // clear old stuff
//        Artisan::call('ex:clear');
        File::deleteDirectory(storage_path('app/public'));
        sleep(1); // time to breath
        File::makeDirectory(storage_path('app/public'));

        // Page::where([
        //     'title' => "Privacy Policy"
        // ])->first()->update([
        //     "slug" => "privacy-policy"
        // ]);
        // Page::where([
        //     'title' => "Terms and Conditions"
        // ])->first()->update([
        //     "slug" => "terms-and-conditions"
        // ]);
        // Page::where([
        //     'title' => "Refund Policy"
        // ])->first()->update([
        //     "slug" => "refund-policy"
        // ]);
        // Page::where([
        //     'title' => "Contact Us"
        // ])->first()->update([
        //     "slug" => "contact-us"
        // ]);

        // seed new data
        $this->call([
            // generic
            StatusesTableSeeder::class,
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            ConfigTableSeeder::class,
            // data
            UsersTableSeeder::class,
//            AddressesTableSeeder::class,
//            BrandsTableSeeder::class,
//            VendorsTableSeeder::class,
//            IconsTableSeeder::class,
            AttributesTableSeeder::class,
//            CategoriesTableSeeder::class,
            NotificationSeeder::class,
//            ProductsTableSeeder::class,
//            RewardTableSeeder::class,
            PagesTableSeeder::class,
//            QuestionsTableSeeder::class,
//            ShippingZonesTableSeeder::class
        ]);
    }
}
