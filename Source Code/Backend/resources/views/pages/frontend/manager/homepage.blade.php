@extends('layouts.admin.dashboard')
@section('title',"Homepage")
@section('d-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{route('frontend.admin.page.homepage')}}" method="POST" class="ajax" id="articleStore"
                      enctype="multipart/form-data">
                    <div class="card-body">
                        @include('pages.frontend.manager.homepage.partials.form')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
