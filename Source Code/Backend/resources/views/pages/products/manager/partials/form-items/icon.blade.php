<div class="icon-item">
    <div class="row">
        @php
            $product_icon = isset($product)?$product->product_icons()->where('icon_id',$icon->id)->first():null;
        @endphp
        @if($product_icon)
            <input type="hidden" name="icons[{{$key}}][id]" value="{{$product_icon->id}}">
        @endif
        <input type="hidden" name="icons[{{$key}}][icon_id]" value="{{$icon->id}}">
        <div class="col-md-2 text-center">
            <img width="50" src="{{$icon->getUrlFor('badge')}}" alt="">
            <br>
            <small class="text-muted">{{$icon->title}}</small>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label>Label</label>
                <input class="form-control"
                       value="{{$product_icon?$product_icon->label:''}}"
                       name="icons[{{$key}}][label]"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label>Helper Text</label>
                <input class="form-control"
                       value="{{$product_icon?$product_icon->helper:''}}"
                       name="icons[{{$key}}][helper]"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-12 text-center">
            <div class="demo-inline-spacing">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="icons[{{$key}}][enabled]"
                           @if($product_icon && $product_icon->enabled) checked @endif
                           id="icon-enabled-{{$key}}">
                    <label class="custom-control-label" for="icon-enabled-{{$key}}">Enabled</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="icons[{{$key}}][listing]"
                           @if($product_icon && $product_icon->listing) checked @endif
                           id="icon-listing-{{$key}}">
                    <label class="custom-control-label" for="icon-listing-{{$key}}">Use in Listing</label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mb-2"></div>
