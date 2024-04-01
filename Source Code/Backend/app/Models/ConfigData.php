<?php

namespace App\Models;

use App\Models\Traits\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMedia as HasMediaContract;

class ConfigData extends BaseModel implements HasMediaContract
{
    use HasMedia;
    protected $casts = [
        'info' => 'array'
    ];
    public $groups = [
        'site_settings', 'contact', 'social_media', 'checkout', 'seo', 'integration',
        'coupon',
    ];

    public function scopeFindByType($query, $type)
    {
        return $query->where('title', $type)->first();
    }

    public function scopeFindByGroup($query, $group)
    {
        return $query->where('group', $group)->orderBy('order');
    }

    public function getLabelAttribute()
    {
        $label = str_replace($this->group, '', $this->title);
        return ucwords(str_replace('_', ' ', $label));
    }

    public function getCoverAttribute()
    {
        return $this->getFirstMedia('cover');
    }
}
