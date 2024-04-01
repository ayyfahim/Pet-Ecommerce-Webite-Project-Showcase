<div class="tab-pane fade" id="nutrition" role="tabpanel"
     aria-labelledby="nutrition-tab">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Nutrition Facts Serving Size</label>
                <input class="form-control" value="{{isset($product)?$product->nutrition_facts_serving_label:''}}"
                          name="nutrition_facts_serving_label">
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Nutrition Facts Description</label>
                <textarea class="form-control" style="height: 200px"
                          name="nutrition_facts_description">{{isset($product)?$product->nutrition_facts_description:''}}</textarea>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
    </div>
    <div class="nutrition_fact_serving-wrapper">
        <h6>Servings</h6>
        @if(isset($product) && $product->nutrition_facts_serving)
            @foreach(array_values($product->nutrition_facts_serving) as $nutrition_factServingKey=>$nutrition_factServingItem)
                @include('pages.products.manager.partials.form-items.nutrition_serving')
            @endforeach
        @else
            @include('pages.products.manager.partials.form-items.nutrition_serving',['nutrition_factServingKey'=>0])
        @endif
    </div>
    <div class="text-right">
        <button type="button" class="btn btn-sm btn-light add-nutrition_facts_serving-button ajax_without_form"
                data-action="{{route('product.admin.nutrition.add_serving')}}"
                data-key="{{(isset($product) && $product->nutrition_facts_serving)?sizeof($product->nutrition_facts_serving)-1:0}}"
                data-method="POST"
                data-append="1"
                data-append-view-wrapper=".nutrition_fact_serving-wrapper">Add Serving
        </button>
    </div>
    <hr class="my-2">
    <div class="nutrition_fact_weight-wrapper">
        <h6>Weights</h6>
        @if(isset($product) && $product->nutrition_facts_weight)
            @foreach(array_values($product->nutrition_facts_weight) as $nutrition_factWeightKey=>$nutrition_factWeightItem)
                @include('pages.products.manager.partials.form-items.nutrition_weight')
            @endforeach
        @else
            @include('pages.products.manager.partials.form-items.nutrition_weight',['nutrition_factWeightKey'=>0])
        @endif
    </div>
    <div class="text-right">
        <button type="button" class="btn btn-sm btn-light add-nutrition_facts_serving-button ajax_without_form"
                data-action="{{route('product.admin.nutrition.add_weight')}}"
                data-key="{{(isset($product) && $product->nutrition_facts_serving)?sizeof($product->nutrition_facts_serving)-1:0}}"
                data-method="POST"
                data-append="1"
                data-append-view-wrapper=".nutrition_fact_weight-wrapper">Add Weight
        </button>
    </div>
</div>
