@extends('layouts.admin.dashboard')
@section('title',"About Us")
@section('d-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{route('frontend.admin.page.about_us.store')}}" method="POST" class="ajax" id="articleStore"
                      enctype="multipart/form-data">
                    <div class="card-body">
                        @include('pages.frontend.manager.about_us.partials.form')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
