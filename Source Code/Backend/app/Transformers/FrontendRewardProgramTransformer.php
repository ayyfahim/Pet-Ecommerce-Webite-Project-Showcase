<?php

namespace App\Transformers;

use App\Models\Address;
use App\Models\Article;
use App\Models\FrontendHomepage;
use App\Models\FrontendRewardProgram;
use Illuminate\Support\Str;
use App\Transformers\Traits\HasMap;

class FrontendRewardProgramTransformer extends BaseTransformer
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
    public function transform(FrontendRewardProgram $page)
    {
        return [
            'reward_program_banner_title' => $page->reward_program_banner_title,
            'reward_program_banner_description' => $page->reward_program_banner_description,
            'how_it_works_section_title' => $page->how_it_works_section_title,
            'how_it_works_section_description' => $page->how_it_works_section_description,
            'how_it_works_1_title' => $page->how_it_works_1_title,
            'how_it_works_1_description' => $page->how_it_works_1_description,
            'how_it_works_1_icon' => $page->how_it_works_1_icon ? asset($page->how_it_works_1_icon->getUrl()) : null,
            'how_it_works_2_title' => $page->how_it_works_2_title,
            'how_it_works_2_description' => $page->how_it_works_2_description,
            'how_it_works_2_icon' => $page->how_it_works_2_icon ? asset($page->how_it_works_2_icon->getUrl()) : null,
            'how_it_works_3_title' => $page->how_it_works_3_title,
            'how_it_works_3_description' => $page->how_it_works_3_description,
            'how_it_works_3_icon' => $page->how_it_works_3_icon ? asset($page->how_it_works_3_icon->getUrl()) : null,
            'how_to_collect_image' => $page->how_to_collect_image ? asset($page->how_to_collect_image->getUrl()) : null,
            'banner_image' => $page->banner_image ? asset($page->banner_image->getUrl()) : null,
            'how_to_collect_title' => $page->how_to_collect_title,
            'how_to_collect_description' => $page->how_to_collect_description,
            'how_to_collect_1_title' => $page->how_to_collect_1_title,
            'how_to_collect_1_point' => $page->how_to_collect_1_point,
            'how_to_collect_2_title' => $page->how_to_collect_2_title,
            'how_to_collect_2_point' => $page->how_to_collect_2_point,
            'how_to_collect_3_title' => $page->how_to_collect_3_title,
            'how_to_collect_3_point' => $page->how_to_collect_3_point,
            'how_to_collect_4_title' => $page->how_to_collect_4_title,
            'how_to_collect_4_point' => $page->how_to_collect_4_point,
            'how_to_collect_5_title' => $page->how_to_collect_5_title,
            'how_to_collect_5_point' => $page->how_to_collect_5_point,
            'how_to_collect_6_title' => $page->how_to_collect_6_title,
            'how_to_collect_6_point' => $page->how_to_collect_6_point,
        ];
    }
}
