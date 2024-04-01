<?php

namespace App\Transformers;

use App\Models\Category;
use App\Transformers\Traits\HasMedia;

class CategoryTransformer extends BaseTransformer
{
    use HasMedia;
    private $parent;
    private $children;

    public function __construct($parent = false, $children = true)
    {
        $this->parent = $parent;
        $this->children = $children;
    }
    protected array $defaultIncludes = [
        'children',
    ];

    /**
     * A Fractal transformer.
     *
     * @param mixed $category
     *
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
            'description' => $category->description,
            'banner_title' => $category->banner_title,
            'banner_description' => $category->banner_description,
            'badge' => [
                'img' => $category->badge ? asset($category->badge->getUrl()) : '',
                'alt' => $category->badge && isset($category->badge->custom_properties['alt']) ? $category->badge->custom_properties['alt'] : ''
            ],
            'icon' => [
                'img' => $category->icon ? asset($category->icon->getUrl()) : '',
                'alt' => $category->icon && isset($category->icon->custom_properties['alt']) ? $category->icon->custom_properties['alt'] : ''
            ],
        ];
    }

    /* -------------------------------- relation -------------------------------- */

    public function includeChildren(Category $category)
    {
        return $this->collection($category->children()->orderByRaw('-sort_order DESC')->get(), new CategoryTransformer());
//        return $this->collection($category->children, new CategoryTransformer());
    }
}
