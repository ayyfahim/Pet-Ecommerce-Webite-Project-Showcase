<div class="tab-pane fade configurations-wrapper" id="attributes" role="tabpanel"
     aria-labelledby="main-tab">
    @foreach($product_attributes as $attributeMainKey=>$attribute)
        @include('pages.products.manager.partials.form-items.attribute-wrapper')
    @endforeach
    <div class="row">
        <div class="col-md-8 mb-2">
            <select class="form-control select2" id="attributes-attribute-id" data-width="100%">
                <option selected disabled value="0">Select Attribute</option>
                @foreach($attributes as $attribute)
                    <option value="{{$attribute->id}}">{{$attribute->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <button type="button"
                    data-product_id="{{isset($model)?$model->id:''}}"
                    data-action="{{route('product.admin.attribute.get')}}"
                    class="btn btn-outline-primary btn-block" id="attributes-assign-attribute">
                Assign
            </button>
        </div>
    </div>
    <div class="separator mb-5"></div>
    <input type="hidden" disabled name="index" value="{{sizeof($attributes)}}">
</div>
{{--<input type="hidden" disabled name="index" value="{{sizeof($attributes)}}">--}}
