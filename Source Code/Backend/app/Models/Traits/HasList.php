<?php
/**
 * Created by PhpStorm.
 * User: Road9-2
 * Date: 7/29/2020
 * Time: 12:59 PM
 */

namespace App\Models\Traits;


use App\Models\ProductList;

trait HasList
{
    public function lists()
    {
        return $this->hasMany(ProductList::class);
    }
    public function wishlist()
    {
        return $this->lists()->whereType('wishlist');
    }
    public function compare()
    {
        return $this->lists()->whereType('compare');
    }
    public function clinic()
    {
        return $this->lists()->whereType('clinic');
    }
}