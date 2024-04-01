@extends('layouts.admin.dashboard')
@section('title',"Add New Supplier")
@section('d-content')
    <div class="col-12 col-md-12 col-xl-12 col-left">
        <div class="card">
            <form action="{{route('vendor.admin.store')}}" enctype="multipart/form-data" class="ajax"
                  method="POST" id="BasicInfo">
                <div class="card-body">
                    @include('pages.vendors.manager.partials.form')
                </div>
            </form>
        </div>
    </div>
@endsection
