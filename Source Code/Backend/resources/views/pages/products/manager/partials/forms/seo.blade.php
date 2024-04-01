<div class="tab-pane fade" id="seo" role="tabpanel"
     aria-labelledby="main-tab">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>URL Key</label>
                <input class="form-control" value="{{isset($product)?$product->slug:''}}" name="slug"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-12">

            <div class="form-group">
                <label>SEO Title</label>
                <input class="form-control" value="{{isset($product)?$product->seo_title:''}}"
                       name="seo_title"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>SEO Description</label>
                <textarea class="form-control"
                          name="seo_description">{{isset($product)?$product->seo_description:''}}</textarea>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-12 col-md-12">
            <div class="form-group">
                <label>Keywords</label>
                <input type="text" class="form-control" name="keywords"
                       @isset($product) value="{{$product->keywords}}" @endif>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
    </div>
</div>
