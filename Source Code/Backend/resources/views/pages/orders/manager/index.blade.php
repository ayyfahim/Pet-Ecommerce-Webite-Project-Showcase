@extends('layouts.admin.dashboard')
@section('title','Orders')
@section('d-filters')
    <div class="row mb-1">
        <div class="col-md-4">
            <input class="form-control" name="order_id" value="{{request('order_id')}}"
                   placeholder="Order ID">
        </div>
        <div class="col-md-4">
            <select class="form-control select2" name="status_id" data-width="100%">
                <option value="all">Status</option>
                @foreach($status as $item)
                    <option @if(request('status_id') == $item->id) selected
                            @endif value="{{$item->id}}">{{$item->title}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <input class="form-control" name="coupon_code" value="{{request('coupon_code')}}"
                   placeholder="Coupon Code">
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-12 col-md-6">
            <input type="text" id="fp-default" class="form-control flatpickr-basic"
                   name="from"
                   placeholder="Date From"
                   value="{{request('from')}}"/>
        </div>
        <div class="col-12 col-md-6">
            <input type="text" id="fp-default" class="form-control flatpickr-basic"
                   name="to"
                   placeholder="Date To"
                   value="{{request('to')}}"/>
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-md-4">
            <input class="form-control" name="customer_name" value="{{request('customer_name')}}"
                   placeholder="Customer Name">
        </div>
        <div class="col-md-4">
            <input class="form-control" name="customer_phone" value="{{request('customer_phone')}}"
                   placeholder="Customer Phone">
        </div>
        <div class="col-md-4">
            <input class="form-control" name="customer_email" value="{{request('customer_email')}}"
                   placeholder="Customer Email">
        </div>
    </div>
    <div class="row mb-1">

        <div class="col-md-3">
            <select class="form-control select2" name="payment_method_id" data-width="100%">
                <option value="all">Payment Method</option>
                @foreach($payment_methods as $item)
                    <option @if(request('payment_method_id') == $item->id) selected
                            @endif value="{{$item->id}}">{{$item->title}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-control select2" name="shipping_method_id" data-width="100%">
                <option value="all">Shipping Method</option>
                @foreach($shipping_methods as $item)
                    <option @if(request('shipping_method_id') == $item->id) selected
                            @endif value="{{$item->id}}">{{$item->title}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input class="form-control" name="tracking_code" value="{{request('tracking_code')}}"
                   placeholder="Tracking Code">
        </div>
        <div class="col-md-3">
            <input class="form-control" name="shipped_at" value="{{request('shipped_at')}}"
                   placeholder="Shipping Date">
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <select class="form-control select2" name="category_id" data-width="100%">
                <option value="">Category</option>
                @foreach($childCategories as $key=>$categories)
                    <optgroup label="{{$key}}">
                        @foreach($categories as $category)
                            <option
                                @if(request('category_id') == $category->id) selected
                                @endif value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select class="form-control select2" name="product_id" data-width="100%">
                <option value="">Product</option>
                @foreach($products as $product)
                    <option
                        @if(request('product_id') == $product->id) selected
                        @endif value="{{$product->id}}">{{$product->info->title}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select class="form-control select2" name="vendor_id" data-width="100%">
                <option value="">Supplier</option>
                @foreach($vendors as $vendor)
                    <option
                        @if(request('vendor_id') == $vendor->id) selected
                        @endif value="{{$vendor->id}}">{{$vendor->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
@endsection
@section('d-filters-btn')
    <a href="{{route('order.admin.export',request()->getQueryString())}}" class="btn btn-warning">Export
        Results</a>
@endsection
@section('filter-route',route('order.admin.index'))
@section('d-content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <h5 class="card-title">{{$helper->pagination_label($orders)}}</h5>
            <div class="card">
                <div class="table-responsive">
                    @include('pages.orders.manager.partials.list')
                    @include('layouts.admin.partials.pagination',['collection'=>$orders])
                </div>
            </div>
        </div>
    </div>

@endsection
