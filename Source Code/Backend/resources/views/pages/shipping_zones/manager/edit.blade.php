@extends('layouts.admin.dashboard')
@section('title','Edit Shipping Zone')
@section('d-styles')
    <link rel="stylesheet" href="{{asset('assets/admin/css/tree-select.css')}}">
@endsection
@section('d-content')
    <form action="{{route('shipping_zone.admin.update',$shipping_zone->id)}}" method="POST" class="ajax" id="shipping_zoneUpdate"
          enctype="multipart/form-data">
        @method('PATCH')
        <input type="hidden" name="redirect_to" value="{{url()->previous()}}">
        @include('pages.shipping_zones.manager.partials.form',['submit_button'=>'Update'])
    </form>
@endsection

@include('pages.shipping_zones.manager.partials.scripts')
