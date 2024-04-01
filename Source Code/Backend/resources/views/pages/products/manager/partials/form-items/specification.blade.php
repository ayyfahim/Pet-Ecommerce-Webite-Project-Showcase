<div class="specification-item">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Label</label>
                <input class="form-control"
                       value="{{(isset($specificationItem) && isset($specificationItem['label']))?$specificationItem['label']:''}}"
                       name="specifications[{{$specificationKey}}][label]"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Value</label>
                <input class="form-control"
                       value="{{(isset($specificationItem) && isset($specificationItem['value']))?$specificationItem['value']:''}}"
                       name="specifications[{{$specificationKey}}][value]"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger" style="margin-top:23px"
                    onclick="$(this).parent().parent().remove();$('.add-specification-button').data().key--">
                X
            </button>
        </div>
    </div>
</div>
