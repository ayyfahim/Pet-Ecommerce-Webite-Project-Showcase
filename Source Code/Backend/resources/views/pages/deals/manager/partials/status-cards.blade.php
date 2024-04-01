<div class="col-12 col-md-12 col-xl-3 col-right">
    @permission('delete_products')
    @isset($deal)
        <div class="card mb-2">
            <div class="card-body">
                <button class="btn btn-danger btn-block confirm-action-button"
                        data-action="{{route('deal.admin.destroy',$deal->id)}}"
                        data-custom_method='@method('DELETE')'
                        data-append-input="1"
                        data-field_name="redirect_to"
                        data-field_value="{{ url()->previous() }}"
                        data-toggle="modal"
                        data-target="#confirmationModal">
                    Delete Deal
                </button>
            </div>
        </div>
    @endisset
    @endpermission
</div>
