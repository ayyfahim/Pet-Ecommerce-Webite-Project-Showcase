<?php

namespace App\Observers;

use App\Models\Brand;
use App\Models\ProductInfo;
use App\Models\Vendor;

class ProductInfoObserver
{
    /**
     * Handle the order "creating" event.
     * @param ProductInfo $product_info
     */
    public function creating(ProductInfo $product_info)
    {
//        $product_info->brand_id = $product_info->brand_id ?: Brand::where('default', true)->first()->id;
//        $product_info->vendor_id = $product_info->vendor_id ?: Vendor::where('default', true)->first()->id;
    }

    /**
     * Handle the product_info "created" event.
     *
     * @param ProductInfo $product_info
     */
    public function created(ProductInfo $product_info)
    {
    }

    /**
     * Handle the product_info "updated" event.
     *
     * @param ProductInfo $product_info
     */
    public function updated(ProductInfo $product_info)
    {

    }

    /**
     * Handle the product_info "deleted" event.
     *
     * @param ProductInfo $product_info
     */
    public function deleted(ProductInfo $product_info)
    {
    }

    /**
     * Handle the product_info "restored" event.
     *
     * @param ProductInfo $product_info
     */
    public function restored(ProductInfo $product_info)
    {
    }

    /**
     * Handle the product_info "force deleted" event.
     *
     * @param ProductInfo $product_info
     */
    public function forceDeleted(ProductInfo $product_info)
    {
    }
}
