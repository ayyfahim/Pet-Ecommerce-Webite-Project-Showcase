<?php

namespace App\Transformers;

use App\Models\Page;

class PageTransformer extends BaseTransformer
{
    private $single;

    public function __construct($single = false)
    {
        $this->single = $single;
    }

    protected array $defaultIncludes = [
    ];
    protected array $availableIncludes = [
    ];

    /**
     * A Fractal transformer.
     *
     * @param Page $page
     * @return array
     */
    public function transform(Page $page)
    {
        $data = [
            'slug' => $page->slug,
            'title' => $page->title,
            'banner_description' => $page->banner_description,
            'banner_image' => $page->cover ? asset($page->cover->getUrl()) : null,
        ];
        if ($this->single) {
            $data = array_merge($data, [
                'content' => $this->remove_extra_html($page->content),
                'other' => $page->info,
            ]);
        }
        return $data;
    }
}
