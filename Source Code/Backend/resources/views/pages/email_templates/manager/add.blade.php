@extends('layouts.admin.dashboard')
@section('title',"Add New Email Template")
@section('d-content')
    <div class="col-12 col-md-12 col-xl-9 col-left">
        <div class="card">

            <form action="{{route('icon.admin.store')}}" enctype="multipart/form-data" class="ajax"
                  method="POST" id="BasicInfo">
                <div class="card-body">
                    @include('pages.icons.manager.partials.form')
                </div>
                <div class="card-footer text-right">
                    <a href="{{url()->previous()}}" class="btn btn-sm btn-outline-primary">Cancel</a>
                    <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection
