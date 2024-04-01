<?php

namespace App\Transformers;

use App\Models\Address;
use App\Models\Article;
use App\Models\FrontendAboutUs;
use App\Models\FrontendHomepage;
use App\Models\FrontendRewardProgram;
use Illuminate\Support\Str;
use App\Transformers\Traits\HasMap;

class FrontendAboutUsTransformer extends BaseTransformer
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
    public function transform(FrontendAboutUs $page)
    {
        return [
            'banner_section_title' => $page->banner_section_title,
            'banner_section_description' => $page->banner_section_description,
            'banner_section_image' => $page->banner_section_image ? asset($page->banner_section_image->getUrl()) : null,
            'our_mission_title' => $page->our_mission_title,
            'our_mission_description' => $page->our_mission_description,
            'our_mission_image' => $page->our_mission_image ? asset($page->our_mission_image->getUrl()) : null,
            'customised_options_section_title' => $page->customised_options_section_title,
            'customised_options_section_description' => $page->customised_options_section_description,
            'customised_options_section_image' => $page->customised_options_section_image ? asset($page->customised_options_section_image->getUrl()) : null,
            'why_section_title' => $page->why_section_title,
            'why_section_description' => $page->why_section_description,
            'why_section_image' => $page->why_section_image ? asset($page->why_section_image->getUrl()) : null,
            'options_title' => $page->options_title,
            'options_description' => $page->options_description,
            'options_image' => $page->options_image ? asset($page->options_image->getUrl()) : null,

            'our_story_title' => $page->our_story_title,
            'our_story_description' => $page->our_story_description,
            'our_story_image' => $page->our_story_image ? asset($page->our_story_image->getUrl()) : null,
            'about_company_title' => $page->about_company_title,
            'about_company_description' => $page->about_company_description,
        ];
    }
}
