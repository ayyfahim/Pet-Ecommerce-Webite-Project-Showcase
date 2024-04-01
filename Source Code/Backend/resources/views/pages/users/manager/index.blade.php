@extends('layouts.admin.dashboard')
@section('title','Customers')
@section('d-filters')
    <div class="row">
        <div class="col-md-8">
            <input class="form-control" name="q" value="{{request('q')}}" placeholder="Name, Phone, Email">
        </div>
        <div class="col-md-4">
            <select class="form-control select2" name="status_id" data-width="100%">
                <option value="all">Active/InActive</option>
                @foreach($status as $item)
                    <option @if((request('status_id') == $item->id) || (!request('status_id') && $item->order == 1)) selected
                            @endif value="{{$item->id}}">{{$item->title}}</option>
                @endforeach
            </select>
        </div>
    </div>
@endsection
@section('filter-route',route('user.admin.index'))
@section('d-content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <h5 class="card-title">{{$helper->pagination_label($users)}}</h5>
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email Address</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Orders (No.)</th>
                            <th scope="col">Orders ($)</th>
                            <th scope="col">Points</th>
                            <th scope="col">Register Date</th>
                            <th scope="col">Last Login</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $key=>$user)
                            @include('pages.users.manager.partials.info')
                        @endforeach
                        </tbody>
                    </table>
                    @include('layouts.admin.partials.pagination',['collection'=>$users])
                </div>
            </div>
        </div>
    </div>

@endsection
