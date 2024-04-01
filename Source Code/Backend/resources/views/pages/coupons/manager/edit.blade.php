@extends('layouts.admin.dashboard')
@section('title',$coupon->title)
@include('pages.coupons.manager.partials.styles')
@section('d-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
            <form action="{{route('coupon.admin.update',$coupon->id)}}" enctype="multipart/form-data" class="ajax"
                      method="POST" id="BasicInfo">
                    <input type="hidden" name="redirect_to" value="{{url()->previous()}}">
                    <div class="card-body">
                        @method('PATCH')
                    @include('pages.coupons.manager.partials.form')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@include('pages.coupons.manager.partials.scripts')
