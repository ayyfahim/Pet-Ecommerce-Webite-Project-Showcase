<div class="tab-pane fade" id="specification" role="tabpanel"
     aria-labelledby="specification-tab">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Specifications Description</label>
                <textarea class="form-control" style="height: 200px"
                          name="specifications_description">{{isset($product)?$product->specifications_description:''}}</textarea>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
    </div>
    <div class="specification-wrapper">
        @if(isset($product) && $product->specifications)
            @foreach(array_values($product->specifications) as $specificationKey=>$specificationItem)
                @include('pages.products.manager.partials.form-items.specification')
            @endforeach
        @else
            @include('pages.products.manager.partials.form-items.specification',['specificationKey'=>0])
        @endif
    </div>
    <div class="text-right">
        <button type="button" class="btn btn-sm btn-light add-specification-button ajax_without_form"
                data-action="{{route('product.admin.specification.add')}}"
                data-key="{{(isset($product) && $product->specification)?sizeof($product->specification)-1:0}}"
                data-method="POST"
                data-append="1"
                data-append-view-wrapper=".specification-wrapper">Add Specification
        </button>
    </div>
</div>
