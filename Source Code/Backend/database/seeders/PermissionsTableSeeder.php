<?php
namespace Database\Seeders;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Seed the User's table data.
     */
    public function run()
    {
        $data = [
            [
                'name' => 'view_dashboard',
                'display_name' => 'View Dashboard',
                'group' => 'Dashboard',
            ],
            [
                'name' => 'view_customers',
                'display_name' => 'View Customers',
                'group' => 'Customers',
            ],
            [
                'name' => 'edit_customers',
                'display_name' => 'Edit Customers',
                'group' => 'Customers',
            ],
            [
                'name' => 'delete_customers',
                'display_name' => 'Delete Customers',
                'group' => 'Customers',
            ],
            [
                'name' => 'view_roles',
                'display_name' => 'View Roles',
                'group' => 'Roles',
            ],
            [
                'name' => 'add_roles',
                'display_name' => 'Add Roles',
                'group' => 'Roles',
            ],
            [
                'name' => 'edit_roles',
                'display_name' => 'Edit Roles',
                'group' => 'Roles',
            ],
            [
                'name' => 'delete_roles',
                'display_name' => 'Delete Roles',
                'group' => 'Roles',
            ],
            [
                'name' => 'view_admins',
                'display_name' => 'View Admins',
                'group' => 'Admins',
            ],
            [
                'name' => 'add_admins',
                'display_name' => 'Add Admins',
                'group' => 'Admins',
            ],
            [
                'name' => 'edit_admins',
                'display_name' => 'Edit Admins',
                'group' => 'Admins',
            ],
            [
                'name' => 'delete_admins',
                'display_name' => 'Delete Admins',
                'group' => 'Admins',
            ],
            [
                'name' => 'view_icons',
                'display_name' => 'View Icons',
                'group' => 'Icons',
            ],
            [
                'name' => 'add_icons',
                'display_name' => 'Add Icons',
                'group' => 'Icons',
            ],
            [
                'name' => 'edit_icons',
                'display_name' => 'Edit Icons',
                'group' => 'Icons',
            ],
            [
                'name' => 'delete_icons',
                'display_name' => 'Delete Icons',
                'group' => 'Icons',
            ],
            [
                'name' => 'view_products',
                'display_name' => 'View Products',
                'group' => 'Products',
            ],
            [
                'name' => 'add_products',
                'display_name' => 'Add Products',
                'group' => 'Products',
            ],
            [
                'name' => 'edit_products',
                'display_name' => 'Edit Products',
                'group' => 'Products',
            ],
            [
                'name' => 'delete_products',
                'display_name' => 'Delete Products',
                'group' => 'Products',
            ],
            [
                'name' => 'view_categories',
                'display_name' => 'View Categories',
                'group' => 'Categories',
            ],
            [
                'name' => 'add_categories',
                'display_name' => 'Add Categories',
                'group' => 'Categories',
            ],
            [
                'name' => 'edit_categories',
                'display_name' => 'Edit Categories',
                'group' => 'Categories',
            ],
            [
                'name' => 'delete_categories',
                'display_name' => 'Delete Categories',
                'group' => 'Categories',
            ],
            [
                'name' => 'view_brands',
                'display_name' => 'View Brands',
                'group' => 'Brands',
            ],
            [
                'name' => 'add_brands',
                'display_name' => 'Add Brands',
                'group' => 'Brands',
            ],
            [
                'name' => 'edit_brands',
                'display_name' => 'Edit Brands',
                'group' => 'Brands',
            ],
            [
                'name' => 'delete_brands',
                'display_name' => 'Delete Brands',
                'group' => 'Brands',
            ],
            [
                'name' => 'view_vendors',
                'display_name' => 'View Suppliers',
                'group' => 'Suppliers',
            ],
            [
                'name' => 'add_vendors',
                'display_name' => 'Add Suppliers',
                'group' => 'Suppliers',
            ],
            [
                'name' => 'edit_vendors',
                'display_name' => 'Edit Suppliers',
                'group' => 'Suppliers',
            ],
            [
                'name' => 'delete_vendors',
                'display_name' => 'Delete Suppliers',
                'group' => 'Suppliers',
            ],
            [
                'name' => 'view_attributes',
                'display_name' => 'View Attributes',
                'group' => 'Attributes',
            ],
            [
                'name' => 'add_attributes',
                'display_name' => 'Add Attributes',
                'group' => 'Attributes',
            ],
            [
                'name' => 'edit_attributes',
                'display_name' => 'Edit Attributes',
                'group' => 'Attributes',
            ],
            [
                'name' => 'delete_attributes',
                'display_name' => 'Delete Attributes',
                'group' => 'Attributes',
            ],
            [
                'name' => 'view_orders',
                'display_name' => 'View Orders',
                'group' => 'Orders',
            ],
            [
                'name' => 'edit_orders',
                'display_name' => 'Edit Orders',
                'group' => 'Orders',
            ],
            [
                'name' => 'view_coupons',
                'display_name' => 'View Coupons',
                'group' => 'Coupons',
            ],
            [
                'name' => 'add_coupons',
                'display_name' => 'Add Coupons',
                'group' => 'Coupons',
            ],
            [
                'name' => 'edit_coupons',
                'display_name' => 'Edit Coupons',
                'group' => 'Coupons',
            ],
            [
                'name' => 'delete_coupons',
                'display_name' => 'Delete Coupons',
                'group' => 'Coupons',
            ],
            [
                'name' => 'view_reward_points',
                'display_name' => 'View Reward Points',
                'group' => 'Reward Points',
            ],
            [
                'name' => 'add_reward_points',
                'display_name' => 'Add Reward Points',
                'group' => 'Reward Points',
            ],
            [
                'name' => 'edit_reward_points',
                'display_name' => 'Edit Reward Points',
                'group' => 'Reward Points',
            ],
            [
                'name' => 'delete_reward_points',
                'display_name' => 'Delete Reward Points',
                'group' => 'Reward Points',
            ],
            [
                'name' => 'view_email_templates',
                'display_name' => 'View Email Templates',
                'group' => 'Content',
            ],
            [
                'name' => 'edit_email_templates',
                'display_name' => 'Edit Email Templates',
                'group' => 'Content',
            ],
            [
                'name' => 'view_pages',
                'display_name' => 'View Pages',
                'group' => 'Content',
            ],
            [
                'name' => 'add_pages',
                'display_name' => 'Add Pages',
                'group' => 'Content',
            ],
            [
                'name' => 'edit_pages',
                'display_name' => 'Edit Pages',
                'group' => 'Content',
            ],
            [
                'name' => 'delete_pages',
                'display_name' => 'Delete Pages',
                'group' => 'Content',
            ],
            [
                'name' => 'view_configurations',
                'display_name' => 'View Configurations',
                'group' => 'Configurations',
            ],
            [
                'name' => 'edit_configurations',
                'display_name' => 'Edit Configurations',
                'group' => 'Configurations',
            ],
        ];
        Permission::insert($data);
    }
}
