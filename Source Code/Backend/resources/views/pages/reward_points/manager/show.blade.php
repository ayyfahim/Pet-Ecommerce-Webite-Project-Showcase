@extends('layouts.admin.dashboard')
@section('title',"Reward Points History")
@section('d-content')
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">Event</th>
                        <th scope="col">Points</th>
                        <th scope="col">Datetime</th>
                        <th scope="col">Added By</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reward_points as $reward_point)
                        @include('pages.reward_points.manager.partials.history_info')
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
