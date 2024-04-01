<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">Order Summary</h5>
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <td>
                   {{$order->short_id}}
                </td>
            </tr>
            <tr>
                <th>Customer</th>
                <td>
                    <a target="_blank"
                       href="{{route('user.admin.edit',$order->user->id)}}">{{$order->user->full_name}}</a>
                </td>
            </tr>
            <tr>
                <th>Date</th>
                <td>{{$order->created_at->format('d/m/Y')}}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td><span class="badge badge-pill badge-{{$order->status->color}}">{{$order->status->title}}</span></td>
            </tr>
            <tr>
                <th>Payment Method</th>
                <td>{{$order->payment_method?->title}}</td>
            </tr>
            <tr>
                <th>Shipping Method</th>
                <td>{{$order->shipping_method?->title ?? ''}}</td>
            </tr>
            <tr>
                <th>Total</th>
                <td>{{number_format($order->amount,2)}}</td>
            </tr>
        </table>
    </div>
</div>
