<?php

namespace App\Models;

use App\Models\Traits\HasMedia;
use App\User;
use Spatie\MediaLibrary\HasMedia\HasMedia as HasMediaContract;

class FrontendRewardProgram extends BaseModel implements HasMediaContract
{
    use HasMedia;

    public function registerMediaCollections()
    {
        $this->addMediaCollection('how_it_works_1_icon')->singleFile();
        $this->addMediaCollection('how_it_works_2_icon')->singleFile();
        $this->addMediaCollection('how_it_works_3_icon')->singleFile();
        $this->addMediaCollection('how_to_collect_image')->singleFile();
        $this->addMediaCollection('banner_image')->singleFile();
    }

    public function getHowItWorks1IconAttribute()
    {
        return $this->getFirstMedia('how_it_works_1_icon');
    }

    public function getHowItWorks2IconAttribute()
    {
        return $this->getFirstMedia('how_it_works_2_icon');
    }

    public function getHowItWorks3IconAttribute()
    {
        return $this->getFirstMedia('how_it_works_3_icon');
    }

    public function getHowToCollectImageAttribute()
    {
        return $this->getFirstMedia('how_to_collect_image');
    }

    public function getBannerImageAttribute()
    {
        return $this->getFirstMedia('banner_image');
    }
}
