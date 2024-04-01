@extends('layouts.admin.app')
@section('title','#'.$order->short_id)
@section('styles')
    <link type="text/css" href="{{asset('assets/admin/css/main.css')}}" rel="stylesheet"/>
    <style>
        body {
            background: rgb(251, 247, 255) !important;
            /* padding: 50px 100px !important; */
            padding: 15px 0;
        }

        .invoice-container {
            padding: 98px 85px 94px 85px;
            border: solid 1px #e7e7e7;
            background-color: rgb(255, 255, 255);
        }

        .info-text {
            font-family: Arial !important;
            font-size: 16px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.25;
            letter-spacing: 0px;
            color: rgb(130, 134, 145);
        }

        .heading-text {
            font-family: Arial !important;
            font-size: 16px;
            font-weight: bold;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.25;
            letter-spacing: normal;
            color: rgb(74, 37, 112);
        }

        table {
            width: 100%;
        }

        table thead th:first-child {
            width: 70%;
        }

        table th {
            font-family: Arial !important;
            font-size: 16px;
            font-weight: bold;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.25;
            letter-spacing: normal;
            color: rgb(74, 37, 112);

            border-top: solid 3px #e8e9ed;
            border-bottom: solid 3px #e8e9ed;
            text-transform: uppercase;
            padding: 14px 0;
        }

        table tbody td {
            font-family: Arial !important;
            font-size: 16px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.25;
            letter-spacing: normal;
            color: rgb(31, 34, 41);
            padding: 14px 0;
            border-bottom: solid 3px #e7e8ec;
        }

        .totals-info .row {
            padding: 20px 0;
            border-bottom: solid 3px #e7e8ec;
        }

        .totals-info .amount {
            font-family: Arial !important;
            font-size: 16px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.25;
            letter-spacing: normal;
            color: rgb(31, 34, 41);
        }

        .totals-info2 .info-text {
            font-family: Arial !important;
            font-size: 16px;
            font-weight: bold;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.25;
            letter-spacing: 0px;
            color: rgb(31, 34, 41);
        }

        .totals-info2 .amount2 {
            font-family: Arial !important;
            font-size: 22.2px;
            font-weight: bold;
            font-stretch: normal;
            font-style: normal;
            line-height: normal;
            letter-spacing: normal;
            text-align: right;
            color: rgb(240, 69, 113);
        }

        .totals-info2 .row {
            padding: 20px 0;
        }

        .header_logo {
            max-width: 302px;
        }

        /* Responsive */

        @media (max-width: 991.98px) { 
            table thead th:first-child {
                width: 50%;
            }

            table tbody td {
                font-size: 13px;
            }

            table th {
                font-size: 13px;
            }

            .info-text {
                font-size: 13px;
            }

            .totals-info .amount {
                font-size: 13px;
            }

            .totals-info2 .info-text {
                font-size: 13px;
            }

            .totals-info2 .amount2 {
                font-size: 19.2px;
            }

            .header_logo {
                max-width: 250px;
            }
        }

        @media (max-width: 767.98px) { 
            table thead th:first-child {
                width: 45%;
            }

            .header_logo {
                max-width: 200px;
            }
        }

        @media (max-width: 576px) { 
            .invoice-container {
                padding: 98px 15px 94px 15px;
            }
        }
    </style>
@endsection
@section('content')
<div class="container invoice-container">
    <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-7 text-md-left text-center">
            <img src="{{$site_logo ? $site_logo : asset('assets/admin/img/logo.png')}}" alt="logo" class="img-fluid header_logo">
        </div>
        <div class="col-xl-8 col-lg-7 col-md-5 text-center text-md-right info-text mt-md-0 mt-3">
            <span>
                {{ $site_title }} <br />
                {{ $site_address }}
            </span>
            <span class="mt-4 d-block">
                {{ $email }} <br />
                {{ $contact_number }}
            </span>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-6 text-md-left text-center">
            <h6 class="heading-text">RECIPIENT</h6>
            <div class="info-text mt-4">
                {{$order->address_info?->name ?: $order->user?->full_name}} <br />
                @php
                    $address = $order->address_info ? $order->address_info->toArray() : [];
                @endphp
                {{ ( array_key_exists('street_address', $address) ? $address['street_address'] : '') . (array_key_exists('city', $address) ? ', ' . $address['city'] : '') . (array_key_exists('country', $address) ? ', ' . $address['country'] : '') . (array_key_exists('postal_code', $address) ? ', ' . $address['postal_code'] : '') }}
            </div>
            <div class="info-text mt-2">
                {{ isset($order->address_info->email) ? "Email : " . $order->address_info->email : (isset($order->user?->email) ? "Email : " . $order->user->email : '')  }} <br />
                {{ isset($order->address_info->phone) ? "Phone : " . $order->address_info->phone : (isset($order->user?->mobile) ? "Phone : " . $order->user?->mobile : '')  }}
            </div>
        </div>
        <div class="col-md-6 text-md-right text-center mt-md-0 mt-5">
            <h6 class="heading-text">INVOICE NO.</h6>
            <div class="info-text">
                {{$order->invoice_number}}
            </div>
            <h6 class="heading-text mt-5">INVOICE DATE</h6>
            <div class="info-text">
                {{$order->created_at->format('F j, Y')}}
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-12">
            <div>
                <table>
                    <thead>
                        <tr>
                            <th class="text-left">Product DESCRIPTION</th>
                            <th>Quantity</th>
                            <th>RATE</th>
                            <th class="text-right">AMOUNT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->cart->basket as $cartBasket)
                             <tr>
                                <td class="text-left">{{$cartBasket->product_info->title}}</td>
                                <td>{{$cartBasket->quantity}}</td>
                                <td>$ {{number_format($cartBasket->product_info->price,2)}}</td>
                                <td class="text-right">$ {{number_format($cartBasket->sub_total,2)}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @foreach($order->totals as $item)
        @if(isset($item['amount']))
            @if ($item['label'] == "Total")
                <div class="row totals-info2">
                    <div class="col-md-6 col-xs-4"></div>
                    <div class="col-md-6 col-xs-8">
                        <div class="row no-gutters">
                            <div class="col-md-6 col-8 info-text font-weight-bold">{{$item['label']}}</div>
                            <div class="col-md-6 col-4 text-right amount2">$ {{$item['amount']}}</div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row totals-info">
                    <div class="col-md-6 col-xs-4"></div>
                    <div class="col-md-6 col-xs-8">
                        <div class="row no-gutters">
                            <div class="col-md-6 col-8 info-text font-weight-bold">{{$item['label']}}</div>
                            <div class="col-md-6 col-4 text-right amount">{{ $item['amount'] < 0 ? "- $ " . str_replace("-","", number_format($item['amount'], 2)) : '$ ' . $item['amount'] }}</div>
                        </div>
                    </div>
                </div>  
            @endif
        @endif
        
    @endforeach
    {{-- <div class="row totals-info">
        <div class="col-md-6 col-xs-4"></div>
        <div class="col-md-6 col-xs-8">
            <div class="row no-gutters">
                <div class="col-md-6 col-8 info-text font-weight-bold">SUBTOTAL</div>
                <div class="col-md-6 col-4 text-right amount">$ 164.24</div>
            </div>
        </div>
    </div>
    <div class="row totals-info">
        <div class="col-md-6 col-xs-4"></div>
        <div class="col-md-6 col-xs-8">
            <div class="row no-gutters">
                <div class="col-md-6 col-8 info-text font-weight-bold">DISCOUNT 5%</div>
                <div class="col-md-6 col-4 text-right amount">$ 19.99</div>
            </div>
        </div>
    </div>
    <div class="row totals-info">
        <div class="col-md-6 col-xs-4"></div>
        <div class="col-md-6 col-xs-8">
            <div class="row no-gutters">
                <div class="col-md-6 col-8 info-text font-weight-bold">Delivery</div>
                <div class="col-md-6 col-4 text-right amount">$ 0.00</div>
            </div>
        </div>
    </div>
    <div class="row totals-info2">
        <div class="col-md-6 col-xs-4"></div>
        <div class="col-md-6 col-xs-8">
            <div class="row no-gutters">
                <div class="col-md-6 col-8 info-text font-weight-bold">TOTAL</div>
                <div class="col-md-6 col-4 text-right amount2">$ 245.48</div>
            </div>
        </div>
    </div> --}}

    <div class="row" style="margin-top: 50%">
        @if ($order->order_notes->count() > 0)
            <div class="col-12">
                <h6 class="heading-text">NOTES</h6>
                @foreach ($order->order_notes as $item)
                    <p class="info-text my-5">{{ $item->notes }}</p>
                @endforeach
                <div class="mb-5" style="border-bottom: solid 3px #e7e8ec; width: 100%;"></div>
            </div>
        @endif
        <div class="col-6 info-text">
            {{ $site_title }} <br />
            {{ $site_address }}
        </div>
        <div class="col-6 info-text text-right">
            The company is registered in the </br>
            business register under no. 87650000
        </div>
    </div>
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
            },1000);
        });
    </script>
@endsection
