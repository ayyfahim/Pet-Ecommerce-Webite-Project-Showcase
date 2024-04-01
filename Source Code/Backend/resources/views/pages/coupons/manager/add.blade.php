@extends('layouts.admin.dashboard')
@section('title',"Add New Coupon")
@include('pages.coupons.manager.partials.styles')
@section('d-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
            <form action="{{route('coupon.admin.store')}}" enctype="multipart/form-data" class="ajax"
                      method="POST" id="BasicInfo">
                    <div class="card-body">
                    @include('pages.coupons.manager.partials.form')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@include('pages.coupons.manager.partials.scripts')
