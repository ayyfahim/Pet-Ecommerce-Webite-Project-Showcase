<?php

namespace App\Models;

use App\Models\Traits\HasCategories;
use App\Models\Traits\HasSoftDeletes;


class ProductInfo extends BaseModel
{
    use HasCategories,
        HasSoftDeletes;

    protected $casts = ['faq' => 'array', 'additional' => 'array', 'cities' => 'array'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function concern()
    {
        return $this->belongsTo(Concern::class);
    }

    public function concerns()
    {
        return $this->belongsToMany(Concern::class, 'concern_product_info');
    }

    public function breed()
    {
        return $this->belongsTo(Breed::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }


    public function getIsActiveAttribute()
    {
        return $this->status->order == 1;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->sale_price && $this->regular_price) {
            return ($this->regular_price - $this->sale_price) / $this->regular_price * 100;
        }
        return false;
    }

    public function getDiscountAmountAttribute()
    {
        if ($this->sale_price && $this->regular_price) {
            return ($this->regular_price - $this->sale_price);
        }
        return false;
    }

    public function getPriceAttribute()
    {
        $price = $this->sale_price ?: 0;
        if ($this->product->deal) {
            $price = $this->product->deal->price;
        }
        return $price ?: $this->regular_price;
    }


    public function getIsFeaturedAttribute()
    {
        return $this->featured != 0;
    }

    public function setSalePriceAttribute($value)
    {
        $this->attributes['sale_price'] = $value ?: 0;
    }

    public function setVideoUrlAttribute($video_url)
    {
        if ($video_url) {
            if (!strpos($video_url, 'embed') && strpos($video_url, 'youtu')) {
                if (strpos($video_url, 'v=')) {
                    $prefix = 'v=';
                    $index = strpos($video_url, $prefix) + strlen($prefix);
                    $video_id = substr($video_url, $index);
                    $video_id = explode('?', $video_id)[0];
                    $video_id = explode('&', $video_id)[0];
                    $this->attributes['video_url'] = 'https://www.youtube.com/embed/' . $video_id;
                } elseif (strpos($video_url, '.be/')) {
                    $prefix = '.be/';
                    $index = strpos($video_url, $prefix) + strlen($prefix);
                    $video_id = substr($video_url, $index);
                    $this->attributes['video_url'] = 'https://www.youtube.com/embed/' . $video_id;
                }
            } elseif (!strpos($video_url, 'player') && strpos($video_url, 'vimeo')) {
                if (strpos($video_url, 'com/')) {
                    $prefix = 'com/';
                    $index = strpos($video_url, $prefix) + strlen($prefix);
                    $video_id = substr($video_url, $index);
                    $video_id = explode('?', $video_id)[0];
                    $video_id = explode('&', $video_id)[0];
                    $this->attributes['video_url'] = 'https://player.vimeo.com/video/' . $video_id;
                }
            }
        } else {
            $this->attributes['video_url'] = null;
        }
    }
}
