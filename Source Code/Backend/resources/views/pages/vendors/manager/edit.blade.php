@extends('layouts.admin.dashboard')
@section('title',$vendor->name)
@section('d-content')
    <div class="col-12 col-md-12 col-xl-12 col-left">
        <div class="card">
            <form action="{{route('vendor.admin.update',$vendor->id)}}" enctype="multipart/form-data" class="ajax"
                  method="POST" id="BasicInfo">
                <input type="hidden" name="redirect_to" value="{{url()->previous()}}">
                <div class="card-body">
                    @method('PATCH')
                    @include('pages.vendors.manager.partials.form')
                </div>
            </form>
        </div>
    </div>
@endsection
