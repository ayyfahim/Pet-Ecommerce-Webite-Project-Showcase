<?php

namespace App\Transformers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductInfo;
use League\Fractal\ParamBag;
use App\Transformers\Traits\HasMap;
use App\Transformers\Traits\HasMedia;
use App\Transformers\Traits\HasStatus;
use App\Transformers\Traits\HasReviews;

class ProductTransformer extends BaseTransformer
{
    use
        HasStatus,
        HasMedia;
    private $compare = false;
    private $single = false;

    public function __construct($compare = false, $single = false)
    {
        $this->compare = $compare;
        $this->single = $single;
    }

    protected array $defaultIncludes = [];

    protected array $availableIncludes = [
        'gallery',
    ];

    /**
     * A Fractal transformer.
     *
     * @param Product $product
     * @return array
     */
    public function transform(Product $product)
    {
        $faq = [];
        if ($product->info->faq) {
            foreach ($product->info->faq as $item) {
                if (isset($item['question']) && $item['question']) {
                    $faq[] = $item;
                }
            }
        }
        $icons = [];
        foreach ($product->product_icons()->where('listing', true)->where('enabled', true)->get() as $product_icon) {
            $icons[] = [
                'badge' => asset($product_icon->icon->getUrlFor('badge')),
                'label' => $product_icon->label,
                'helper' => $product_icon->helper,
            ];
        }
        $sale_price = $product->info->sale_price ?: 0;

        $data = [
            'id' => $product->id,
            'slug' => $product->slug,
            'title' => $product->info->title,
            'excerpt' => prepare_html($product->info->excerpt),
            'regular_price' => $product->info->regular_price,
            'sale_price' => $sale_price,
            'deal' => [],
            'discount' => [
                'percentage' => round($product->info->discount_percentage) ?: false,
                'amount' => $product->info->discount_amount ?: false
            ],
            'icons' => $icons,
            'cover' => $product->cover ? asset($product->cover->getUrl('optimized')) : '',
            'is_configured' => $product->configurations()->count() > 0,
            'is_one_option' => is_array($product->first_options) && sizeof($product->first_options),
            'in_wishlist' => $product->isInList('wishlist') ? true : false,
            'wishlist_id' => $product->listId('wishlist') ?: '',
            'specifications' => [
                'specifications_description' => isset($product) ? $product->specifications_description : '',
                'items' => isset($product) && $product->specifications ? $product->specifications : []
            ],
            'dosages' => [
                'dosages_description' => isset($product) ? $product->dosages_description : '',
                'items' => isset($product) && $product->dosages ? $product->dosages : []
            ],
            'nutritions' => [
                'nutrition_facts_serving_label' => isset($product) ? $product->nutrition_facts_serving_label : '',
                'nutrition_facts_description' => isset($product) ? $product->nutrition_facts_description : '',
                'nutrition_facts_serving' => isset($product) && $product->nutrition_facts_serving ? $product->nutrition_facts_serving : [],
                'nutrition_facts_weight' => isset($product) && $product->nutrition_facts_weight ? $product->nutrition_facts_weight : []
            ],
            'ingredients_description' => $product->info->ingredients_description,
            'directions_description' => $product->info->directions_description,
        ];
        if ($this->compare || $this->single) {
            foreach ($product->product_icons()->where('listing', false)->where('enabled', true)->get() as $product_icon) {
                $icons[] = [
                    'badge' => asset($product_icon->icon->getUrlFor('badge')),
                    'label' => $product_icon->label,
                    'helper' => $product_icon->helper,
                ];
            }
            $data['icons'] = $icons;
            $data = array_merge($data, [
                'product_info_id' => $product->info->id,
                'in_stock' => $product->is_in_stock,
                'excerpt' => prepare_html($product->info->excerpt),
                'description' => prepare_html($product->info->description),
                'sku' => $product->sku,
                'categories' => $this->getCategories($product),
                'delivery_information' => prepare_html($product->info->delivery_information),
                'warranty_information' => prepare_html($product->info->warranty_information),
                'faq' => $faq,
                'video_url' => $product->info->video_url,
                'brand' => [
                    'name' => $product->info->brand ? $product->info->brand->name : '',
                    'badge' => $product->info->brand && $product->info->brand->badge ? asset($product->info->brand->badge->getUrl()) : ''
                ],
                'configurations' => $this->getDirectData($product->configurations, AttributeTransformer::class),
            ]);
        }
        return $data;
    }

    // -------------------------------- relation --------------------------------

    public function includeGallery(Product $product)
    {
        return $this->getMedia($product->gallery->where('custom_properties.main', false), false, 'optimized');
    }

    private function getCategories(Product $product)
    {
        $data = [];
        $categories = $product->info->categories;
        if ($categories) {
            foreach ($categories as $category) {
                $data[] = $this->setCategory($category);
            }
        }
        return $data;
    }

    private function setCategory(Category $category)
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'parent' => $category->parent ? $this->setCategory($category->parent) : []
        ];
    }
}
