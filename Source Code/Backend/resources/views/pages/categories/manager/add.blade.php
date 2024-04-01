@extends('layouts.admin.dashboard')
@section('title','Add New Category')
@section('d-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{route('category.admin.store')}}" enctype="multipart/form-data" class="ajax"
                      method="POST" id="BasicInfo">
                    <div class="card-body">
                        @include('pages.categories.manager.partials.form')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@include('pages.products.manager.partials.scripts')
