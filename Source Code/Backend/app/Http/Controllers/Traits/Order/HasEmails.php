<?php


namespace App\Http\Controllers\Traits\Order;


use App\Models\CartBasket;
use App\Models\Order;
use App\Models\RewardPoint;
use App\Models\Vendor;
use App\Notifications\SendNotification;
use App\User;

trait HasEmails
{
    protected function order_confirmation(Order $order)
    {
        $voucher = [];
        foreach ($order->cart->basket as $cartBasket) {
            if ($cartBasket->product_info->voucher_code) {
                $voucher[] = $cartBasket->product_info->voucher_code;
            }
        }
        $shipping_info = '';
        $products_info = $this->getProductsInfo($order->cart->products, $order, true);
        $voucher = $products_info['voucher'];

        if (!$voucher) {
            $shipping_info = $this->getShippingInfo($order);
        }
        new SendNotification('order_confirmation', $order->user, [
            'order-short-id' => $order->short_id,
            'voucher-code' => $voucher ? implode(', ', $voucher) : '',
            'total-price' => number_format($order->amount, 2),
            'order-link' => route('order.index'),
            'products' => $products_info['products'],
            'shipping-info' => $shipping_info,
        ]);
    }

    protected function admin_order_create(Order $order)
    {
        $voucher = [];
        foreach ($order->cart->basket as $cartBasket) {
            if ($cartBasket->product_info->voucher_code) {
                $voucher[] = $cartBasket->product_info->voucher_code;
            }
        }
        $shipping_info = '';
        $products_info = $this->getProductsInfo($order->cart->products, $order);
        $voucher = $products_info['voucher'];

        if (!$voucher) {
            $shipping_info = $this->getShippingInfo($order);
        }
        new SendNotification('admin_order_create', User::withRole('admin')->get(), [
            'order-short-id' => $order->short_id,
            'total-price' => number_format($order->amount, 2),
            'admin-order-link' => route('order.admin.show', $order->id),
            'order-full-id' => $order->id,
            'voucher-code' => $voucher ? implode(', ', $voucher) : '',
            'products' => $products_info['products'],
            'shipping-info' => $shipping_info,
        ]);
    }

    protected function supplier_order_create(Order $order)
    {
        $vendor_products = $order->cart->products->groupBy('info.vendor_id');
        foreach ($vendor_products as $vendor => $products) {
            $shipping_info = '';
            $products_info = $this->getProductsInfo($products, $order, false);
            $voucher = $products_info['voucher'];

            if (!$voucher) {
                $shipping_info = $this->getShippingInfo($order);
            }
            new SendNotification('supplier_order_create', Vendor::find($vendor), [
                'order-short-id' => $order->short_id,
                'voucher-code' => $voucher ? "Voucher Code: " . implode(', ', $voucher) : '',
                'products' => $products_info['products'],
                'shipping-info' => $shipping_info,
            ]);
        }
    }

    private function getShippingInfo(Order $order)
    {
        return $shipping_info = "<b>Shipping Address</b><br>{$order->address_info->name}<br>
                    {$order->address_info->title}<br>
                        {$order->address_info->business_name}<br>
                    {$order->address_info->street_address}<br>
                    {$order->address_info->area}, {$order->address_info->city}<br>
                    {$order->address_info->country},
                    {$order->address_info->postal_code}<br>
                    T: {$order->address_info->phone}<br>";
    }

    private function getProductsInfo($products, Order $order, $vendor = true)
    {
        $products_body = '';
        $voucher = [];
        $products_body .= "<table class='products'>
<tr>
<th>Product</th>
<th>Quantity</th>
<th>Variations</th>";
        if ($vendor) {
            $products_body .= "<th>Supplier</th>";
        }
        $products_body .= "</tr>";
        foreach ($products as $product) {
            $cartBasket = CartBasket::where('product_id', $product->id)->where('cart_id', $order->cart_id)->first();
            $products_body .= "<tr>
<td>{$product->info->title}</td>
<td>{$cartBasket->quantity}</td>
<td>";
            if ($cartBasket->options) {
                foreach ($cartBasket->options()->whereHas('option')->get() as $option) {
                    $option_value = $option->label;
                    $products_body .= "<div>
                        <b>{$option->option->attribute_name}: </b>
                        {$option_value}
                    </div>";
                }
            }
            $products_body .= "</td>";

            if ($vendor) {
                $vendor_name = $product->vendor ? $product->vendor->company_name : '';
                $products_body .= "<td>{$vendor_name}</td>";
            }
            if ($product->info->voucher_code) {
                $voucher[] = $product->info->voucher_code;
            }
            $products_body .= "</tr>";
        }
        $products_body .= "</table>";
        return ['products' => $products_body, 'voucher' => $voucher];
    }

    protected function order_ship(Order $order)
    {
        $tracking = $order->courrier ? $order->courrier->url : '';
        new SendNotification('order_ship', $order->user, [
            'order-short-id' => $order->short_id,
            'tracking-code' => $tracking . $order->tracking_code,
            'total-price' => number_format($order->amount, 2),
            'order-link' => route('order.index'),
        ]);
    }

    protected function order_delivery(Order $order)
    {
        new SendNotification('order_delivery', $order->user, [
            'order-short-id' => $order->short_id,
            'order-link' => route('order.index'),
        ]);
    }

    protected function order_cancel(Order $order)
    {
        new SendNotification('order_cancel', $order->user, [
            'order-short-id' => $order->short_id,
            'order-link' => route('order.index'),
            'reason' => $order->cancellation_reason,
        ]);
    }

    protected function points_create(RewardPoint $rewardpoint)
    {
        new SendNotification('points_create', $rewardpoint->user, [
            'order-short-id' => $rewardpoint->order->short_id,
            'points' => $rewardpoint->points,
            'total-points' => $rewardpoint->user->total_reward_points,
            'order-link' => route('order.index'),
        ]);
    }
}
