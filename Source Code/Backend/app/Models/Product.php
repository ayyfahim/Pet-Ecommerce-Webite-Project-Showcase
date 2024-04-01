<?php

namespace App\Models;

use App\Models\Traits\HasAttributes;
use App\Models\Traits\HasList;
use App\Models\Traits\HasMedia;
use App\Models\Traits\HasSlug;
use App\Models\Traits\HasSoftDeletes;
use App\Models\Traits\HasSortings;
use App\Models\Traits\HasStatus;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia\HasMedia as HasMediaContract;

class Product extends BaseModel implements HasMediaContract
{
    use HasMedia,
        HasSlug,
        HasStatus,
        HasAttributes,
        HasSortings,
        HasList,
        HasSoftDeletes;
    protected $with = ['info'];
    protected $casts = [
        'featured' => 'boolean',
        'show_brand' => 'boolean',
        'deal_show_counter' => 'boolean',
        'categories_ids' => 'array',
        'concern_ids' => 'array',
        'nutrition_facts_serving' => 'array',
        'nutrition_facts_weight' => 'array',
        'specifications' => 'array',
        'dosages' => 'array',
    ];
    protected $dates = [
        'deal_from',
        'deal_to',
    ];
    protected static $sorting_options = [1, 4, 5, 6, 7, 8, 9];

    public function infos()
    {
        return $this->hasMany(ProductInfo::class);
    }

    public function deals()
    {
        return $this->hasMany(Deal::class);
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
    public function deal()
    {
        return $this->hasOne(Deal::class)->latest();
    }
    public function active_deal()
    {
        return $this->hasOne(Deal::class)->latest()->today();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function info()
    {
        return $this->hasOne(ProductInfo::class)->where('active', true);
    }

    public function variations()
    {
        return $this->hasMany(Variation::class)->orderBy('created_at');
    }

    public function basket()
    {
        return $this->hasMany(CartBasket::class);
    }

    public function orders()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function product_icons()
    {
        return $this->hasMany(ProductIcon::class)->whereHas('icon');
    }

    public function compares()
    {
        return $this->specifications()->whereHas('attribute', function ($query) {
            $query->where('compare', true);
        });
    }

    public function attributes()
    {
        return $this->hasMany(RelatedAttribute::class)->whereHas('attribute', function ($query) {
            $query->where('product', true);
        });
    }

    public function scopeIsSearchable($query)
    {
        return $query
            ->isActive();
    }

    public function scopeOrderByTopSelling(Builder $query, $orderType = 'DESC')
    {
        $query->withCount('orders')->orderBy('orders_count', $orderType);
    }

    public function getCoverAttribute()
    {
        return $this->getMedia('gallery')->firstWhere('custom_properties.main', true);
    }

    public function getGalleryAttribute()
    {
        return $this->getMedia('gallery');
    }

    public function getAttachmentsAttribute()
    {
        return $this->getMedia('attachments');
    }

    public function getIsFeaturedAttribute()
    {
        return $this->featured;
    }

    public function getIsInStockAttribute()
    {
        return $this->quantity > 0;
    }

    public function getInStockLabelAttribute()
    {
        return $this->is_in_stock
            ? 'in stock'
            : 'out of stock';
    }

    public function getInStockColorAttribute()
    {
        return $this->is_in_stock
            ? 'success'
            : 'danger';
    }

    public function getFirstOptionsAttribute()
    {
        $options = [];
        foreach ($this->configurations as $productAttribute) {
            if (sizeof($productAttribute->configurations) > 1) {
                return false;
            }
            $options[] = $productAttribute->configurations->first()->id;

        }
        return $options;
    }

    public function getCategoriesIdsAttributeAttribute()
    {
        $ids = [];
        foreach ($this->info->categories as $category) {
            $ids[] = $category->id;
            if ($parent = $category->parent) {
                $ids[] = $parent->id;
                if ($parent = $category->parent) {
                    $ids[] = $parent->id;
                    if ($parent = $category->parent) {
                        $ids[] = $parent->id;
                    }
                }
            }
        }
//        dd($this->info->categories);
        return array_values(array_unique($ids));
    }

    public function getConcernIdsAttribute()
    {
        $ids = [];
        foreach ($this->info->concerns as $concern) {
            $ids[] = $concern->id;
        }
//        dd($this->info->categories);
        return array_values(array_unique($ids));
    }

    public function setVideoUrlsAttribute($video_urls)
    {
        if ($video_urls) {
            $this->attributes['video_urls'] = json_encode(array_values(array_filter($video_urls)));
        }
    }

    public function getOrdersNumberAttribute()
    {
        return $this->orders()->count();
    }

    public function getOrdersAmountAttribute()
    {
        return $this->orders->sum('amount');
    }

    public function isLikedBy($user)
    {
        return $this->wishlist()->where('user_id', $user->id)->count();
    }

    public function isInList($type)
    {
        return $this->getList($type)->count() > 0;
    }

    private function getList($type)
    {
        $lists = $this->lists()->whereType($type);
        if (auth()->check()) {
            $lists->where('user_id', auth()->user()->id);
        } else {
            $lists->where('session_id', session()->getId());
        }
        return $lists;
    }

    public function listId($type)
    {
        if ($list = $this->getList($type)->first())
            return $list->id;
        return false;
    }
}
