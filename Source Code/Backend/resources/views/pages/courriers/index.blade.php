@extends('layouts.admin.dashboard')
@section('title','Courriers')
@section('d-buttons')
    <a href="{{route('courrier.admin.create')}}" class="btn btn-primary btn-block">
        New Courrier
    </a>
@endsection
@section('d-filters')
    <div class="row">
        <div class="col-md-12">
            <input class="form-control" name="q" value="{{request('q')}}" placeholder="Search..">
        </div>
    </div>
@endsection
@section('filter-route',route('courrier.admin.index'))
@section('d-content')
    <div class="col-md-12 mb-4">
        <h5 class="card-title">{{$helper->pagination_label($courriers)}}</h5>
        <div class="card">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Comapny Name</th>
                        <th scope="col">URL</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($courriers as $key=>$courrier)
                        @include('pages.courriers.partials.info')
                    @endforeach
                    </tbody>
                </table>
            </div>
            @include('layouts.admin.partials.pagination',['collection'=>$courriers])
        </div>
    </div>
@endsection
