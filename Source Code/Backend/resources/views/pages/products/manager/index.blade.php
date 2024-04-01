@extends('layouts.admin.dashboard')
@section('title','Products')
@section('d-buttons')
    @permission('add_products')
    <a href="{{route('product.admin.create')}}" class="btn btn-primary btn-block">New Product</a>
    @endpermission
@endsection
@section('d-filters')
    <div class="row mb-1">
        <div class="col-md-3">
            <input class="form-control" name="q" value="{{request('q')}}" placeholder="Search..">
        </div>
        <div class="col-md-3">
            <select class="form-control select2" name="status_id" data-width="100%">
                <option value="all">Status</option>
                @foreach($status as $item)
                    <option @if(request('status_id') == $item->id) selected
                            @endif value="{{$item->id}}">{{$item->title}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-control select2" name="featured" data-width="100%">
                <option value="all">Featured</option>
                @foreach(['Yes','No'] as $item)
                    <option @if(request('featured') == $item) selected
                            @endif value="{{$item}}">{{$item}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-control select2" name="stock_status" data-width="100%">
                <option value="all">Stock</option>
                @foreach(['in','out'] as $item)
                    <option @if(request('stock_status') == $item) selected
                            @endif value="{{$item}}">{{$item=='in'?'In Stock':'Out Of Stock'}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <select class="form-control select2" data-placeholder="Category" name="category_id"
                    data-width="100%">
                <option value="all">All Categories</option>
                @foreach($childCategories as $key=>$categories)
                    <optgroup label="{{$key}}">
                        @foreach($categories as $category)
                            <option
                                @if(request('category_id') == $category->id) selected @endif
                            value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select class="form-control select2" data-placeholder="Supplier" name="vendor_id" data-width="100%">
                <option value="all">All Suppliers</option>
                @foreach($vendors as $item)
                    <option @if(request('vendor_id') == $item->id) selected
                            @endif value="{{$item->id}}">{{$item->company_name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select class="form-control select2" data-placeholder="Brand" name="brand_id" data-width="100%">
                <option value="all">All Brands</option>
                @foreach($brands as $item)
                    <option @if(request('brand_id') == $item->id) selected
                            @endif value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
@endsection
@section('filter-route',route('product.admin.index'))
@section('d-filters-btn')
    <a href="{{route('product.admin.export',request()->getQueryString())}}" class="btn btn-warning">
        Export Results
    </a>
@endsection
@section('d-content')
    <div class="row">
        <div class="col-md-12 mb-2">
            <h5 class="card-title"></h5>
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-datatable table-bordered">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Price</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Supplier</th>
                            <th scope="col">Orders (No.)</th>
                            <th scope="col">Orders ($)</th>
                            <th scope="col">Upload Date</th>
                            <th scope="col">Last Update</th>
                            <th scope="col">Last Update By</th>
                            <th scope="col">Featured</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Status</th>
                            <th scope="col" style="width: 200px">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $key=>$product)
                            @include('pages.products.manager.partials.info')
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
@include('pages.products.manager.partials.scripts')
