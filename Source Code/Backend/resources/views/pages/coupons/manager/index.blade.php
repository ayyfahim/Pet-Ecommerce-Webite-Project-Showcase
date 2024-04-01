@extends('layouts.admin.dashboard')
@section('title','Coupons')
@section('d-buttons')
    @permission('add_coupons')
    <a href="{{route('coupon.admin.create')}}" class="btn btn-primary btn-block">New Coupon</a>
    @endpermission
@endsection
@section('d-filters')
    <div class="row mb-2">
        <div class="col-md-12">
            <input class="form-control" name="q" value="{{request('q')}}" placeholder="Search..">
        </div>
    </div>
    <div class="row mb-2">
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
    </div>
    <div class="row">
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
@endsection
@section('d-filters-btn')
    <a href="{{route('coupon.admin.export',request()->getQueryString())}}" class="btn btn-warning">
        Export Results
    </a>
@endsection
@section('filter-route',route('coupon.admin.index'))
@section('d-content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <h5 class="card-title">{{$helper->pagination_label($coupons)}}</h5>
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Code</th>
                            <th scope="col">Value</th>
                            <th scope="col">Type</th>
                            <th scope="col">Qtty Issued</th>
                            <th scope="col">Qtty Used</th>
                            <th scope="col">Sales</th>
                            <th scope="col">Start</th>
                            <th scope="col">End</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($coupons as $key=>$coupon)
                            @include('pages.coupons.manager.partials.info')
                        @endforeach
                        </tbody>
                    </table>
                    @include('layouts.admin.partials.pagination',['collection'=>$coupons])
                </div>
            </div>
        </div>
    </div>
@endsection
