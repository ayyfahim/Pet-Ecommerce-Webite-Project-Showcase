<div class="card mb-2">
    <div class="card-body">
        <h5 class="card-title">Cancel Order</h5>
        <form action="{{route('order.admin.update',$order->id)}}" method="post" class="ajax"
              id="shipOrder">
            @method('PATCH')
            @csrf
            <input type="hidden" name="status_id" value="{{$status->firstWhere('order',5)->id}}">
            <div class="row">
                <div class="col-12 col-md-12 mb-2">
                    <label>Cancellation Date</label>
                    <input type="text" id="fp-default" class="form-control flatpickr-basic"
                           name="canceled_at"
                           placeholder="Cancellation Date"
                           value="{{isset($order)?$order->canceled_at:''}}"/>
                    @include('layouts.admin.partials.form-errors')
                </div>
                <div class="col-12 col-md-12">
                    <div class="form-group">
                        <label>Reason</label>
                        <input class="form-control" value="{{isset($order)?$order->cancellation_reason:''}}"
                               name="cancellation_reason"/>
                        @include('layouts.admin.partials.form-errors')
                    </div>
                </div>
                <div class="col-12 col-md-12">
                    <div class="form-group">
                        <label>Notes</label>
                        <input class="form-control" value="{{isset($order)?$order->cancellation_note:''}}"
                               name="cancellation_note"/>
                        @include('layouts.admin.partials.form-errors')
                    </div>
                </div>
            </div>
            <div class="mt-2">
                <button type="submit" class="btn btn-block btn-primary">Cancel</button>
            </div>
        </form>
    </div>
</div>
