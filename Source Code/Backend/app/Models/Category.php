<?php

namespace App\Models;

use App\Models\Traits\HasAttributes;
use App\Models\Traits\HasSlug;
use App\Models\Traits\HasSortings;
use App\Models\Traits\HasStatus;
use App\Models\Traits\HasTags;
use App\Models\Traits\HasMedia;
use App\User;
use Kalnoy\Nestedset\NodeTrait;

use Spatie\MediaLibrary\HasMedia\HasMedia as HasMediaContract;

class Category extends BaseModel implements HasMediaContract
{
    use NodeTrait,
        HasStatus,
        HasMedia,
        HasSlug,
        HasAttributes,
        HasSortings;

//    protected $with = ['parent'];
    public $translatable = ['name', 'description'];
    protected $deleteCascade = ['descendants'];
    public $casts = ['featured' => 'boolean'];
    protected static $sorting_options = [4, 24];

    /* ========================================================================== */
    /*                                  ACCESSORS                                 */
    /* ========================================================================== */
    public function getIsActiveAttribute()
    {
        return $this->status->order == 1;
    }
    /* ========================================================================== */
    /*                                  Helpers                                 */
    /* ========================================================================== */

    public function scopeLastLevel($query)
    {
        return $query->doesnthave('children');
    }

    public function getNodeRootName()
    {
        return $this->ancestors->first()->name;
    }

    public function getBadgeAttribute()
    {
        return $this->getFirstMedia('badge');
    }


    public function getIconAttribute()
    {
        return $this->getFirstMedia('icon');
    }

    public function getPathAttribute()
    {
        if ($parent = $this->parent) {
            $path = [];
            $path[] = $parent->name;
            if ($parent = $parent->parent) {
                $path[] = $parent->name;
                if ($parent = $parent->parent) {
                    $path[] = $parent->name;
                }
            }
            return implode('/', array_reverse($path));
        }
    }

    public
    function assigns()
    {
        return $this->hasMany(Categorisable::class);
    }

    public function products()
    {
        return $this->morphedByMany(
            ProductInfo::class,
            'categorisable'
        );
    }

    public function attributes()
    {
        return $this->hasMany(RelatedAttribute::class)->whereHas('attribute', function ($query) {
            $query->where('category', true);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order_products()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function getSalesQuantityAttribute()
    {
        $total = $this->order_products->sum('quantity');
        if ($this->children()->count()) {
            foreach ($this->children as $child) {
                $total += $child->order_products->sum('quantity');
                if ($child->children()->count()) {
                    foreach ($child->children as $childChild) {
                        $total += $childChild->order_products->sum('quantity');
                        if ($childChild->children()->count()) {
                            foreach ($childChild->children as $childChildChild) {
                                $total += $childChildChild->order_products->sum('quantity');
                            }
                        }
                    }
                }
            }
        }
        return $total;
    }

    public function getSalesAmountAttribute()
    {
        $total = $this->order_products->sum('total');
        if ($this->children()->count()) {
            foreach ($this->children as $child) {
                $total += $child->order_products->sum('total');
                if ($child->children()->count()) {
                    foreach ($child->children as $childChild) {
                        $total += $childChild->order_products->sum('total');
                        if ($childChild->children()->count()) {
                            foreach ($childChild->children as $childChildChild) {
                                $total += $childChildChild->order_products->sum('total');
                            }
                        }
                    }
                }
            }
        }
        return $total;
    }

    public function getProductsCountAttribute()
    {
        $total = $this->products()->count();
        if ($this->children()->count()) {
            foreach ($this->children as $child) {
                $total += $child->products()->count();
                if ($child->children()->count()) {
                    foreach ($child->children as $childChild) {
                        $total += $childChild->products()->count();
                        if ($childChild->children()->count()) {
                            foreach ($childChild->children as $childChildChild) {
                                $total += $childChildChild->products()->count();
                            }
                        }
                    }
                }
            }
        }
        return $total;
    }
}
