<?php

namespace App\Http\Controllers\Traits\Order;

trait Filtration
{
    protected function filterData($request, $collection)
    {
        $status_id = $request->status_id == 'all' ? null : $request->status_id;
        // Common
        $order_id = $request->order_id;
        $customer_name = $request->customer_name;
        $customer_phone = $request->customer_phone;
        $customer_email = $request->customer_email;
        $payment_method_id = $request->payment_method_id == 'all' ? null : $request->payment_method_id;
        $shipping_method_id = $request->shipping_method_id == 'all' ? null : $request->shipping_method_id;
        $category_id = $request->category_id;
        $product_id = $request->product_id;
        $tracking_code = $request->tracking_code;
        $coupon_code = $request->coupon_code;
        $shipped_at = $request->shipped_at;
        $vendor_id = $request->vendor_id;
        $created_at_from = $request->created_at_from;
        $created_at_to = $request->created_at_to;
        $collection->when($status_id, function ($query) use ($status_id) {
            $query->where('status_id', $status_id);
        });
        $collection->when($payment_method_id, function ($query) use ($payment_method_id) {
            $query->where('payment_method_id', $payment_method_id);
        });
        $collection->when($shipping_method_id, function ($query) use ($shipping_method_id) {
            $query->where('shipping_method_id', $shipping_method_id);
        });
        $collection->when($tracking_code, function ($query) use ($tracking_code) {
            $query->where('tracking_code', $tracking_code);
        });
        $collection->when($shipped_at, function ($query) use ($shipped_at) {
            $query->where('shipped_at', $shipped_at);
        });
        $collection->when($coupon_code, function ($query) use ($coupon_code) {
            $query->whereHas('cart', function ($query) use ($coupon_code) {
                $query->whereHas('coupon', function ($query) use ($coupon_code) {
                    $query->where('code', $coupon_code);
                });
            });
        });
        $collection->when($created_at_from, function ($query) use ($created_at_from) {
            $query->where('created_at', '>=', $created_at_from);
        });
        $collection->when($created_at_to, function ($query) use ($created_at_to) {
            $query->where('created_at', '<=', $created_at_to);
        });
        $collection->when($order_id, function ($query) use ($order_id) {
            $query->where('id', 'like', "%$order_id%");
        });
        $collection->when($customer_name, function ($query) use ($customer_name) {
            $query->whereHas('user', function ($query) use ($customer_name) {
                $query->whereRaw('lower(full_name) like ?', ['%' . strtolower($customer_name) . '%']);
            });
        });
        $collection->when($customer_email, function ($query) use ($customer_email) {
            $query->whereHas('address_info', function ($query) use ($customer_email) {
                $query->whereRaw('lower(email) like ?', ['%' . strtolower($customer_email) . '%']);
            });
        });
        $collection->when($customer_phone, function ($query) use ($customer_phone) {
            $query->whereHas('address_info', function ($query) use ($customer_phone) {
                $query->whereRaw('lower(phone) like ?', ['%' . strtolower($customer_phone) . '%']);
            });
        });
        $collection->when($category_id, function ($query) use ($category_id) {
            $query->whereHas('order_products', function ($query) use ($category_id) {
                $query->where('category_id', $category_id);
            });
        });
        $collection->when($product_id, function ($query) use ($product_id) {
            $query->whereHas('order_products', function ($query) use ($product_id) {
                $query->where('product_id', $product_id);
            });
        });
        $collection->when($vendor_id, function ($query) use ($vendor_id) {
            $query->whereHas('order_products', function ($query) use ($vendor_id) {
                $query->whereHas('product', function ($query) use ($vendor_id) {
                    $query->whereHas('info', function ($query) use ($vendor_id) {
                        $query->where('vendor_id', $vendor_id);
                    });
                });
            });
        });
        return $collection;
    }
}
