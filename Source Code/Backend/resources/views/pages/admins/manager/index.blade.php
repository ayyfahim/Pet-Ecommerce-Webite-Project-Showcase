@extends('layouts.admin.dashboard')
@section('title','Users')
@section('d-buttons')
    @permission('add_admins')
    <a href="{{route('management.admin.user.create')}}" class="btn btn-primary btn-block">New User</a>
    @endpermission
@endsection
@section('d-filters')
    <div class="row">
        <div class="col-md-8">
            <input class="form-control" name="q" value="{{request('q')}}" placeholder="Search..">
        </div>
        <div class="col-md-4">
            <select class="form-control select2" name="status_id" data-width="100%">
                <option value="all">Status</option>
                @foreach($status as $item)
                    <option @if(request('status_id') == $item->id) selected
                            @endif value="{{$item->id}}">{{$item->title}}</option>
                @endforeach
            </select>
        </div>
    </div>
@endsection
@section('filter-route',route('management.admin.user.index'))
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
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $key=>$user)
                            @include('pages.admins.manager.partials.info')
                        @endforeach
                        </tbody>
                    </table>
                    @include('layouts.admin.partials.pagination',['collection'=>$users])
                </div>
            </div>
        </div>
    </div>
@endsection
