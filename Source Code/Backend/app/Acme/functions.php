<?php

use app\Acme\ColorFound;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
 * trim phrases in english or arabic
 */
if (!function_exists('trimfy')) {
    function trimfy($value, $limit = 100, $end = ' ...')
    {
        $value = strip_tags($value);

        if (LaravelLocalization::getCurrentLocale() != 'en') {
            return strlen($value) <= $limit
                ? $value
                : mb_substr($value, 0, $limit, 'UTF-8') . $end;
        }

        return mb_strwidth($value, 'UTF-8') <= $limit
            ? $value
            : rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8')) . $end;
    }
}

/*
 * slug titles for english or arabic
 */
if (!function_exists('slugfy')) {
    function slugfy($string, $separator = '-')
    {
        $str = trim($string);
        $str = strtolower($str);
        $str = preg_replace('|[^a-z-A-Z\p{Arabic}0-9 _]|iu', '', $str);
        $str = preg_replace('/\s+/', ' ', $str);
        $str = str_replace(' ', $separator, $str);

        return $str;
    }
}

/*
 * Checks whether a section has been captured yet.
 *
 * https://laravel.io/forum/02-06-2014-check-if-yieldsomething-is-set
 *
 * @param  string  $section
 * @return bool
 */
if (!function_exists('hasSectionFor')) {
    function hasSectionFor($section)
    {
        return array_key_exists($section, app('view')->getSections());
    }
}
/*
 * make translation avail for js
 */
if (!function_exists('transToJs')) {
    function transToJs($file_name, $vendor_path = null)
    {
        $lang_path = resource_path('lang');
        $current = app()->getLocale();
        $fall_back = config('app.fallback_locale');
        $file_name = "$file_name.php";
        $path = $vendor_path ? "$lang_path/vendor/$vendor_path" : $lang_path;
        $res = file_exists("$path/$current/$file_name")
            ? include "$path/$current/$file_name"
            : include "$path/$fall_back/$file_name";

        return json_encode($res);
    }
}

/*
 * translate file size to something understandable
 */
if (!function_exists('bytesToHuman')) {
    function bytesToHuman($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}

/*
 * helper for quick faker
 */
if (!function_exists('faker')) {
    function faker()
    {
        return \Faker\Factory::create();
    }
}

/*
 * helper for quick carbon
 */
if (!function_exists('carbon')) {
    function carbon($date)
    {
        return new \Carbon\Carbon($date);
    }
}

/*
 * https://tudorbarbu.ninja/remove-empty-array-elements-with-recursive-lambda-in-php-5-3/
 */
if (!function_exists('array_filter_rec')) {
    function array_filter_rec($arr)
    {
        $callback = function ($item) use (&$callback) {
            if (is_array($item)) {
                return array_filter($item, $callback);
            }

            if (!empty($item)) {
                return true;
            }
        };

        return array_filter($arr, $callback);
    }
}
if (!function_exists('str_trim')) {
    function str_trim($text, $limit = 10)
    {
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }
}
function get_color_name($hex)
{
    require_once('ColorFound.php');
    $colorFound = new ColorFound();
    try {
        return ucwords($colorFound->getName($hex));
    } catch (Exception $exception) {
        return $hex;
    }
}

function get_config_group_title($group)
{
    return ucwords(str_replace('_', ' ', substr($group, 2)));
}

function prepare_html($text)
{
    $text = str_replace('<p></p>', '', $text);
    $text = str_replace('<p> </p>', '', $text);
    $text = str_replace('<p>&nbsp;</p>', '', $text);
    return $text;
}

function import_fields()
{
    return [
        'sku', 'title','cost_price', 'supplier_regular_price', 'supplier_sale_price',
        'video_url', 'excerpt', 'description', 'delivery_information',
        'warranty_information', 'terms_conditions', 'brand', 'categories',
        'main_image', 'other_images', 'quantity', 'supplier_code', 'google_category', 'affiliate_link'
        , 'notes', 'shipping_cost', 'shipping_days',
    ];

}
