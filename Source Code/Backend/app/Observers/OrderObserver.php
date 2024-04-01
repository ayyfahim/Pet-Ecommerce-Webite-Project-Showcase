<?php

namespace App\Observers;

use App\Http\Controllers\Traits\Order\HasEmails;
use App\Models\ConfigData;
use App\Notifications\SendNotification;
use App\Models\Order;
use App\Transformers\Traits\CartHelpers;
use App\User;
use Illuminate\Support\Facades\DB;

class OrderObserver
{
    use CartHelpers, HasEmails;

    /**
     * Handle the order "creating" event.
     */
    public function creating(Order $order)
    {
        $status = Order::getStatusFor('status');
        $order->status_id = $status->firstWhere('order', 1)->id;
        $order->totals_info = $this->getTotals($order->cart, $order->payment_method_id);
        $order->is_temp = true;
    }

    /**
     * Handle the order "created" event.
     * @param Order $order
     */
    public function created(Order $order)
    {
        //        if ($order->payment_method->order == 1 && !$order->is_temp) {
        //            $this->orderCreated($order);
        //        }
    }

    /**
     * Handle the order "updated" event.
     */
    public function updated(Order $order)
    {
        if ($order->wasChanged('is_temp')) {
            $order = $order->fresh();
            if ($order->is_temp === false) {
                $this->orderCreated($order);
            }
        }
        if ($order->wasChanged('status_id')) {
            $order = $order->fresh();
            // shipped
            if ($order->status->order == 2) {
                $this->order_ship($order);
            } // delivered
            elseif ($order->status->order == 3) {
                $this->order_delivery($order);
            } // canceled
            elseif ($order->status->order == 5) {
                $this->order_cancel($order);
            }
        }
    }

    private function orderCreated(Order $order)
    {
        DB::transaction(function () use ($order) {
            $user = $order->user;
            $exchange = isset(ConfigData::findByType('reward_point_exchange')->value) ? ConfigData::findByType('reward_point_exchange')->value : 0;
            
            if ($points = ConfigData::findByType('order_reward_point')->value) {
                $order->reward_points()->create([
                    'user_id' => $user->id,
                    'points' => (int) $points * (int) $order->totals_info['total'],
                    'exchange' => (float) $exchange
                ]);
            }

            if ($order->cart->use_points && isset($order->cart->points_used)) {
                $order->reward_points()->create([
                    'user_id' => $user->id,
                    'points' => (int) -$order->cart->points_used,
                    'exchange' => (float) $exchange
                ]);
            }
            // if ($points = ConfigData::findByType('order_reward_point')->value) {
            //     // $exchange = isset(ConfigData::findByType('reward_point_exchange')->value) ? ConfigData::findByType('reward_point_exchange')->value : 0;
            //     $order->reward_points()->create([
            //         'user_id' => $user->id,
            //         'points' => $points
            //     ]);
            // }
            $order->cart->update(['is_ordered' => true]);
            $user = $order->user;
            $cart = $user->activeCart;
            $cartBaskets = $cart->basket;
            foreach ($cartBaskets as $cartBasket) {
                if ($cartBasket->variation) {
                    $cartBasket->variation->decrement('quantity', $cartBasket->quantity);
                } else {
                    $cartBasket->product->decrement('quantity', $cartBasket->quantity);
                }
            }
            foreach ($order->cart->products as $product) {
                $category = $product->info->categories->first();
                $cartBasket = $order->cart->basket()->where('product_id', $product->id)->first();
                $quantity = 1;
                if ($cartBasket) {
                    $quantity = $cartBasket->quantity;
                }
                $order->order_products()->create([
                    'product_id' => $product->id,
                    'amount' => $product->info->price,
                    'quantity' => $quantity,
                    'brand_id' => $product->info->brand_id,
                    'vendor_id' => $product->vendor_id,
                    'category_id' => $category ? $category->id : null,
                    'coupon_id' => $order->cart->coupon ? $order->cart->coupon_id : null,
                ]);
            }

            // if ($order->payment_id) {
            //     $status = Order::getStatusFor('status');
            //     $order->update([
            //         'status_id' => $status->firstWhere('order', 6)->id
            //     ]);
            // }
        });

        $this->admin_order_create($order);
        $this->order_confirmation($order);
        // $this->supplier_order_create($order);
    }
}
