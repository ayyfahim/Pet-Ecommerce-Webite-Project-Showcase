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
use App\Models\Product;
use App\Models\ProductList;
use App\Notifications\SendNotification;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AdminProductOutOfStockNotifications implements ShouldQueue
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
        $admins = User::withRole('admin')->get();
        $products = Product::isSearchable()->where('quantity', '<', 5)->take(20)->get();
        $products_body = '';
        foreach ($products as $product) {
            $products_body .= "<a href='" . route('product.admin.edit', $product->id) . "'>{$product->info->title}</a><br>";
            $product->update(['admin_out_of_stock_notified' => true]);
        }
        if ($products_body) {
            new SendNotification('admin_product_out_of_stock', $admins, [
                'products' => $products_body,
            ]);
        }
    }
}
