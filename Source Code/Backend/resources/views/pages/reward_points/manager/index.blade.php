@extends('layouts.admin.dashboard')
@section('title','Reward Points')
@section('d-buttons')
    @permission('add_reward_points')
    <a href="{{route('reward_point.admin.create')}}" class="btn btn-primary btn-block">New Reward Point</a>
    @endpermission
@endsection
@section('d-filters')
    <div class="row">
        <div class="col-md-12">
            <input class="form-control" name="q" value="{{request('q')}}" placeholder="Search..">
        </div>
    </div>
@endsection
@section('filter-route',route('reward_point.admin.index'))
@section('d-content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <h5 class="card-title">{{$helper->pagination_label($reward_points_users)}}</h5>
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">User</th>
                            <th scope="col">Points</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reward_points_users as $key=>$reward_point_user)
                            @include('pages.reward_points.manager.partials.info')
                        @endforeach
                        </tbody>
                    </table>
                    @include('layouts.admin.partials.pagination',['collection'=>$reward_points_users])
                </div>
            </div>
        </div>
    </div>
@endsection
