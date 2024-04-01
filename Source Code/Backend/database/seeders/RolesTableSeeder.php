<?php
namespace Database\Seeders;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Seed the User's table data.
     */
    public function run()
    {
        $list = [
            [
                'name' => 'admin',
                'display_name' => 'Super Admin',
            ],
            [
                'name' => 'customer',
                'display_name' => 'Customer',
            ],
            [
                'name' => 'viewer',
                'display_name' => 'Viewer',
            ],
        ];
        $role = Role::create([
            'name' => 'admin',
            'display_name' => 'Super Admin',
        ]);
        $role->attachPermissions(Permission::get());
        $role = Role::create([
            'name' => 'customer',
            'display_name' => 'Customer',
        ]);
        $role = Role::create([
            'name' => 'viewer',
            'display_name' => 'Viewer',
        ]);
        $role->attachPermissions(Permission::whereIn('name', [
            'view_dashboard', 'view_customers', 'view_icons', 'view_products', 'view_categories',
            'view_brands', 'view_attributes', 'view_email_templates', 'view_pages'
        ])->get());
        $role = Role::create([
            'name' => 'editor',
            'display_name' => 'Editor',
        ]);
        $role->attachPermissions(Permission::whereIn('name', [
            'view_dashboard', 'view_customers', 'view_icons', 'view_products', 'view_categories',
            'view_brands', 'view_attributes', 'view_email_templates', 'view_pages',
            'edit_customers', 'add_icons', 'edit_icons', 'add_products', 'edit_products', 'add_categories', 'edit_categories',
            'add_brands', 'edit_brands', 'add_attibutes', 'edit_attributes', 'add_email_templates', 'edit_pages',
        ])->get());
    }
}
