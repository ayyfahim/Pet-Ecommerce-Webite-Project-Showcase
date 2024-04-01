<div class="nutrition_fact-item">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Label</label>
                <input class="form-control"
                       value="{{(isset($nutrition_factServingItem) && isset($nutrition_factServingItem['label']))?$nutrition_factServingItem['label']:''}}"
                       name="nutrition_facts_serving[{{$nutrition_factServingKey}}][label]"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Value</label>
                <input class="form-control"
                       value="{{(isset($nutrition_factServingItem) && isset($nutrition_factServingItem['value']))?$nutrition_factServingItem['value']:''}}"
                       name="nutrition_facts_serving[{{$nutrition_factServingKey}}][value]"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger" style="margin-top:23px"
                    onclick="$(this).parent().parent().remove();$('.add-nutrition_fact_serving-button').data().key--">
                X
            </button>
        </div>
    </div>
</div>
