<?php

namespace App\Http\Controllers\Traits;

trait CouponFiltration
{
    protected function filterData($request, $collection)
    {
        $title = $request->q;
        $status_id = $request->status_id == 'all' ? null : $request->status_id;
        $category_id = $request->category_id;
        $product_id = $request->product_id;
        $from = $request->from;
        $to = $request->to;
        $collection->when($title, function ($query) use ($title) {
            $query->where(function ($query) use ($title) {
                $query->whereRaw('lower(title) like ?', ['%' . strtolower($title) . '%']);
                $query->orWhereRaw('lower(code) like ?', ['%' . strtolower($title) . '%']);
                $query->orWhereRaw('lower(description) like ?', ['%' . strtolower($title) . '%']);
            });
        });
        $collection->when($status_id, function ($query) use ($status_id) {
            $query->where('status_id', $status_id);
        });
        $collection->when($category_id, function ($query) use ($category_id) {
            $query->whereHas('categories', function ($query) use ($category_id) {
                $query->where('id', $category_id);
            });
        });
        $collection->when($product_id, function ($query) use ($product_id) {
            $query->whereHas('products', function ($query) use ($product_id) {
                $query->where('product_id', $product_id);
            });
        });
        $collection->when($from, function ($query) use ($from) {
            $query->where('from', '>=', $from);
        });
        $collection->when($to, function ($query) use ($to) {
            $query->where('to', '<=', $to);
        });
        return $collection;
    }
}
