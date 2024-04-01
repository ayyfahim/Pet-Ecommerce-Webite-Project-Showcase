<?php
/**
 * Created by PhpStorm.
 * User: Road9-2
 * Date: 11/28/2019
 * Time: 4:47 PM
 */

namespace App\Jobs;

use App\Models\DiscountRule;
use App\Models\Order;
use App\Models\ProductList;
use App\Notifications\SendNotification;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProductOutOfStockNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $product_lists = ProductList::whereIn('type', ['wishlist', 'clinic'])
            ->where('out_of_stock_notified', false)
            ->whereHas('user', function ($query) {
                $query->isActive();
            })->whereHas('product', function ($query) {
                $query->isSearchable();
                $query->where('quantity', '<=', 0);
            })->get();
        foreach ($product_lists as $product_list) {
            $product = $product_list->product;
            new SendNotification('product_out_of_stock', $product_list->user, [
                'product-title' => $product->info->title,
                'product-link' => route('product.show', $product->slug),
                'product-slug' => $product->slug,
            ]);
            $product_list->update(['out_of_stock_notified' => true]);
        }
    }
}
