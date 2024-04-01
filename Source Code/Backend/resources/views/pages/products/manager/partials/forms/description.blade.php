<div class="tab-pane" id="description" role="tabpanel"
     aria-labelledby="description-tab">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Short Description</label>
                <textarea class="form-control tinymce-text" style="height: 300px"
                          name="excerpt">{{isset($product)?$product->info->excerpt:''}}</textarea>
                @include('layouts.admin.partials.form-errors')
            </div>
            <label class="form-group has-float-label mb-2">

                <span></span>
                @include('layouts.partials.form-errors',['field'=>"excerpt"])
            </label>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Long Description</label>
                <textarea class="form-control tinymce-text" style="height: 400px"
                          name="description">{{isset($product)?$product->info->description:''}}</textarea>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Delivery Info</label>
                <textarea class="form-control tinymce-text" style="height: 400px"
                          name="delivery_information">{{isset($product)?$product->info->delivery_information:''}}</textarea>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Warranty Info</label>
                <textarea class="form-control tinymce-text" style="height: 400px"
                          name="warranty_information">{{isset($product)?$product->info->warranty_information:''}}</textarea>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Terms & Conditions</label>
                <textarea class="form-control tinymce-text" style="height: 400px"
                          name="terms_conditions">{{isset($product)?$product->info->terms_conditions:''}}</textarea>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
    </div>
</div>
