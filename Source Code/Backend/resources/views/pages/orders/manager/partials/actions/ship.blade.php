<div class="card mb-2">
    <div class="card-body">
        <h5 class="card-title">Ship Order</h5>
        <form action="{{route('order.admin.update',$order->id)}}" method="post" class="ajax"
              id="shipOrder">
            @method('PATCH')
            @csrf
            <input type="hidden" name="status_id" value="{{$status->firstWhere('order',2)->id}}">
            <div class="form-row">
                <div class="col-md-12 mb-2">
                    <label>Courrier</label>
                    <select class="form-control select2" name="courrier_id" data-width="100%">
                        <option value="">Select Courrier</option>
                        @foreach($courriers as $courrier)
                            <option @if($order->courrier_id == $courrier->id) selected
                                    @endif value="{{$courrier->id}}">{{$courrier->name}}</option>
                        @endforeach
                    </select>
                    @include('layouts.admin.partials.form-errors')
                </div>
                <div class="col-12 col-md-12 mb-2">
                    <label>Shipment Date</label>
                    <input type="text" id="fp-default" class="form-control flatpickr-basic"
                           name="shipped_at"
                           placeholder=""
                           value="{{isset($order)?$order->shipped_at:''}}"/>
                    @include('layouts.admin.partials.form-errors')
                </div>
                <div class="col-12 col-md-12">
                    <div class="form-group">
                        <label>Tracking Code</label>
                        <input class="form-control" value="{{isset($order)?$order->tracking_code:''}}"
                               name="tracking_code"/>
                        @include('layouts.admin.partials.form-errors')
                    </div>
                </div>
            </div>
            <div class="mt-2">
                <button type="submit" class="btn btn-block btn-primary">Ship</button>
            </div>
        </form>
    </div>
</div>
