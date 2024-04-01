<div class="col-12 col-md-12 col-xl-3 col-right">
    <div class="card mb-2">
        <div class="card-body">
            <b class="float-left">Active</b>
            <div class="custom-switch custom-switch-success custom-switch-small float-right">
                <input class="custom-switch-input statusChange" @if(!isset($user) || $user->is_active) checked
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
    @permission('delete_admins')
    @isset($user)
        <div class="card mb-2">
            <div class="card-body">
                <button class="btn btn-danger btn-block confirm-action-button"
                        data-action="{{route('management.admin.user.destroy',$user->id)}}"
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
