<div class="tab-pane fade" id="notes" role="tabpanel"
     aria-labelledby="notes-tab">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Notes</label>
                <textarea class="form-control tinymce-text" rows="6" style="height: 400px"
                          name="notes">{{isset($product)?$product->info->notes:''}}</textarea>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
    </div>
</div>
