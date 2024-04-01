<?php

namespace App\Models;

use App\Models\Traits\HasMedia;
use App\User;
use Spatie\MediaLibrary\HasMedia\HasMedia as HasMediaContract;

class FrontendAboutUs extends BaseModel implements HasMediaContract
{
    use HasMedia;

    public function registerMediaCollections()
    {
        $this->addMediaCollection('banner_section_image')->singleFile();
        $this->addMediaCollection('our_mission_image')->singleFile();
        $this->addMediaCollection('customised_options_section_image')->singleFile();
        $this->addMediaCollection('why_section_image')->singleFile();
        $this->addMediaCollection('options_image')->singleFile();
        $this->addMediaCollection('our_story_image')->singleFile();
    }

    public function getBannerSectionImageAttribute()
    {
        return $this->getFirstMedia('banner_section_image');
    }

    public function getOurMissionImageAttribute()
    {
        return $this->getFirstMedia('our_mission_image');
    }

    public function getCustomisedOptionsSectionImageAttribute()
    {
        return $this->getFirstMedia('customised_options_section_image');
    }

    public function getWhySectionImageAttribute()
    {
        return $this->getFirstMedia('why_section_image');
    }

    public function getOptionsImageAttribute()
    {
        return $this->getFirstMedia('options_image');
    }

    public function getOurStoryImageAttribute()
    {
        return $this->getFirstMedia('our_story_image');
    }
}
