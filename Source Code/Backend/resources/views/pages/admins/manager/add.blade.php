@extends('layouts.admin.dashboard')
@section('title',"Add New User")
@section('d-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{route('management.admin.user.store')}}" enctype="multipart/form-data" class="ajax"
                      method="POST" id="BasicInfo">
                    <div class="card-body">
                        @include('pages.admins.manager.partials.form')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
