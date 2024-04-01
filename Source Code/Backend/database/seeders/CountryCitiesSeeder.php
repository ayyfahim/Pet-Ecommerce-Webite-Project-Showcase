<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class CountryCitiesSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
        $countries = storage_path('countries.sql');
        DB::unprepared(file_get_contents($countries));
        $this->command->info('Country table seeded!');
        $cities = storage_path('cities.sql');
        DB::unprepared(file_get_contents($cities));
        $this->command->info('City table seeded!');
    }
}
