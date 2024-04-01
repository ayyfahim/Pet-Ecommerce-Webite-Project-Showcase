@extends('layouts.admin.dashboard')
@section('title','Brands')
@section('d-buttons')
    @permission('add_brands')
    <a href="{{route('brand.admin.create')}}" class="btn btn-primary btn-block">New Brand</a>
    @endpermission
@endsection
@section('d-filters')
    <div class="row">
        <div class="col-md-12">
            <input class="form-control" name="q" value="{{request('q')}}" placeholder="Search..">
        </div>
    </div>
@endsection
@section('filter-route',route('brand.admin.index'))
@section('d-content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <h5 class="card-title"></h5>
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-datatable table-bordered">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Logo</th>
                            <th scope="col">Name</th>
                            <th scope="col">Products</th>
                            <th scope="col">Qtty Sold</th>
                            <th scope="col">Total Sales</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($brands as $key=>$brand)
                            @include('pages.brands.manager.partials.info')
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
