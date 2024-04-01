@extends('layouts.admin.dashboard')
@section('title','Attributes')
@section('d-buttons')
    @permission('add_attributes')
    <a href="{{route('attribute.admin.create')}}" class="btn btn-primary btn-block">New Attribute</a>
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
@section('filter-route',route('attribute.admin.index'))
@section('d-content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <h5 class="card-title">{{$helper->pagination_label($attributes)}}</h5>
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Attribute</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($attributes as $key=>$attribute)
                            @include('pages.attributes.manager.partials.info')
                        @endforeach
                        </tbody>
                    </table>
                    @include('layouts.admin.partials.pagination',['collection'=>$attributes])
                </div>
            </div>
        </div>
    </div>
@endsection
