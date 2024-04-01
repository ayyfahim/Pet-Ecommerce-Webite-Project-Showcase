<?php
namespace Database\Seeders;
use App\Models\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table((new \App\Models\Status())->getTable())->truncate();

        $activeStatus = [
            [
                'title' => 'Active',
                'color' => 'success',
            ],
            [
                'title' => 'Inactive',
                'color' => 'danger',
            ],
        ];
        $list = [
            'User' =>
                [
                    'status' => $activeStatus,
                ],
            'Icon' =>
                [
                    'status' => $activeStatus,
                ],
            'Attribute' =>
                [
                    'status' => $activeStatus,
                ],
            'Category' =>
                [
                    'status' => $activeStatus,
                ],
            'Product' =>
                [
                    'status' => $activeStatus,
                ],
            'Page' =>
                [
                    'status' => $activeStatus,
                ],
            'Order' => [
                'status' => [
                    [
                        'title' => 'Pending', //1,
                        'color' => 'warning',
                    ],
                    [
                        // 'title' => 'Shipped', //2,
                        'title' => 'Dispatched', //2,
                        'color' => 'primary',
                    ],
                    [
                        'title' => 'Delivered', //3,
                        'color' => 'success',
                    ],
                    [
                        'title' => 'Failed', //4,
                        'color' => 'danger',
                    ],
                    [
                        'title' => 'Cancelled', //5,
                        'color' => 'danger',
                    ],
                    [
                        'title' => 'Received', //6,
                        'color' => 'info',
                    ]
                ],
                'payment_method' => [
                    [
                        'title' => 'Online Payment', //1
                    ],
                ],
                'shipping_method' => [
                    [
                        'title' => 'Standard Shipping', //1
                        'color' => 'Takes 3-5 business days',
                    ],
                    [
                        'title' => 'Express Shipping', //2
                        'color' => 'Takes 1 business days',
                    ],
                ],
            ],
            'Coupon' =>
                [
                    'status' => $activeStatus,
                ],
            'Redirection' =>
                [
                    'status' => $activeStatus,
                ],
            'Vendor' =>
                [
                    'status' => $activeStatus,
                ],
            'Article' =>
                [
                    'status' => $activeStatus,
                ],
        ];

        foreach ($list as $model_name => $group_name) {
            foreach ($group_name as $key => $status) {
                for ($i = 0; $i < count($status); $i++) {
                    Status::create([
                        'model_name' => $model_name,
                        'group_name' => $key,
                        'order' => isset($status[$i]['order']) ? $status[$i]['order'] : $i + 1,
                        'title' => $status[$i]['title'],
                        'description' => $status[$i]['title'],
                        'color' => isset($status[$i]['color']) ? $status[$i]['color'] : null,
                        'is_active' => isset($status[$i]['is_active']) ? $status[$i]['is_active'] : true
                    ]);
                }
            }
        }
    }
}
