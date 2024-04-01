<div class="tab-pane fade" id="shipping" role="tabpanel"
     aria-labelledby="shipping-tab">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Shipping Cost</label>
                <input class="form-control" value="{{isset($product)?$product->shipping_cost:''}}" name="shipping_cost"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Shipping Time in Days</label>
                <input class="form-control" value="{{isset($product)?$product->shipping_days:''}}" name="shipping_days"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
    </div>
</div>
