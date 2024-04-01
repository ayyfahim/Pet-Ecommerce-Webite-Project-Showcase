@extends('layouts.admin.dashboard')
@section('title','Add New Product')
@include('pages.products.manager.partials.styles')
@section('d-content')
    <div class="row">

        <form action="{{route('product.admin.store')}}" enctype="multipart/form-data" class="ajax"
              method="POST" id="BasicInfo">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @include('pages.products.manager.partials.form')
                    </div>
                </div>

                <hr>
                <div class="row">
                    <div class="col-12 text-right mt-1">
                        <button type="submit" class="btn btn-primary">Save All</button>
                        <a href="{{url()->previous()}}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@include('pages.products.manager.partials.scripts')
