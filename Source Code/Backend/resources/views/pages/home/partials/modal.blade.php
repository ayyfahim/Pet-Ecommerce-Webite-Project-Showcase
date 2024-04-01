<div class="modal bd-example-modal-sm" id="{{$id}}"
    role="dialog"
    aria-hidden="true"
    aria-labelledby="{{$id}}title"
    tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{$id}}title">{{$item->name}}
                    <p class="h6 font-weight-normal text-capitalize">please choose activity</p>
                </h5>
                <button class="close m-0" data-dismiss="modal" type="button" aria-label="Close">
                    <i class="material-icons" aria-hidden="true">close</i>
                </button>
            </div>
            <div class="modal-body pt-0">
                <ul class="list-group">
                    @foreach ($activities as $act)
                        <li class="list-group-item"><a href="{{route('service.index', [
                            'sector'=> $item->name,
                            'activity'=> $act->name
                        ])}}">{{$act->name}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
