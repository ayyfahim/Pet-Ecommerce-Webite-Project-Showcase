<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">Products</h5>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->cart->basket as $cartBasket)
                <tr>
                    <td>
                        <a href="{{route('product.admin.edit',$cartBasket->product->id)}}">{{$cartBasket->product_info->title}}</a>
                        @if($cartBasket->options)
                            @foreach ($cartBasket->options()->whereHas('option')->get() as $option)
                                <div>
                                    <b>{{$option->option->attribute_name}}: </b>
                                    {{$option->label}}
                                </div>
                            @endforeach
                        @endif
                    </td>
                    <td>{{$cartBasket->quantity}}</td>
                    <td>{{number_format($cartBasket->product_info->price,2)}}</td>
                    <td>{{number_format($cartBasket->sub_total,2)}}</td>
                </tr>
            @endforeach
{{--            @foreach($order->totals as $item)--}}
{{--                <tr>--}}
{{--                    <td colspan="2" class="text-left"--}}
{{--                        style="background: #fcfcfc;font-weight: bold;padding: 10px 30px;">{{$item['label']}}</td>--}}
{{--                    <td colspan="2" class="text-right"--}}
{{--                        style="background: #fcfcfc;font-weight: bold;padding: 10px 30px;">{{$item['amount']}}</td>--}}
{{--                </tr>--}}
{{--            @endforeach--}}
            </tbody>
        </table>
    </div>
</div>
@if($order->cart->additional)
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Additional Information</h5>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Question</th>
                    <th>Answer</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->cart->additional as $item)
                    @if(isset($item['question']) && isset($item['answer']))
                        <tr>
                            <td>{{$item['question']}}</td>
                            <td>{{$item['answer']}}</td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
