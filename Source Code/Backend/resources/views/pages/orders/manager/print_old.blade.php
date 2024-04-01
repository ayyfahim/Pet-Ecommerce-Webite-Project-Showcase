@extends('layouts.admin.app')
@section('title','#'.$order->short_id)
@section('styles')
    <link type="text/css" href="{{asset('assets/admin/css/main.css')}}" rel="stylesheet"/>
    <style>
        body {
            background: #fff !important;
            padding: 50px 100px !important;
        }

        td.total {
            background: #f5f5f5 !important;
            font-weight: bold;
            padding: 10px 30px !important;
        }

        td.title-table {
            color: #fff !important;
            background: #666 !important;
            border-color: #666 !important;
        }

        .ship-table,
        .title-table {
            text-align: left !important;
            padding: 10px 20px !important;
            border: 1px solid #bbb !important;;
        }

        th.ship-table {
            background: #f5f5f5 !important;
            font-size: 16px;
        }

        th {
            font-weight: bold !important;
        }

        td.ship-table {
        }

        img {
            margin: 10px 50px 30px;
        }
    </style>
@endsection
@section('content')
    <img src="{{asset('assets/admin/img/logo.png')}}" width="300" alt="">
    <div class="row">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <td class="text-bold title-table">Order #{{$order->short_id}}</td>
            </tr>
            <tr>
                <td class="text-bold title-table">Order Date: {{$order->created_at->format('F j, Y')}}</td>
            </tr>
            <tr>
                <th class="text-bold ship-table">Ship to</th>
            </tr>
            <tr>
                <td class="ship-table">
                    {{$order->address_info->name}}<br>
                    {{$order->address_info->title}}<br>
                    @if($order->address_info->business_name)
                        {{$order->address_info->business_name}}<br>
                    @endif
                    {{$order->address_info->street_address}}<br>
                    {{$order->address_info->area}}, {{$order->address_info->city}}<br>
                    {{$order->address_info->country}},
                    {{$order->address_info->postal_code}}<br>
                    T: {{$order->address_info->phone}}<br>
                </td>
            </tr>
            </tbody>
        </table>
        <table class="table table-bordered">
            <tbody>
            <tr>
                <th class="text-bold ship-table">Payment Method</th>
                <th class="text-bold ship-table">Shipping Method</th>
            </tr>
            <tr>
                <td class="ship-table">
                    {{$order->payment_method->title}}
                </td>
                <td class="ship-table">
                    {{$order->shipping_method?->title}}<br>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="row">
        <table class="table table-bordered" style="margin-top: 60px;">
            <thead>
            <tr>
                <th class="text-bold">Product</th>
                <th class="text-bold">Quantity</th>
                <th class="text-bold">Price</th>
                <th class="text-bold">Subtotal</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->cart->basket as $cartBasket)
                <tr>
                    <td>
                        {{$cartBasket->product_info->title}}
                    </td>
                    <td>{{$cartBasket->quantity}}</td>
                    <td>{{number_format($cartBasket->product_info->price,2)}}</td>
                    <td>{{number_format($cartBasket->sub_total,2)}}</td>
                </tr>
            @endforeach
            @foreach($order->totals as $item)
                @if(isset($item['amount']))
                    <tr>
                        <td colspan="2" class="text-left total">{{$item['label']}}</td>
                        <td colspan="3" class="text-right total">{{$item['amount']}}</td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('assets/admin/js/main.js')}}"></script>
    <script>
        $(document).ready(function () {
            setTimeout(function(){
                window.print();
                window.onafterprint = function (event) {
                    location.href = "{{route('order.admin.index')}}"
                };
            },500);
        });
    </script>
@endsection
