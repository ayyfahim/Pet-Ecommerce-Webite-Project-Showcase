<?php

namespace App\Http\Controllers\Traits\Product;

use Illuminate\Support\Arr;

trait Filtration
{
    protected function filterData($request, $collection)
    {
        // Admin
        $status_id = $request->status_id == 'all' ? null : $request->status_id;
        $stock_status = $request->stock_status == 'all' ? null : $request->stock_status;
        $featured = $request->featured == 'all' ? null : $request->featured == 'Yes';
        $vendor_id = $request->vendor_id == 'all' ? null : $request->vendor_id;
        $brand_id = $request->brand_id == 'all' ? null : $request->brand_id;
        $country_id = $request->country_id == 'all' ? null : $request->country_id;
        $city = $request->city == 'all' ? null : $request->city;
        $age = $request->age;
        $breed_id = $request->breed_id;
        // Common
        $title = str_replace('"', '\"', $request->q);
        $title = str_replace("'", "\'", $title);
        $price_from = $request->price_from;
        $price_to = $request->price_to;
        $attributes = $request->input('attributes');
//        $attributes = $request->input('attributes')?Arr::flatten($request->input('attributes')):[];
        if ($request->categories) {
            $categories = $request->categories;
        } else {
            $categories = null;
            if($request->category_id){
                $categories = $request->category_id == 'all' ? null :array($request->category_id);
            }
        }
        $brands = $request->brands;
        $concerns = $request->concerns;
        $collection->when($status_id, function ($query) use ($status_id) {
            $query->where('status_id', $status_id);
        });
        $collection->when($featured, function ($query) use ($featured) {
            $query->where('featured', $featured);
        });
        $collection->when($vendor_id, function ($query) use ($vendor_id) {
            $query->whereHas('info', function ($query) use ($vendor_id) {
                $query->where('vendor_id', $vendor_id);
            });
        });
        $collection->when($country_id, function ($query) use ($country_id) {
            $query->whereHas('info', function ($query) use ($country_id) {
                $query->where('country_id', $country_id);
            });
        });
        $collection->when($city, function ($query) use ($city) {
            $query->whereHas('info', function ($query) use ($city) {
                $query->whereJsonContains('cities', $city);
            });
        });
        $collection->when($stock_status, function ($query) use ($stock_status) {
            if ($stock_status == 'in') {
                $query->where('quantity', '>', 0);
            } elseif ($stock_status == 'out') {
                $query->where('quantity', '<=', 0);
            }
        });
        $collection->when($title, function ($query) use ($title) {
            $query->whereRaw('lower(title) like "%' . strtolower($title) . '%"');

        });
        $collection->when($price_from, function ($query) use ($price_from) {
            $query->where('price', '>=', $price_from);
        })->when($price_to, function ($query) use ($price_to) {
            $query->where('price', '<=', $price_to);
        });
        $collection->when($brands, function ($query) use ($brands) {
            $query->whereIn('brand_id', $brands);
        });
        $collection->when($brand_id, function ($query) use ($brand_id) {
            $query->where('brand_id', $brand_id);
        });
        $collection->when($categories, function ($query) use ($categories) {
            return $query->whereJsonContains('categories_ids', $categories);
        });
        $collection->when($concerns, function ($query) use ($concerns) {
            $query->whereHas('info', function ($query) use ($concerns) {
                $query->whereHas('concerns', function ($query) use ($concerns) {
                    $query->whereIn('concern_id', $concerns);
                });
            });
        });
        $collection->when($age, function ($query) use ($age) {
            $query->where('age', '<=', $age);
        });
        $collection->when($breed_id, function ($query) use ($breed_id) {
            $query->whereHas('info', function ($query) use ($breed_id) {
                $query->where('breed_id', $breed_id);
            });
        });
        $collection->when($attributes, function ($query) use ($attributes) {
            $query->where(function ($query) use ($attributes) {
                $query->whereHas('configurations', function ($query) use ($attributes) {
                    $query->whereHas('configurations', function ($query) use ($attributes) {
                        foreach ($attributes as $key => $attribute) {
                            if ($key == 0) {
                                $query->whereRaw('lower(value) like ?', ['%' . strtolower($attribute) . '%']);
                            } else {
                                $query->orWhereRaw('lower(value) like ?', ['%' . strtolower($attribute) . '%']);
                            }
                        }
                    });
                });
            });
        });
        return $collection;
    }
}
