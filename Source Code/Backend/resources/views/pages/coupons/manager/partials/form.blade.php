@csrf
<input type="hidden" name="status_id" @isset($coupon) value="{{$coupon->status_id}}" @endisset>
@php
    $has_category = isset($coupon) && $coupon->category;
@endphp
<div class="row">
    <div class="col-12 col-md-9">
        <div class="form-group">
            <label>Title</label>
            <input class="form-control" value="{{isset($coupon)?$coupon->title:''}}" name="title"/>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="form-group">
            <label>Status</label>
            <select data-minimum-results-for-search="Infinity" class="form-control text-capitalize select2"
                    name="status_id">
                @foreach($status as $statusItem)
                    <option @if(isset($child) && $child->status_id == $statusItem->id) selected
                            @elseif($statusItem->order == 1) selected
                            @endif value="{{$statusItem->id}}">{{$statusItem->title}}</option>
                @endforeach
            </select>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" name="description">{{isset($coupon)?$coupon->description:''}}</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Coupon Code</label>
            <input class="form-control" value="{{isset($coupon)?$coupon->code:''}}" name="code"/>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="form-group">
            <label>Uses Per Coupon</label>
            <input class="form-control" type="number" value="{{isset($coupon)?$coupon->uses_per_coupon:''}}"
                   name="uses_per_coupon"/>
            <small class="form-text text-muted">Leave -1 for unlimited usage</small>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="form-group">
            <label>Uses Per Customer</label>
            <input class="form-control" type="number" value="{{isset($coupon)?$coupon->uses_per_customer:''}}"
                   name="uses_per_customer"/>
            <small class="form-text text-muted">Leave -1 for unlimited usage</small>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-6 mb-2">
        <label>Date From</label>
        <input type="text" id="fp-default" class="form-control flatpickr-basic"
               name="from"
               placeholder="Date From"
               value="{{isset($coupon)?$coupon->from:''}}"/>
        @include('layouts.admin.partials.form-errors')
    </div>
    <div class="col-12 col-md-6 mb-2">
        <label>Date To</label>
        <input type="text" id="fp-default" class="form-control flatpickr-basic"
               name="to"
               placeholder="Date To"
               value="{{isset($coupon)?$coupon->to:''}}"/>
        @include('layouts.admin.partials.form-errors')
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <label>Discount Type</label>
        <select class="form-control select2" required data-placeholder="Fixed/Percentage" name="discount_type"
                data-width="100%">
            <option value=""></option>
            @foreach(['Fixed Amount','Percentage'] as $type)
                <option class="text-capitalize"
                        @if(isset($coupon) && $coupon->discount_type == $type) selected
                        @endif
                        value="{{$type}}">{{$type}}</option>
            @endforeach
        </select>
        @include('layouts.admin.partials.form-errors')
    </div>
    <div class="col-12 col-md-4">
        <div class="form-group">
            <label>Discount Amount</label>
            <input class="form-control" type="number" step="0.01"
                   value="{{isset($coupon)?$coupon->discount_amount:''}}"
                   name="discount_amount"/>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="form-group">
            <label>Minimum Order</label>
            <input class="form-control" type="number" step="0.01" value="{{isset($coupon)?$coupon->min_order:''}}"
                   name="min_order"/>

            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 mb-4">
        <span class="text-muted">Categories</span>
        <div class="my-2">
            <button data-toggle="modal" data-target="#categoryTreeModal"
                    type="button" class="btn btn-secondary btn-sm">
                @if($has_category)
                    Change Category
                @else
                    Select Category
                @endif
            </button>
        </div>
        <div class="categories-text" style="margin: 5px auto;">
            @if($has_category)
                @foreach($coupon->categories as $category)
                    <div class='category-value'>{{$category->name}}</div>
                @endforeach
            @endif
        </div>
        @include('pages.coupons.manager.partials.category-select')
        @include("layouts.partials.form-errors",['field'=>'categories'])
    </div>
    <div class="col-md-12 mb-4">
        <label>Products</label>
        <select class="form-control select2" data-placeholder="All" name="products[]" multiple
                data-width="100%">
            <option value="">All</option>
            @foreach($products as $product)
                <option
                    @if(isset($coupon) && in_array($product->id,$coupon->products->pluck('product_id')->toArray())) selected
                    @endif value="{{$product->id}}">{{$product->info->title}}</option>
            @endforeach
        </select>
        @include('layouts.admin.partials.form-errors')
    </div>
</div>
<hr>
<div class="row">
    <div class="col-12 text-right mt-1">
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{url()->previous()}}" class="btn btn-outline-secondary">Cancel</a>
    </div>
</div>
