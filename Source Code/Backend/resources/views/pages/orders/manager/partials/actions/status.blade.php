<div class="card mb-2">
    <div class="card-body">
        <h5 class="card-title">Change Order Status</h5>
        <form action="{{route('order.admin.update',$order->id)}}" method="post" class="ajax"
              id="orderStatus">
            @method('PATCH')
            @csrf
            <div class="form-row">
                <div class="col-12 col-md-12">
                    <label>Email</label>
                    <select class="form-control mb-2 select2" name="status_id"
                            data-width="100%">
                        <option value="">Select Status</option>
                        @foreach($status->whereIn('order',[3,4]) as $item)
                            <option
                                @if($order->status_id == $item->id) selected
                                @endif
                                value="{{$item->id}}">{{$item->title}}</option>
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="mt-2">
                <button type="submit" class="btn btn-block btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
