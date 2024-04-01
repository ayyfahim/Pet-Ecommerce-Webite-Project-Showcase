@extends('layouts.admin.dashboard')
@section('title','Add New Shipping Zone')
@section('d-styles')
    <link rel="stylesheet" href="{{asset('assets/admin/css/tree-select.css')}}">
@endsection
@section('d-content')
    <form action="{{route('shipping_zone.admin.store')}}" method="POST" class="ajax" id="shipping_zoneStore"
          enctype="multipart/form-data">
        @include('pages.shipping_zones.manager.partials.form',['submit_button'=>'Create'])
    </form>
@endsection
@include('pages.shipping_zones.manager.partials.scripts')
