@extends('layouts.admin.dashboard')
@section('title','Order #'.$order->short_id)
@section('d-buttons')
    <a href="{{route('order.admin.print',$order->id)}}" class="btn btn-primary btn-block">
        Invoice
    </a>
@endsection
@section('d-content')
    <div class="row">
        <div class="col-12 col-md-8">
            @include('pages.orders.manager.partials.order_info')
            @include('pages.orders.manager.partials.customer_info')
            @include('pages.orders.manager.partials.products')
        </div>
        <div class="col-12 col-md-4">
            @include('pages.orders.manager.partials.actions.notes')
            @include('pages.orders.manager.partials.actions.ship')
            @include('pages.orders.manager.partials.actions.cancel')
            @include('pages.orders.manager.partials.actions.status')
            @include('pages.orders.manager.partials.actions.emails')
        </div>
    </div>
@endsection
