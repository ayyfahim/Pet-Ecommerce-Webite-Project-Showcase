@extends('layouts.admin.dashboard')
@section('title',"Add New Icon")
@section('d-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{route('icon.admin.store')}}" enctype="multipart/form-data" class="ajax"
                      method="POST" id="BasicInfo">
                    <div class="card-body">
                        @include('pages.icons.manager.partials.form')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
