@csrf
<div class="row">
    <div class="col-md-12 mb-2">
        <label>Excluded Products</label>
        <select class="form-control select2" multiple name="excluded_products[]" data-width="100%">
            @foreach($products as $product)
                <option
                    @if($social_feed->excluded_products && in_array($product->id,$social_feed->excluded_products)) selected
                    @endif value="{{$product->id}}">{{$product->info->title}}</option>
            @endforeach
        </select>
        @include('layouts.admin.partials.form-errors')
    </div>
    <div class="col-md-12 mb-2">
        <label>Excluded Categories</label>
        <select class="form-control select2" multiple name="excluded_categories[]" data-width="100%">
            @foreach($childCategories as $key=>$categories)
                <optgroup label="{{$key}}">
                    @foreach($categories as $category)
                        <option
                            @if($social_feed->excluded_categories && in_array($category->id,$social_feed->excluded_categories)) selected
                            @endif value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>
        @include('layouts.admin.partials.form-errors')
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-8">
        <div class="form-group">
            <label>CSV File URL</label>
            <div>
                <a href="{{$social_feed->file_name}}" target="_blank" class="btn btn-link">{{$social_feed->file_name}}</a>
            </div>
            <div></div>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="form-group" style="padding-top: 25px">
            <a href="{{route('social_feed.admin.export',$social_feed->title)}}"
                    class="btn btn-dark btn-block">Sync Now
            </a>
            <small>if you made any changes, you'll have to submit the form first</small>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <label>Frequency</label>
        <select class="form-control select2" name="frequency" data-width="100%">
            @foreach([1,3,6,12,24] as $item)
                <option @if(isset($social_feed) && $social_feed->frequency == $item) selected
                        @endif value="{{$item}}">Every {{$item}} Hour
                </option>
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
