@extends('layouts.admin.dashboard')
@section('title','Deals')
@section('d-buttons')
    @permission('add_products')
    <a href="{{route('deal.admin.create')}}" class="btn btn-primary btn-block">Add New Deal</a>
    @endpermission
@endsection
@section('d-filters')
    <div class="row mb-2">
        <div class="col-md-12 mb-2">
            <input class="form-control" name="q" value="{{request('q')}}" placeholder="Search..">
        </div>
        <div class="col-md-4">
            <select class="form-control select2" name="product_id" data-width="100%">
                <option value="">All Products</option>
                @foreach($products as $product)
                    <option
                        @if(request('product_id') == $product->id) selected
                        @endif value="{{$product->id}}">{{$product->info->title}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 mb-2">
            <select class="form-control select2" data-placeholder="Category" name="category_id"
                    data-width="100%">
                <option value=""></option>
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
            <select class="form-control select2" data-placeholder="Brand" name="brand_id" data-width="100%">
                <option value="">All Brands</option>
                @foreach($brands as $item)
                    <option @if(request('brand_id') == $item->id) selected
                            @endif value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select class="form-control select2" data-placeholder="Supplier" name="vendor_id" data-width="100%">
                <option value="">All Suppliers</option>
                @foreach($vendors as $item)
                    <option @if(request('vendor_id') == $item->id) selected
                            @endif value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-4">
            <input type="text" id="fp-default" class="form-control flatpickr-basic"
                   name="from"
                   placeholder="Date From"
                   value="{{request('from')}}"/>
        </div>
        <div class="col-12 col-md-4">
            <input type="text" id="fp-default" class="form-control flatpickr-basic"
                   name="to"
                   placeholder="Date To"
                   value="{{request('to')}}"/>
        </div>
    </div>
@endsection
@section('filter-route',route('deal.admin.index'))
@section('d-content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <h5 class="card-title"></h5>
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-datatable table-bordered">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Product ID</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Price</th>
                            <th scope="col">Deal Price</th>
                            <th scope="col">Supplier</th>
                            <th scope="col">Orders</th>
                            <th scope="col">Sales</th>
                            <th scope="col">Start</th>
                            <th scope="col">End</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($deals as $key=>$deal)
                            @include('pages.deals.manager.partials.info')
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
