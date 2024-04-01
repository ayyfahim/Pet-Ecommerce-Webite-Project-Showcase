@extends('layouts.admin.dashboard')
@section('title','Supplier Feeds')
@section('d-buttons')
    <a href="{{route('feed.admin.create')}}" class="btn btn-primary btn-block">
        New Feed
    </a>
@endsection
@section('d-filters')
    <div class="row">
        <div class="col-md-8">
            <input class="form-control" name="q" value="{{request('q')}}" placeholder="Search..">
        </div>
        <div class="col-md-4">
            <select class="form-control select2" name="vendor_id" data-width="100%">
                <option value="all">Supplier</option>
                @foreach($vendors as $vendor)
                    <option @if(request('vendor_id') == $vendor->id) selected
                            @endif value="{{$vendor->id}}">{{$vendor->company_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
@endsection
@section('filter-route',route('feed.admin.index'))
@section('d-content')
    <div class="col-md-12 mb-4">
        <h5 class="card-title">{{$helper->pagination_label($feeds)}}</h5>
        <div class="card">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Supplier</th>
                        <th scope="col">Frequency</th>
                        <th scope="col">Next Update</th>
                        <th scope="col">Last Update</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($feeds as $key=>$feed)
                        @include('pages.feeds.partials.info')
                    @endforeach
                    </tbody>
                </table>
            </div>
            @include('layouts.admin.partials.pagination',['collection'=>$feeds])
        </div>
    </div>
@endsection
