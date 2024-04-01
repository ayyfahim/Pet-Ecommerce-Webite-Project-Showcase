<div class="col-12 col-md-12 col-xl-3 col-right">
    <div class="card mb-2">
        <div class="card-body">
            <b class="float-left">Active</b>
            <div class="custom-switch custom-switch-success custom-switch-small float-right">
                <input class="custom-switch-input statusChange" @if(!isset($coupon) || $coupon->is_active) checked
                       @endif id="switch"
                       type="checkbox"
                       data-input_name="status_id"
                       data-value="{{$status_id}}"
                       data-reversed_value="{{$reversed_status_id}}"
                >
                <label class="custom-switch-btn" for="switch"></label>
            </div>
        </div>
    </div>
    @permission('delete_coupons')
    @isset($coupon)
        <div class="card mb-2">
            <div class="card-body">
                <button class="btn btn-danger btn-block confirm-action-button"
                        data-action="{{route('coupon.admin.destroy',$coupon->id)}}"
                        data-custom_method='@method('DELETE')'
                        data-append-input="1"
                        data-field_name="redirect_to"
                        data-field_value="{{ url()->previous() }}"
                        data-toggle="modal"
                        data-target="#confirmationModal">
                    Delete Coupon
                </button>
            </div>
        </div>
    @endisset
    @endpermission
</div>
