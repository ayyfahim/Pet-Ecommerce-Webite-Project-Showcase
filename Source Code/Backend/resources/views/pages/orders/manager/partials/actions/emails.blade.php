<div class="card mb-2">
    <div class="card-body">
        <h5 class="card-title">Resend Emails</h5>
        <form action="{{route('order.admin.email',$order->id)}}" method="post" class="ajax"
              id="orderStatus">
            @method('PATCH')
            @csrf
            <div class="row">
                <div class="col-12 col-md-12">
                    <label>Email</label>
                    <select class="form-control mb-2 select2" name="notification_id"
                            data-width="100%">
                        <option value="">Select Email</option>
                        @foreach($notifications as $notification)
                            <option
                                value="{{$notification->id}}">{{$notification->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-2">
                <button type="submit" class="btn btn-block btn-primary">Send</button>
            </div>
        </form>
    </div>
</div>
