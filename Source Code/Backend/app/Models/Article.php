<?php

namespace App\Models;

use App\Models\Traits\HasMedia;
use App\Models\Traits\HasSlug;
use App\Models\Traits\HasStatus;
use App\User;
use Spatie\MediaLibrary\HasMedia\HasMedia as HasMediaContract;

class Article extends BaseModel implements HasMediaContract
{
    use HasStatus, HasMedia, HasSlug;
    protected $with = ['user'];
    // protected $casts = [
    //     'author' => 'array'
    // ];

    public function getCoverAttribute()
    {
        return $this->getFirstMedia('cover');
    }

    public function getAvatarAttribute()
    {
        return $this->getFirstMedia('avatar');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }
}
