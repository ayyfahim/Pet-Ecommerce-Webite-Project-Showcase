@extends('layouts.admin.dashboard')
@section('title','Edit Reward Point')
@section('d-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{route('reward_point.admin.update',$reward_point->id)}}" enctype="multipart/form-data" class="ajax"
                      method="POST" id="BasicInfo">
                    <input type="hidden" name="redirect_to" value="{{url()->previous()}}">
                    <div class="card-body">
                        @method('PATCH')
                        @include('pages.reward_points.manager.partials.form')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
