@extends('layouts.admin.dashboard')
@section('title',$social_feed->title.' Feed')
@section('d-content')
    <div class="col-12">
        <div class="card">
            <form action="{{route('social_feed.admin.update',$social_feed->id)}}" enctype="multipart/form-data" class="ajax"
                  method="POST" id="BasicInfo">
                <input type="hidden" name="redirect_to" value="{{url()->previous()}}">
                <div class="card-body">
                    @method('PATCH')
                    @include('pages.social_feeds.partials.form')
                </div>
            </form>
        </div>
    </div>
@endsection
