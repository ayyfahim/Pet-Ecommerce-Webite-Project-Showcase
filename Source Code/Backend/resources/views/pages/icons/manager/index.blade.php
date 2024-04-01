@extends('layouts.admin.dashboard')
@section('title','Icons')
@section('d-buttons')
    @permission('add_icons')
    <a href="{{route('icon.admin.create')}}" class="btn btn-primary btn-block">New Icon</a>
    @endpermission
@endsection
@section('d-filters')
    <div class="row">
        <div class="col-md-12">
            <input class="form-control" name="q" value="{{request('q')}}" placeholder="Search..">
        </div>
    </div>
@endsection
@section('filter-route',route('icon.admin.index'))
@section('d-content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <h5 class="card-title">{{$helper->pagination_label($icons)}}</h5>
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Icon</th>
                            <th scope="col">Title</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($icons as $key=>$icon)
                            @include('pages.icons.manager.partials.info')
                        @endforeach
                        </tbody>
                    </table>
                    @include('layouts.admin.partials.pagination',['collection'=>$icons])
                </div>
            </div>
        </div>
    </div>
@endsection
