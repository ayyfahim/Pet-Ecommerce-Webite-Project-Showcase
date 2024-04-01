@extends('layouts.admin.dashboard')
@section('title',$feed->feed)
@section('d-content')
    <div class="col-12">
        <div class="card">
            <form action="{{route('feed.admin.update',$feed->id)}}" enctype="multipart/form-data" class="ajax"
                  method="POST" id="BasicInfo">
                <input type="hidden" name="redirect_to" value="{{url()->previous()}}">
                <div class="card-body">
                    @method('PATCH')
                    @include('pages.feeds.partials.form')
                </div>
            </form>
        </div>
    </div>
@endsection
@include('pages.feeds.partials.scripts')
