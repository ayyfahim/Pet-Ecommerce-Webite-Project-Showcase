<div class="col-12 col-md-12 col-xl-3 col-right">
    <div class="card mb-2">
        <div class="card-body">
            <b class="float-left">Active</b>
            <div class="custom-switch custom-switch-success custom-switch-small float-right">
                <input class="custom-switch-input statusChange" @if(!isset($attribute) || $attribute->is_active) checked
                       @endif id="switch"
                       type="checkbox"
                       data-input_name="status_id"
                       data-value="{{$active_status}}"
                       data-reversed_value="{{$inactive_status}}"
                >
                <label class="custom-switch-btn" for="switch"></label>
            </div>
        </div>
    </div>
    <div class="card mb-2 d-none">
        <div class="card-body">
            <b class="float-left">Assign to Product</b>
            <div class="custom-switch custom-switch-success custom-switch-small float-right">
                <input class="custom-switch-input statusChange" id="switchProduct"
                       {{--                       @if(!isset($attribute) || $attribute->product) checked @endif--}}
                       checked
                       type="checkbox"
                       data-input_name="product"
                       data-value="1"
                       data-reversed_value="0">
                <label class="custom-switch-btn" for="switchProduct"></label>
            </div>
        </div>
    </div>
{{--    <div class="card mb-2">--}}
{{--        <div class="card-body">--}}
{{--            <b class="float-left">Assign to Category</b>--}}
{{--            <div class="custom-switch custom-switch-success custom-switch-small float-right">--}}
{{--                <input class="custom-switch-input statusChange" id="switchCategory"--}}
{{--                       type="checkbox"--}}
{{--                       @if(isset($attribute) && $attribute->category) checked @endif--}}
{{--                       data-input_name="category"--}}
{{--                       data-value="1"--}}
{{--                       data-reversed_value="0">--}}
{{--                <label class="custom-switch-btn" for="switchCategory"></label>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    @permission('delete_attributes')
    @isset($attribute)
        <div class="card mb-2">
            <div class="card-body">
                <button class="btn btn-danger btn-block confirm-action-button"
                        data-action="{{route('attribute.admin.destroy',$attribute->id)}}"
                        data-custom_method='@method('DELETE')'
                        data-append-input="1"
                        data-field_name="redirect_to"
                        data-field_value="{{ url()->previous() }}"
                        data-toggle="modal"
                        data-target="#confirmationModal">
                    Delete Attribute
                </button>
            </div>
        </div>
    @endisset
    @endpermission
</div>
