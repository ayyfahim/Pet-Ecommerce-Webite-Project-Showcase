@extends('layouts.admin.dashboard')
@section('title',"Add New Pet Type")
@section('d-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{route('petType.admin.store')}}" enctype="multipart/form-data" class="ajax"
                      method="POST" id="BasicInfo">
                    <div class="card-body">
                        @include('pages.pet_types.manager.partials.form')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
