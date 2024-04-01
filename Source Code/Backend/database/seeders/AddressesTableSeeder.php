<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class AddressesTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\User::withRole('customer')->get();
        foreach ($users as $user) {
            foreach (range(1, 2) as $item) {
                $address = $user->addresses()->create([
                    'default' => faker()->randomElement([true, false])
                ]);
                foreach (range(1, 2) as $item) {
                    $address->infos()->create([
                        'title' => faker()->randomElement(['Home', 'Office', 'Work', 'Company']),
                        'name' => faker()->name,
                        'email' => faker()->email,
                        'phone' => faker()->phoneNumber,
                        'business_name' => faker()->company,
                        'street_address' => faker()->address,
                        'area' => faker()->word,
                        'city' => faker()->city,
                        'country' => "Australia",
                        'postal_code' => faker()->postcode,
                    ]);
                }
            }
        }
    }
}
