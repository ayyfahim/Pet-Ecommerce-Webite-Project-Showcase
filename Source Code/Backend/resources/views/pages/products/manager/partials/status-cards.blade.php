<div class="card mb-2">
    <div class="card-body">
        <b class="float-left">Active</b>
        <div class="custom-switch custom-switch-success custom-switch-small float-right">
            <input class="custom-switch-input statusChange"
                   @if(!isset($product) || $product->is_active) checked @endif id="switch"
                   type="checkbox"
                   data-input_name="status_id"
                   data-value="{{$status_id}}"
                   data-reversed_value="{{$reversed_status_id}}"
            >
            <label class="custom-switch-btn" for="switch"></label>
        </div>
    </div>
</div>
<div class="card mb-2">
    <div class="card-body">
        <b class="float-left">Featured</b>
        <div class="custom-switch custom-switch-success custom-switch-small float-right">
            <input class="custom-switch-input statusChange" id="switchFeatured"
                   type="checkbox"
                   data-input_name="featured"
                   data-value="1"
                   data-reversed_value="0">
            <label class="custom-switch-btn" for="switchFeatured"></label>
        </div>
    </div>
</div>
