<tr>
    <td><a href="{{route('order.admin.show',$order->id)}}">{{$order->short_id}}</a></td>
    <td>{{$order->created_at}}</td>
    <td>
        {{$order->user?->full_name ?: ''}}<br>
        {{$order->user?->phone ?: $order->address_info?->phone ?: ''}}<br>
        {{$order->user?->email ?: $order->address_info?->email ?: ''}}
    </td>
    <td>
        @foreach($order->cart->basket as $cartBasket)
            <div>{{$cartBasket->product_info->title}}</div>
            @if($cartBasket->options)
                @foreach ($cartBasket->options()->whereHas('option')->get() as $option)
                    <div>
                        <b>{{$option->option->attribute_name}}: </b>
                        {{$option->label}}
                    </div>
    @endforeach
    @endif
    @endforeach
    <td>
        @foreach($order->cart->basket as $cartBasket)
            <div>{{$cartBasket->quantity}}</div>
        @endforeach
    </td>
    <td>
        @foreach($order->cart->basket as $cartBasket)
            <div>{{$cartBasket->price}}</div>
        @endforeach
    </td>
    <td>{{number_format($order->amount,2)}}</td>
    <td>
        @if($order->cart->coupon_info && isset($order->cart->coupon_info['label']) && isset($order->cart->coupon_info['amount']))
            {{$order->cart->coupon_info['amount']}}$
        @else
            0
        @endif
    </td>
    <td>

        @if($order->cart->coupon_info && isset($order->cart->coupon_info['label']) && isset($order->cart->coupon_info['amount']))
            {{$order->cart->coupon_info['label']}}
        @else
            -
        @endif
    </td>
    <td>{{$order->payment_method?->title}}</td>
    <td>{{$order->tracking_code?:'-'}}</td>
    <td><span class="badge badge-pill badge-{{$order->payment_status == 'Paid' ? 'success' : 'danger'}}">{{$order->payment_status}}</span></td>
    <td><span class="badge badge-pill badge-{{$order->status->color}}">{{$order->status->title}}</span></td>
    <td style="min-width: 150px;">
        <a href="{{route('order.admin.show',$order->id)}}"
           class="btn rounded-circle btn-icon btn-sm btn-info">
            <i data-feather="eye"></i>
        </a>
        <a href="{{route('order.admin.print',$order->id)}}"
           class="btn rounded-circle btn-icon btn-sm btn-warning">
            <i data-feather="printer"></i>
        </a>
    </td>
</tr>
