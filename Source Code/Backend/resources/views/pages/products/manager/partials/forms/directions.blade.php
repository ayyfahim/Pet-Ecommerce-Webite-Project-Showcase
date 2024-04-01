<div class="tab-pane fade" id="directions" role="tabpanel" aria-labelledby="dosage-tab">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Directions Description</label>
                <textarea class="form-control tinymce-text" style="height: 300px"
                    name="directions_description">{{isset($product)?$product->info->directions_description:''}}</textarea>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Dosages Description</label>
                <textarea class="form-control" style="height: 200px"
                    name="dosages_description">{{isset($product)?$product->dosages_description:''}}</textarea>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
    </div>
    <div class="dosage-wrapper">
        @if(isset($product) && $product->dosages)
        @foreach(array_values($product->dosages) as $dosageKey=>$dosageItem)
        @include('pages.products.manager.partials.form-items.dosage')
        @endforeach
        @else
        @include('pages.products.manager.partials.form-items.dosage',['dosageKey'=>0])
        @endif
    </div>
    <div class="text-right">
        <button type="button" class="btn btn-sm btn-light add-dosage-button ajax_without_form"
            data-action="{{route('product.admin.dosage.add')}}"
            data-key="{{(isset($product) && $product->dosages)?sizeof($product->dosages)-1:0}}" data-method="POST"
            data-append="1" data-append-view-wrapper=".dosage-wrapper">Add Dosage
        </button>
    </div>
</div>