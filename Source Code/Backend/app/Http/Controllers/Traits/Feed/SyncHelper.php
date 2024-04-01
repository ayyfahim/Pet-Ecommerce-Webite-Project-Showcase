<?php


namespace App\Http\Controllers\Traits\Feed;


use App\Models\Brand;
use App\Models\Category;
use App\Models\Feed;
use App\Models\Product;

trait SyncHelper
{
    private function sync_product($sku, $product_to_sync, $fields, Feed $feed)
    {
        $vendor = $feed->vendor;
        $product = $vendor->products()->where('sku',$sku)->first();
        $productData = [
            'sku' => $sku,
            'quantity' => isset($fields['quantity']) && isset($product_to_sync[$fields['quantity']]) ? $product_to_sync[$fields['quantity']] : 0,
            'google_category' => isset($fields['google_category']) && isset($product_to_sync[$fields['google_category']]) ? $product_to_sync[$fields['google_category']] : '',
            'affiliate_link' => isset($fields['affiliate_link']) && isset($product_to_sync[$fields['affiliate_link']]) ? $product_to_sync[$fields['affiliate_link']] : '',
            'notes' => isset($fields['notes']) && isset($product_to_sync[$fields['notes']]) ? $product_to_sync[$fields['notes']] : '',
            'shipping_cost' => isset($fields['shipping_cost']) && isset($product_to_sync[$fields['shipping_cost']]) ? $product_to_sync[$fields['shipping_cost']] : '',
            'shipping_days' => isset($fields['shipping_days']) && isset($product_to_sync[$fields['shipping_days']]) ? $product_to_sync[$fields['shipping_days']] : '',
            'slug' => isset($fields['title']) && isset($product_to_sync[$fields['title']]) ? $product_to_sync[$fields['title']] : '',
        ];
        $productInfoData = [
            'title' => isset($fields['title']) && isset($product_to_sync[$fields['title']]) ? $product_to_sync[$fields['title']] : '',
            'description' => isset($fields['description']) && isset($product_to_sync[$fields['description']]) ? $product_to_sync[$fields['description']] : '',
            'excerpt' => isset($fields['excerpt']) && isset($product_to_sync[$fields['excerpt']]) ? $product_to_sync[$fields['excerpt']] : '',
            'video_url' => isset($fields['video_url']) && isset($product_to_sync[$fields['video_url']]) ? $product_to_sync[$fields['video_url']] : '',
            'delivery_information' => isset($fields['delivery_information']) && isset($product_to_sync[$fields['delivery_information']]) ? $product_to_sync[$fields['delivery_information']] : '',
            'warranty_information' => isset($fields['warranty_information']) && isset($product_to_sync[$fields['warranty_information']]) ? $product_to_sync[$fields['warranty_information']] : '',
            'terms_conditions' => isset($fields['terms_conditions']) && isset($product_to_sync[$fields['terms_conditions']]) ? $product_to_sync[$fields['terms_conditions']] : '',
            'cost_price' => isset($fields['cost_price']) && isset($product_to_sync[$fields['cost_price']]) ? $product_to_sync[$fields['cost_price']] : '',
            'supplier_regular_price' => isset($fields['supplier_regular_price']) && isset($product_to_sync[$fields['supplier_regular_price']]) ? $product_to_sync[$fields['supplier_regular_price']] : '',
            'supplier_sale_price' => isset($fields['supplier_sale_price']) && isset($product_to_sync[$fields['supplier_sale_price']]) ? $product_to_sync[$fields['supplier_sale_price']] : '',
            'regular_price' => isset($fields['supplier_regular_price']) && isset($product_to_sync[$fields['supplier_regular_price']]) ? $product_to_sync[$fields['supplier_regular_price']] : '',
            'sale_price' => isset($fields['supplier_sale_price']) && isset($product_to_sync[$fields['supplier_sale_price']]) ? $product_to_sync[$fields['supplier_sale_price']] : '',
            'brand_id' => isset($fields['brand']) && isset($product_to_sync[$fields['brand']]) && $product_to_sync[$fields['brand']]
                ? $this->get_brand_id($product_to_sync[$fields['brand']]) : null,
        ];
        if($productInfoData['supplier_sale_price']){
            if ($feed->discounted_percentage) {
                if ($productInfoData['sale_price']) {
                    $productInfoData['sale_price'] = $productInfoData['sale_price'] + (($productInfoData['sale_price'] * $feed->discounted_percentage) / 100);
                }
            }
        }else{
            if ($feed->percentage) {
                if ($productInfoData['regular_price']) {
                    $productInfoData['sale_price'] = $productInfoData['cost_price'] + (($productInfoData['cost_price'] * $feed->percentage) / 100);
                }
            }
        }

        if ($product) {
            $product->update($productData);
        } else {
            $productData['status_id'] = Product::getStatusFor('status')->firstWhere('order', 2)->id;
            $product =$vendor->products()->create($productData);
        }
        $info = $product->infos()->create($productInfoData);
        $main_image = isset($fields['main_image']) && isset($product_to_sync[$fields['main_image']]) ? $product_to_sync[$fields['main_image']] : null;
        if ($main_image && filter_var($main_image, FILTER_VALIDATE_URL)) {
            $product->addHashedMediaFromUrl($main_image, ['main' => true])
                ->toMediaCollection('gallery');
        }
        $other_images = isset($fields['other_images']) && isset($product_to_sync[$fields['other_images']]) ? $product_to_sync[$fields['other_images']] : [];
        if ($other_images) {
            if (!is_array($other_images)) {
                $other_images = explode(',', $other_images);
            }
            foreach ($other_images as $key => $image) {
                try {
                    if (filter_var($image, FILTER_VALIDATE_URL)) {
                        $product->addHashedMediaFromUrl($image, ['main' => false])
                            ->toMediaCollection('gallery');
                    }
                } catch (\Exception $exception) {

                }
            }
        }

        if ($categories = $this->get_categories(isset($fields['categories']) && isset($product_to_sync[$fields['categories']]) ? $product_to_sync[$fields['categories']] : [])) {
            $info->categories()->sync($categories);
        }
        $this->setFiltrationColumns($product->fresh());
    }

    private function get_brand_id($name)
    {
        $brand = Brand::where('name', $name)->first();
        if (!$brand) {
            $brand = Brand::create(['name' => $name]);
        }
        return $brand->id;
    }

    private function get_categories($categories)
    {
        $response = [];
        if (!is_array($categories)) {
            $categories = [$categories];
        }
        if (isset($categories['category']) && is_array($categories['category'])) {
            $categories = $categories['category'];
        }
        foreach (array_filter($categories) as $category) {
            if ($category) {
                $categoryObj = Category::where('name', $category)->first();
                if (!$categoryObj) {
                    $categoryObj = Category::create(['name' => $category]);
                }
                $response[] = $categoryObj->id;
            }
        }
        return $response;
    }
}
