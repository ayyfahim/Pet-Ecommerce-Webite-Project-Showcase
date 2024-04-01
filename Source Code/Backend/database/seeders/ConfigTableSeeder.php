<?php
namespace Database\Seeders;
use App\User;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run()
    {
        DB::table((new \App\Models\ConfigData())->getTable())->truncate();
        $config_data = [
            [
                'title' => 'title',
                'group' => 'site_settings',
                'order' => 1,
            ],
            [
                'title' => 'logo',
                'type' => 'file',
                'group' => 'site_settings',
                'order' => 3,
            ],
            [
                'title' => 'favicon',
                'type' => 'file',
                'group' => 'site_settings',
                'order' => 4,
            ],
            [
                'title' => 'address',
                'type' => 'textarea',
                'group' => 'contact',
                'order' => 1,
            ],
            [
                'title' => 'contact_numbers',
                'type' => 'textarea',
                'group' => 'contact',
                'order' => 2,
            ],
            [
                'title' => 'emails',
                'type' => 'textarea',
                'group' => 'contact',
                'order' => 3,
            ],
            [
                'title' => 'facebook',
                'group' => 'social_media',
                'order' => 1,
            ],
            [
                'title' => 'instagram',
                'group' => 'social_media',
                'order' => 2,
            ],
            [
                'title' => 'twitter',
                'group' => 'social_media',
                'order' => 3,
            ],
            [
                'title' => 'linkedin',
                'group' => 'social_media',
                'order' => 4,
            ],
            [
                'title' => 'order_reward_point',
                'group' => 'checkout',
                'value' => 10,
                'order' => 1,
            ],
            [
                'title' => 'reward_point_exchange',
                'group' => 'checkout',
                'value' => 0.073,
                'order' => 2,
            ],
            [
                'title' => 'vat',
                'group' => 'checkout',
                'order' => 3,
            ],
            [
                'title' => 'meta_title',
                'group' => 'seo',
                'order' => 1,
            ],
            [
                'title' => 'meta_keywords',
                'group' => 'seo',
                'type' => 'tags',
                'order' => 2
            ],
            [
                'title' => 'meta_description',
                'group' => 'seo',
                'type' => 'textarea',
                'order' => 3,
            ],
            [
                'title' => 'google_analytics',
                'group' => 'integration',
                'type' => 'textarea',
                'order' => 1
            ],
            [
                'title' => 'facebook_pixel',
                'group' => 'integration',
                'type' => 'textarea',
                'order' => 2
            ],
            [
                'title' => 'google_tag_manager',
                'group' => 'integration',
                'type' => 'textarea',
                'order' => 3
            ],
            [
                'title' => 'invalid_coupon',
                'group' => 'coupon',
                'value' => 'Coupon is invalid',
                'order' => 1
            ],
            [
                'title' => 'coupon_usage_exceed',
                'group' => 'coupon',
                'value' => 'Coupon used too many times',
                'order' => 2
            ],
            [
                'title' => 'coupon_not_applicable_for_cart',
                'group' => 'coupon',
                'value' => 'Minimum amount for cart is {{target}} to use this coupon',
                'order' => 3
            ],
            [
                'title' => 'coupon_not_valid_for_category_or_product',
                'group' => 'coupon',
                'value' => 'Coupon not valid for this category / product',
                'order' => 4
            ],
        ];
        foreach ($config_data as $item) {
            $config = \App\Models\ConfigData::create($item);
            if ($item['title'] == 'logo') {
                $config->addHashedMedia(public_path('assets/admin/img/logo.png'), true)
                    ->preservingOriginal()
                    ->toMediaCollection('cover');
            } elseif ($item['title'] == 'favicon') {
                $config->addHashedMedia(public_path('assets/admin/img/favicon.jpg'), true)
                    ->preservingOriginal()
                    ->toMediaCollection('cover');
            }
        }
    }
}
