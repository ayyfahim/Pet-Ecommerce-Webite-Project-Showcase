<?php

namespace App\Models;


use App\Models\Traits\HasMedia;
use App\Models\Traits\HasSlug;
use App\Models\Traits\HasStatus;
use Spatie\MediaLibrary\HasMedia\HasMedia as HasMediaContract;

class Page extends BaseModel implements HasMediaContract
{
    use HasStatus, HasSlug, HasMedia;
    public $categories = ['About', 'Help & Support', 'Corporate'];
    protected $casts = [
        'info' => 'array'
    ];

    public function getCoverAttribute()
    {
        return $this->getFirstMedia('cover');
    }

    public function getGalleryAttribute()
    {
        return $this->getMedia('gallery');
    }
}
