@extends('layouts.admin.dashboard')
@section('title','Add Reward Points')
@section('d-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{route('reward_point.admin.store')}}" enctype="multipart/form-data" class="ajax"
                      method="POST" id="BasicInfo">
                    <div class="card-body">
                        @include('pages.reward_points.manager.partials.form')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


