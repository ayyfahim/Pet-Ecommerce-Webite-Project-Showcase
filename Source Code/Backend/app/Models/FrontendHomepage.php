<?php

namespace App\Models;

use App\Models\Traits\HasMedia;
use App\User;
use Spatie\MediaLibrary\HasMedia\HasMedia as HasMediaContract;

class FrontendHomepage extends BaseModel implements HasMediaContract
{
    use HasMedia;

    public function registerMediaCollections()
    {
        $this->addMediaCollection('banner_section_image')->singleFile();
        $this->addMediaCollection('banner_section_mobile_image')->singleFile();
        $this->addMediaCollection('ingredient_section_main_image')->singleFile();
        $this->addMediaCollection('ingr_1_image')->singleFile();
        $this->addMediaCollection('ingr_2_image')->singleFile();
        $this->addMediaCollection('ingr_3_image')->singleFile();
        $this->addMediaCollection('ingr_4_image')->singleFile();
        $this->addMediaCollection('ingr_5_image')->singleFile();
        $this->addMediaCollection('ingr_6_image')->singleFile();
        $this->addMediaCollection('why_us_section_image')->singleFile();
        $this->addMediaCollection('review_1_image')->singleFile();
        $this->addMediaCollection('review_2_image')->singleFile();
        $this->addMediaCollection('review_3_image')->singleFile();
        $this->addMediaCollection('how_it_works_section_main_image')->singleFile();
        $this->addMediaCollection('how_it_works_section_bubble_image')->singleFile();
        $this->addMediaCollection('sub_banner_1_icon')->singleFile();
        $this->addMediaCollection('sub_banner_2_icon')->singleFile();
        $this->addMediaCollection('sub_banner_3_icon')->singleFile();
        $this->addMediaCollection('sub_banner_4_icon')->singleFile();
        $this->addMediaCollection('why_us_1_icon')->singleFile();
        $this->addMediaCollection('why_us_2_icon')->singleFile();
        $this->addMediaCollection('why_us_3_icon')->singleFile();
        $this->addMediaCollection('why_us_4_icon')->singleFile();
        $this->addMediaCollection('why_us_5_icon')->singleFile();
        $this->addMediaCollection('why_us_6_icon')->singleFile();
    }

    public function getBannerSectionImageAttribute()
    {
        return $this->getFirstMedia('banner_section_image');
    }

    public function getBannerSectionMobileImageAttribute()
    {
        return $this->getFirstMedia('banner_section_mobile_image');
    }

    public function getIngredientSectionMainImageAttribute()
    {
        return $this->getFirstMedia('ingredient_section_main_image');
    }

    public function getIngr1ImageAttribute()
    {
        return $this->getFirstMedia('ingr_1_image');
    }

    public function getIngr2ImageAttribute()
    {
        return $this->getFirstMedia('ingr_2_image');
    }

    public function getIngr3ImageAttribute()
    {
        return $this->getFirstMedia('ingr_3_image');
    }

    public function getIngr4ImageAttribute()
    {
        return $this->getFirstMedia('ingr_4_image');
    }

    public function getIngr5ImageAttribute()
    {
        return $this->getFirstMedia('ingr_5_image');
    }

    public function getIngr6ImageAttribute()
    {
        return $this->getFirstMedia('ingr_6_image');
    }

    public function getWhyUsSectionImageAttribute()
    {
        return $this->getFirstMedia('why_us_section_image');
    }

    public function getReview1ImageAttribute()
    {
        return $this->getFirstMedia('review_1_image');
    }

    public function getReview2ImageAttribute()
    {
        return $this->getFirstMedia('review_2_image');
    }

    public function getReview3ImageAttribute()
    {
        return $this->getFirstMedia('review_3_image');
    }

    public function getHowItWorksSectionMainImageAttribute()
    {
        return $this->getFirstMedia('how_it_works_section_main_image');
    }

    public function getHowItWorksSectionBubbleImageAttribute()
    {
        return $this->getFirstMedia('how_it_works_section_bubble_image');
    }

    public function getSubBanner1IconAttribute()
    {
        return $this->getFirstMedia('sub_banner_1_icon');
    }

    public function getSubBanner2IconAttribute()
    {
        return $this->getFirstMedia('sub_banner_2_icon');
    }

    public function getSubBanner3IconAttribute()
    {
        return $this->getFirstMedia('sub_banner_3_icon');
    }

    public function getSubBanner4IconAttribute()
    {
        return $this->getFirstMedia('sub_banner_4_icon');
    }

    public function getWhyUs1IconAttribute()
    {
        return $this->getFirstMedia('why_us_1_icon');
    }

    public function getWhyUs2IconAttribute()
    {
        return $this->getFirstMedia('why_us_2_icon');
    }

    public function getWhyUs3IconAttribute()
    {
        return $this->getFirstMedia('why_us_3_icon');
    }

    public function getWhyUs4IconAttribute()
    {
        return $this->getFirstMedia('why_us_4_icon');
    }

    public function getWhyUs5IconAttribute()
    {
        return $this->getFirstMedia('why_us_5_icon');
    }

    public function getWhyUs6IconAttribute()
    {
        return $this->getFirstMedia('why_us_6_icon');
    }

    // public function getAttribute()
    // {
    //     return $this->getFirstMedia('cover');
    // }
}
