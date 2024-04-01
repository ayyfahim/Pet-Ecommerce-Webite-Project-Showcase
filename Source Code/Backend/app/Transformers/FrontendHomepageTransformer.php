<?php

namespace App\Transformers;

use App\Models\Address;
use App\Models\Article;
use App\Models\FrontendHomepage;
use Illuminate\Support\Str;
use App\Transformers\Traits\HasMap;

class FrontendHomepageTransformer extends BaseTransformer
{

    protected array $defaultIncludes = [
    ];
    protected array $availableIncludes = [
    ];

    /**
     * A Fractal transformer.
     *
     * @param Article $article
     * @return array
     */
    public function transform(FrontendHomepage $page)
    {
        return [
            // 'cover' => $article->cover ? asset($article->cover->getUrl()) : null,
            'banner_section_header' => $page->banner_section_header,
            'banner_section_description' => $page->banner_section_description,
            'banner_button_1_text' => $page->banner_button_1_text,
            'banner_button_1_link' => $page->banner_button_1_link,
            'banner_button_2_text' => $page->banner_button_2_text,
            'banner_button_2_link' => $page->banner_button_2_link,
            'sub_banner_1_text' => $page->sub_banner_1_text,
            'sub_banner_2_text' => $page->sub_banner_2_text,
            'sub_banner_3_text' => $page->sub_banner_3_text,
            'sub_banner_4_text' => $page->sub_banner_4_text,
            'concern_section_header' => $page->concern_section_header,
            'concern_section_description' => $page->concern_section_description,
            'top_selling_section_header' => $page->top_selling_section_header,
            'top_selling_section_description' => $page->top_selling_section_description,
            'quality_ingredients_section_header' => $page->quality_ingredients_section_header,
            'quality_ingredients_section_description' => $page->quality_ingredients_section_description,
            'ingr_1_header' => $page->ingr_1_header,
            'ingr_1_description' => $page->ingr_1_description,
            'ingr_2_header' => $page->ingr_2_header,
            'ingr_2_description' => $page->ingr_2_description,
            'ingr_3_header' => $page->ingr_3_header,
            'ingr_3_description' => $page->ingr_3_description,
            'ingr_4_header' => $page->ingr_4_header,
            'ingr_4_description' => $page->ingr_4_description,
            'ingr_5_header' => $page->ingr_5_header,
            'ingr_5_description' => $page->ingr_5_description,
            'ingr_6_header' => $page->ingr_6_header,
            'ingr_6_description' => $page->ingr_6_description,
            'why_us_section_header' => $page->why_us_section_header,
            'why_us_section_description' => $page->why_us_section_description,
            'why_us_1_header' => $page->why_us_1_header,
            'why_us_1_text' => $page->why_us_1_text,
            'why_us_2_header' => $page->why_us_2_header,
            'why_us_2_text' => $page->why_us_2_text,
            'why_us_3_header' => $page->why_us_3_header,
            'why_us_3_text' => $page->why_us_3_text,
            'why_us_4_header' => $page->why_us_4_header,
            'why_us_4_text' => $page->why_us_4_text,
            'why_us_5_header' => $page->why_us_5_header,
            'why_us_5_text' => $page->why_us_5_text,
            'why_us_6_header' => $page->why_us_6_header,
            'why_us_6_text' => $page->why_us_6_text,
            'review_section_header' => $page->review_section_header,
            'review_section_description' => $page->review_section_description,
            'review_1_star' => $page->review_1_star,
            'review_1_header' => $page->review_1_header,
            'review_1_description' => $page->review_1_description,
            'review_1_author_name' => $page->review_1_author_name,
            'review_2_star' => $page->review_2_star,
            'review_2_header' => $page->review_2_header,
            'review_2_description' => $page->review_2_description,
            'review_2_author_name' => $page->review_2_author_name,
            'review_3_star' => $page->review_3_star,
            'review_3_header' => $page->review_3_header,
            'review_3_description' => $page->review_3_description,
            'review_3_author_name' => $page->review_3_author_name,
            'how_it_works_section_header' => $page->how_it_works_section_header,
            'how_it_works_section_description' => $page->how_it_works_section_description,
            'how_it_works_1_header' => $page->how_it_works_1_header,
            'how_it_works_1_description' => $page->how_it_works_1_description,
            'how_it_works_2_header' => $page->how_it_works_2_header,
            'how_it_works_2_description' => $page->how_it_works_2_description,
            'how_it_works_3_header' => $page->how_it_works_3_header,
            'how_it_works_3_description' => $page->how_it_works_3_description,
            'blogs_section_header' => $page->blogs_section_header,
            'blogs_section_desctiption' => $page->blogs_section_desctiption,
            'instagram_section_text' => $page->instagram_section_text,
            'instagram_section_username' => $page->instagram_section_username,
            'instagram_section_profile_link' => $page->instagram_section_profile_link,
            'disclaimer_text' => $page->disclaimer_text,

            'banner_section_image' => $page->banner_section_image ? asset($page->banner_section_image->getUrl()) : null,
            'banner_section_mobile_image' => $page->banner_section_mobile_image ? asset($page->banner_section_mobile_image->getUrl()) : null,
            'ingredient_section_main_image' => $page->ingredient_section_main_image ? asset($page->ingredient_section_main_image->getUrl()) : null,
            'ingr_1_image' => $page->ingr_1_image ? asset($page->ingr_1_image->getUrl()) : null,
            'ingr_2_image' => $page->ingr_2_image ? asset($page->ingr_2_image->getUrl()) : null,
            'ingr_3_image' => $page->ingr_3_image ? asset($page->ingr_3_image->getUrl()) : null,
            'ingr_4_image' => $page->ingr_4_image ? asset($page->ingr_4_image->getUrl()) : null,
            'ingr_5_image' => $page->ingr_5_image ? asset($page->ingr_5_image->getUrl()) : null,
            'ingr_6_image' => $page->ingr_6_image ? asset($page->ingr_6_image->getUrl()) : null,
            'why_us_section_image' => $page->why_us_section_image ? asset($page->why_us_section_image->getUrl()) : null,
            'review_1_image' => $page->review_1_image ? asset($page->review_1_image->getUrl()) : null,
            'review_2_image' => $page->review_2_image ? asset($page->review_2_image->getUrl()) : null,
            'review_3_image' => $page->review_3_image ? asset($page->review_3_image->getUrl()) : null,
            'how_it_works_section_main_image' => $page->how_it_works_section_main_image ? asset($page->how_it_works_section_main_image->getUrl()) : null,
            'how_it_works_section_bubble_image' => $page->how_it_works_section_bubble_image ? asset($page->how_it_works_section_bubble_image->getUrl()) : null,
            'sub_banner_1_icon' => $page->sub_banner_1_icon ? asset($page->sub_banner_1_icon->getUrl()) : null,
            'sub_banner_2_icon' => $page->sub_banner_2_icon ? asset($page->sub_banner_2_icon->getUrl()) : null,
            'sub_banner_3_icon' => $page->sub_banner_3_icon ? asset($page->sub_banner_3_icon->getUrl()) : null,
            'sub_banner_4_icon' => $page->sub_banner_4_icon ? asset($page->sub_banner_4_icon->getUrl()) : null,
            'why_us_1_icon' => $page->why_us_1_icon ? asset($page->why_us_1_icon->getUrl()) : null,
            'why_us_2_icon' => $page->why_us_2_icon ? asset($page->why_us_2_icon->getUrl()) : null,
            'why_us_3_icon' => $page->why_us_3_icon ? asset($page->why_us_3_icon->getUrl()) : null,
            'why_us_4_icon' => $page->why_us_4_icon ? asset($page->why_us_4_icon->getUrl()) : null,
            'why_us_5_icon' => $page->why_us_5_icon ? asset($page->why_us_5_icon->getUrl()) : null,
            'why_us_6_icon' => $page->why_us_6_icon ? asset($page->why_us_6_icon->getUrl()) : null,
        ];
    }
}
