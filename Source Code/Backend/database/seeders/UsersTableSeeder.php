<?php
namespace Database\Seeders;
use App\Models\Permission;
use App\User;
use App\Acme\Core;
use Illuminate\Database\Seeder;
use Zizaco\Entrust\EntrustRole as Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run()
    {
        // Admin
        $user = User::create([
            'full_name' => "DealADay Admin",
            'email' => "admin@dealaday.co.nz",
            'mobile' => faker()->phoneNumber,
            'password' => 'secret',
            'email_verified_at' => now(),
        ]);
        $user->attachRoleOf('admin');
        // Viewer
        $user = User::create([
            'full_name' => "DealADay Viewer",
            'email' => "viewer@dealaday.co.nz",
            'mobile' => faker()->phoneNumber,
            'password' => 'secret',
            'email_verified_at' => now(),
        ]);
        $user->attachRoleOf('viewer');
        // Editor
        $user = User::create([
            'full_name' => "DealADay Editor",
            'email' => "editor@dealaday.co.nz",
            'mobile' => faker()->phoneNumber,
            'password' => 'secret',
            'email_verified_at' => now(),
        ]);
        $user->attachRoleOf('editor');
//        // Customers
//        $user = User::create([
//            'full_name' => 'DealADay Customer',
//            'email' => 'customer@dealaday.co.nz',
//            'mobile' => faker()->phoneNumber,
//            'password' => 'secret',
//            'email_verified_at' => now(),
//        ]);
//        // role
//        $user->attachRoleOf('customer');
//        for ($i = 0; $i < 10; $i++) {
//            $user = User::create([
//                'full_name' => faker()->name,
//                'email' => faker()->email,
//                'mobile' => faker()->phoneNumber,
//                'password' => 'secret',
//                'email_verified_at' => now(),
//            ]);
//            // role
//            $user->attachRoleOf('customer');
//        }

    }
}
