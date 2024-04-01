@extends('layouts.admin.dashboard')
@section('title',"Add New Feed")
@section('d-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{route('feed.admin.store')}}" enctype="multipart/form-data" class="ajax"
                      method="POST" id="BasicInfo">
                    <div class="card-body">
                        @include('pages.feeds.partials.form')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@include('pages.feeds.partials.scripts')
