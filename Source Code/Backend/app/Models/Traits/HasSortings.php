<?php

namespace App\Models\Traits;

use App\Acme\Core;

/**
 * each model should define the index of
 * what sorting options it will use ex.
 * protected static $sorting_options = [1, 2, 3].
 *
 * then you can use it like
 * Model::getSortingOptions();
 */
trait HasSortings
{
    protected static function sortingList()
    {
        return [
            '', // ignore
            [
                'title' => 'Recently Added',
                'sort_by' => 'created_at',
                'sort_dir' => 'desc',
            ], //1
            [
                'title' => 'Low to High',
                'sort_by' => 'total_reward_points',
                'sort_dir' => 'asc',
            ], //2
            [
                'title' => 'High to Low',
                'sort_by' => 'total_reward_points',
                'sort_dir' => 'desc',
            ], //3
            [
                'title' => 'Price: Low to High',
                'sort_by' => 'price',
                'sort_dir' => 'asc',
            ], //4
            [
                'title' => 'Price: High to Low',
                'sort_by' => 'price',
                'sort_dir' => 'desc',
            ], //5
            [
                'title' => 'Orders (No.): Low to High',
                'sort_by' => 'orders_number',
                'sort_dir' => 'asc',
            ], //6
            [
                'title' => 'Orders (No.): High to Low',
                'sort_by' => 'orders_number',
                'sort_dir' => 'desc',
            ], //7
            [
                'title' => 'Orders ($): Low to High',
                'sort_by' => 'orders_amount',
                'sort_dir' => 'asc',
            ], //8
            [
                'title' => 'Orders ($): High to Low',
                'sort_by' => 'orders_amount',
                'sort_dir' => 'desc',
            ], //9
            [
                'title' => '',
                'sort_by' => '',
                'sort_dir' => 'desc',
            ], //10
            [
                'title' => '',
                'sort_by' => '',
                'sort_dir' => 'desc',
            ], //11
        ];
    }

    public static function getSortingOptions($api = false, $sorting_options = [])
    {
        $arr = [];
        $sorting_options = $sorting_options ?: self::$sorting_options;
        foreach ($sorting_options as $index) {
            $arr[] = self::sortingList()[$index];
        }

        // add url key for web
        if (!$api) {
            foreach ($arr as $k => $v) {
                $arr[$k]['url'] = (new Core())->addToCurrentQS([
                    'sort_by' => $v['sort_by'],
                    'sort_dir' => $v['sort_dir'],
                ]);
            }
        }
        return collect($arr);
    }
}
