<div class="tab-pane show active" id="main" role="tabpanel"
     aria-labelledby="main-tab">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Title</label>
                <input class="form-control" value="{{isset($product)?$product->info->title:''}}" name="title"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Supplier Code</label>
                <input class="form-control" value="{{isset($product)?$product->supplier_code:''}}"
                       name="supplier_code"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>SKU / GTIN</label>
                <input class="form-control" value="{{isset($product)?$product->sku:''}}" name="sku"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label>Status</label>
                <select data-minimum-results-for-search="Infinity" class="form-control text-capitalize select2"
                        name="status_id">
                    @foreach($status as $statusItem)
                        <option @if(isset($product) && $product->status_id == $statusItem->id) selected
                                @elseif($statusItem->order == 1) selected
                                @endif value="{{$statusItem->id}}">{{$statusItem->title}}</option>
                    @endforeach
                </select>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label>Featured</label>
                <select data-minimum-results-for-search="Infinity" class="form-control text-capitalize select2"
                        name="featured">
                    @foreach([1,0] as $item)
                        <option @if(isset($product) && $product->featured == $item) selected
                                @elseif($item == 0) selected
                                @endif value="{{$item}}">{{$item==1?'Yes':'No'}}</option>
                    @endforeach
                </select>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-6 mb-2">
            <div class="uk-form-row">
                <label>Categories</label>
                <div class="categories-text" style="margin: 5px auto;">
                    @if(isset($product) && $product->info->categories)
                        @foreach($product->info->categories as $category)
                            <div class='category-value'>
                                {{$category->path?$category->path.'/'.$category->name:$category->name}}
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="uk-margin-top uk-margin-bottom">
                    <button
                        data-toggle="modal" data-target="#categoryTreeModal"
                        type="button" class="btn btn-dark">
                        @if(isset($product) && $product->info->categories)
                            Change Category
                        @else
                            Select Category
                        @endif
                    </button>
                </div>
                @include('pages.products.manager.partials.category-select',['categories_holder'=>isset($product) && $product->info->categories?$product->info:null])
                @include("layouts.partials.form-errors",['field'=>'categories'])
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Additional Categories</label>
                <input class="form-control" value="{{isset($product)?$product->additional_categories:''}}"
                       name="additional_categories"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Google Category</label>
                <select class="form-control text-capitalize select2"
                        name="google_category">
                    <option value=""></option>
                    @foreach($google_categories as $item)
                        <option @if(isset($product) && $product->google_category == $item) selected
                                @endif value="{{$item}}">{{$item}}</option>
                    @endforeach
                </select>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-4 mb-2">
            <label>Supplier</label>
            <select class="form-control select2" name="vendor_id" data-width="100%">
                <option value=""></option>
                @foreach($vendors as $vendor)
                    <option @if(isset($product) && $product->vendor_id == $vendor->id) selected
                            @endif value="{{$vendor->id}}">{{$vendor->company_name}}</option>
                @endforeach
            </select>
            @include('layouts.partials.form-errors',['field'=>"vendor_id"])
        </div>
        <div class="col-md-4 mb-2">
            <label>Brand</label>
            <select class="form-control select2" name="brand_id" data-width="100%">
                <option value=""></option>
                @foreach($brands as $brand)
                    <option @if(isset($product) && $product->info->brand_id == $brand->id) selected
                            @endif value="{{$brand->id}}">{{$brand->name}}</option>
                @endforeach
            </select>
            @include('layouts.partials.form-errors',['field'=>"brand_id"])
        </div>
        <div class="col-md-4 mb-2">
            <label>Concern</label>
            <select class="form-control select2" name="concerns[]" data-width="100%" multiple>
                <option value=""></option>
                @foreach($concerns as $concern)
                    <option @if(isset($product) && isset($product->info->concerns) && $product->info->concerns->contains($concern->id))
                            selected
                            @endif value="{{$concern->id}}">{{$concern->name}}</option>
                @endforeach
            </select>
            @include('layouts.partials.form-errors',['field'=>"concerns"])
        </div>
        <div class="col-md-4 mb-2">
            <label>Breed</label>
            <select class="form-control select2" name="breed_id" data-width="100%">
                <option value=""></option>
                @foreach($breeds as $breed)
                    <option @if(isset($product) && $product->info->breed_id == $breed->id)
                            selected
                            @endif value="{{$breed->id}}">{{$breed->name}}</option>
                @endforeach
            </select>
            @include('layouts.partials.form-errors',['field'=>"breed_id"])
        </div>

        <div class="col-12 col-md-4">
            <div class="form-group">
                <label>Show brand logo</label>
                <select data-minimum-results-for-search="Infinity" class="form-control text-capitalize select2"
                        name="show_brand">
                    @foreach([1,0] as $item)
                        <option @if(isset($product) && $product->show_brand == $item) selected
                                @elseif($item == 1) selected
                                @endif value="{{$item}}">{{$item==1?'Yes':'No'}}</option>
                    @endforeach
                </select>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Affiliate Link</label>
                <input class="form-control" value="{{isset($product)?$product->affiliate_link:''}}"
                       name="affiliate_link"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Youtube Video</label>
                <input class="form-control" value="{{isset($product)?$product->info->video_url:''}}" name="video_url"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Supplier Cost Price</label>
                <input class="form-control" type="number" step=".01"
                       value="{{isset($product)?$product->info->cost_price:''}}" name="cost_price"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Supplier Regular Price</label>
                <input class="form-control" type="number" step=".01"
                       value="{{isset($product)?$product->info->supplier_regular_price:''}}"
                       name="supplier_regular_price"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Supplier Recommended Sale Price</label>
                <input class="form-control" type="number" step=".01"
                       value="{{isset($product)?$product->info->supplier_sale_price:''}}" name="supplier_sale_price"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Regular Price</label>
                <input class="form-control" type="number" step=".01"
                       value="{{isset($product)?$product->info->regular_price:''}}" name="regular_price"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Sale Price</label>
                <input class="form-control" type="number" step=".01"
                       value="{{isset($product)?$product->info->sale_price:''}}" name="sale_price"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Quantity</label>
                <input class="form-control" type="number"
                       value="{{isset($product)?$product->quantity:''}}" name="quantity"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Age</label>
                <input class="form-control" type="number"
                       value="{{isset($product)?$product->age:''}}" name="age"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
    </div>
</div>
