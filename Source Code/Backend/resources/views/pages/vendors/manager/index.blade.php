@extends('layouts.admin.dashboard')
@section('title','Suppliers')
@section('d-buttons')
    @permission('add_vendors')
    <a href="{{route('vendor.admin.create')}}" class="btn btn-primary btn-block">
        New Supplier
    </a>
    @endpermission
@endsection
@section('d-filters')
    <div class="row">
        <div class="col-md-12">
            <input class="form-control" name="q" value="{{request('q')}}" placeholder="Search..">
        </div>
    </div>
@endsection
@section('d-filters-btn')
    <a href="{{route('vendor.admin.export',request()->getQueryString())}}" class="btn btn-warning">
        Export Results
    </a>
@endsection
@section('filter-route',route('vendor.admin.index'))
@section('d-content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <h5 class="card-title"></h5>
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-datatable table-bordered">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Supplier</th>
                            <th scope="col">Contact Name</th>
                            <th scope="col">Contact Phone</th>
                            <th scope="col">Contact Email</th>
                            <th scope="col">Products</th>
                            <th scope="col">Qtty Sold</th>
                            <th scope="col">Total Sales</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($vendors as $key=>$vendor)
                            @include('pages.vendors.manager.partials.info')
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
