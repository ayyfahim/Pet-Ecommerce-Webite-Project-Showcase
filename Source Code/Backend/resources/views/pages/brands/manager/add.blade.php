@extends('layouts.admin.dashboard')
@section('title',"Add New Brand")
@section('d-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{route('brand.admin.store')}}" enctype="multipart/form-data" class="ajax"
                      method="POST" id="BasicInfo">
                    <div class="card-body">
                        @include('pages.brands.manager.partials.form')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
