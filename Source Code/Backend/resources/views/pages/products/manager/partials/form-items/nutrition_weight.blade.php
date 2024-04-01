<div class="nutrition_fact-item">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Label</label>
                <input class="form-control"
                       value="{{(isset($nutrition_factWeightItem) && isset($nutrition_factWeightItem['label']))?$nutrition_factWeightItem['label']:''}}"
                       name="nutrition_facts_weight[{{$nutrition_factWeightKey}}][label]"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Value</label>
                <input class="form-control"
                       value="{{(isset($nutrition_factWeightItem) && isset($nutrition_factWeightItem['value']))?$nutrition_factWeightItem['value']:''}}"
                       name="nutrition_facts_weight[{{$nutrition_factWeightKey}}][value]"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger" style="margin-top:23px"
                    onclick="$(this).parent().parent().remove();$('.add-nutrition_fact_weight-button').data().key--">
                X
            </button>
        </div>
    </div>
</div>
