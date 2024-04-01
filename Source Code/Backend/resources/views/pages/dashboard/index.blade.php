@extends('layouts.admin.dashboard')
@section('title',"Dashboard")
@section('d-content')
    <h4 class="card-title">Today's Stats</h4>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6>Sales</h6>
                    <h2 class="font-weight-bolder mb-1">
                        $ {{number_format($today_orders->sum('amount'))}}
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <h6>Orders</h6>
                    <h2 class="font-weight-bolder mb-1">
                        {{$today_orders->count()}}
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6>Avg Order Value</h6>
                    <h2 class="font-weight-bolder mb-1">
                        $ {{number_format($today_orders->avg('amount'))}}
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <h6>Profit</h6>
                    <h2 class="font-weight-bolder mb-1">
                        $ {{number_format($today_orders->sum('amount'))}}
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <h6>Products</h6>
                    <h2 class="font-weight-bolder mb-1">
                        {{$today_orders->sum('products_quantity')}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <h4 class="card-title">MTD Stats</h4>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6>Sales</h6>
                    <h2 class="font-weight-bolder mb-1">
                        $ {{number_format($month_orders->sum('amount'))}}
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <h6>Orders</h6>
                    <h2 class="font-weight-bolder mb-1">
                        {{$month_orders->count()}}
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6>Avg Order Value</h6>
                    <h2 class="font-weight-bolder mb-1">
                        $ {{number_format($month_orders->avg('amount'))}}
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <h6>Profit</h6>
                    <h2 class="font-weight-bolder mb-1">
                        $ {{number_format($month_orders->sum('amount'))}}
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <h6>Products</h6>
                    <h2 class="font-weight-bolder mb-1">
                        {{$month_orders->sum('products_quantity')}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <h4 class="card-title">YTD Stats</h4>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6>Sales</h6>
                    <h2 class="font-weight-bolder mb-1">
                        $ {{number_format($year_orders->sum('amount'))}}
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <h6>Orders</h6>
                    <h2 class="font-weight-bolder mb-1">
                        {{$year_orders->count()}}
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6>Avg Order Value</h6>
                    <h2 class="font-weight-bolder mb-1">
                        $ {{number_format($year_orders->avg('amount'))}}
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <h6>Profit</h6>
                    <h2 class="font-weight-bolder mb-1">
                        $ {{number_format($year_orders->sum('amount'))}}
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <h6>Products</h6>
                    <h2 class="font-weight-bolder mb-1">
                        {{$year_orders->sum('products_quantity')}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <h4 class="card-title">Lifetime Stats</h4>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6>Sales</h6>
                    <h2 class="font-weight-bolder mb-1">
                        $ {{number_format($all_orders->sum('amount'))}}
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <h6>Orders</h6>
                    <h2 class="font-weight-bolder mb-1">
                        {{$all_orders->count()}}
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6>Avg Order Value</h6>
                    <h2 class="font-weight-bolder mb-1">
                        $ {{number_format($all_orders->avg('amount'))}}
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <h6>Profit</h6>
                    <h2 class="font-weight-bolder mb-1">
                        $ {{number_format($all_orders->sum('amount'))}}
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <h6>Products</h6>
                    <h2 class="font-weight-bolder mb-1">
                        {{$all_orders->sum('products_quantity')}}
                    </h2>
                </div>
            </div>
        </div>
    </div>


    <h4 class="card-title">Received Orders</h4>
    <form class="mb-2" action="{{route('admin.dashboard')}}">
        <div class="row mb-2">
            <div class="col-md-2">
                <input type="text" id="fp-default" class="form-control flatpickr-basic"
                       name="date_created_at_from"
                       placeholder="Date From"
                       value="{{$date_created_at_from}}"/>
            </div>
            <div class="col-md-2">
                <input type="text" id="fp-default" class="form-control flatpickr-basic"
                       name="date_created_at_to"
                       placeholder="Date To"
                       value="{{$date_created_at_to}}"/>
            </div>
            <div class="text-right col-md-8">
                <a class="btn btn-info" href="{{route('export_dashboard',request()->getQueryString().'&type=date')}}">
                    Export to CSV
                </a>
                <button class="btn btn-secondary" type="submit">
                    Filter
                </button>
                <a class="btn btn-outline-secondary" href="{{route('admin.dashboard')}}">
                    Reset Filters
                </a>
            </div>
        </div>

    </form>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-company-table">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Orders</th>
                                <th>Sales</th>
                                <th>Profit</th>
                                <th>Avg Order Value</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $count = 0;
                                $default_count = 0;
                                $sponsorships_count = 0;
                                $total_count = 0;
                            @endphp
                            @foreach($total_orders_date as $key=>$date_orders)
                                @php
                                    $count +=sizeof($date_orders);
                                    $default_count += $date_orders->sum('amount');
                                    $total_count += $date_orders->avg('amount');
                                @endphp
                                <tr>
                                    <td>{{$key}}</td>
                                    <td>{{sizeof($date_orders)}}</td>
                                    <td>
                                        $ {{number_format($date_orders->sum('amount'))}}
                                    </td>
                                    <td>
                                        $ {{number_format($date_orders->sum('amount'))}}
                                    </td>
                                    <td>
                                        $ {{number_format($date_orders->avg('amount'))}}
                                    </td>
                                </tr>
                            @endforeach

                            <tr>
                                <th>Total</th>
                                <th>{{$count}}</th>
                                <th>$ {{number_format($default_count)}}</th>
                                <th>$ {{number_format($default_count)}}</th>
                                <th>$ {{number_format($total_count)}}</th>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <h4 class="card-title">Category Sales</h4>
    <form class="mb-2" action="{{route('admin.dashboard')}}">
        <div class="row mb-2">
            <div class="col-md-2">
                <input type="text" id="fp-default" class="form-control flatpickr-basic"
                       name="category_created_at_from"
                       placeholder="Date From"
                       value="{{$category_created_at_from}}"/>
            </div>
            <div class="col-md-2">
                <input type="text" id="fp-default" class="form-control flatpickr-basic"
                       name="category_created_at_to"
                       placeholder="Date To"
                       value="{{$category_created_at_to}}"/>
            </div>
            <div class="text-right col-md-8">
                <a class="btn btn-info" href="{{route('export_dashboard',request()->getQueryString().'&type=category')}}">
                    Export to CSV
                </a>
                <button class="btn btn-secondary" type="submit">
                    Filter
                </button>
                <a class="btn btn-outline-secondary" href="{{route('admin.dashboard')}}">
                    Reset Filters
                </a>
            </div>
        </div>

    </form>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-company-table">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Category</th>
                                <th>Orders</th>
                                <th>Sales</th>
                                <th>Profit</th>
                                <th>Avg Order Value</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $count = 0;
                                $default_count = 0;
                                $total_count = 0;
                            @endphp
                            @foreach($total_orders_category as $key=>$category_orders)
                                @php
                                    $count +=sizeof($category_orders);
                                    $default_count += $category_orders->sum('amount');
                                    $total_count += $category_orders->avg('amount');
                                @endphp
                                <tr>
                                    <td>{{$key}}</td>
                                    <td>{{sizeof($category_orders)}}</td>
                                    <td>
                                        $ {{number_format($category_orders->sum('amount'))}}
                                    </td>
                                    <td>
                                        $ {{number_format($category_orders->sum('amount'))}}
                                    </td>
                                    <td>
                                        $ {{number_format($category_orders->avg('amount'))}}
                                    </td>
                                </tr>
                            @endforeach

                            <tr>
                                <th>Total</th>
                                <th>{{$count}}</th>
                                <th>$ {{number_format($default_count)}}</th>
                                <th>$ {{number_format($default_count)}}</th>
                                <th>$ {{number_format($total_count)}}</th>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h4 class="card-title">Sub Category Sales</h4>
    <form class="mb-2" action="{{route('admin.dashboard')}}">
        <div class="row mb-2">
            <div class="col-md-2">
                <input type="text" id="fp-default" class="form-control flatpickr-basic"
                       name="category_created_at_from"
                       placeholder="Date From"
                       value="{{$sub_category_created_at_from}}"/>
            </div>
            <div class="col-md-2">
                <input type="text" id="fp-default" class="form-control flatpickr-basic"
                       name="category_created_at_to"
                       placeholder="Date To"
                       value="{{$sub_category_created_at_to}}"/>
            </div>
            <div class="text-right col-md-8">
                <a class="btn btn-info"
                   href="{{route('export_dashboard',request()->getQueryString().'&type=sub_category')}}">
                    Export to CSV
                </a>
                <button class="btn btn-secondary" type="submit">
                    Filter
                </button>
                <a class="btn btn-outline-secondary" href="{{route('admin.dashboard')}}">
                    Reset Filters
                </a>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-company-table">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Category</th>
                                <th>Parent Category</th>
                                <th>Orders</th>
                                <th>Sales</th>
                                <th>Profit</th>
                                <th>Avg Order Value</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $count = 0;
                                $default_count = 0;
                                $total_count = 0;
                            @endphp
                            @foreach($total_orders_sub_category as $key=>$category_orders)
                                @php
                                    $category = \App\Models\Category::find($key);
                                        $count +=sizeof($category_orders);
                                        $default_count += $category_orders->sum('amount');
                                        $total_count += $category_orders->avg('amount');
                                @endphp
                                <tr>
                                    <td>{{$category->name ?? ''}}</td>
                                    <td>{{$category->parent->name ?? ''}}</td>
                                    <td>{{sizeof($category_orders)}}</td>
                                    <td>
                                        $ {{number_format($category_orders->sum('amount'))}}
                                    </td>
                                    <td>
                                        $ {{number_format($category_orders->sum('amount'))}}
                                    </td>
                                    <td>
                                        $ {{number_format($category_orders->avg('amount'))}}
                                    </td>
                                </tr>
                            @endforeach

                            <tr>
                                <th colspan="2">Total</th>
                                <th>{{$count}}</th>
                                <th>$ {{number_format($default_count)}}</th>
                                <th>$ {{number_format($default_count)}}</th>
                                <th>$ {{number_format($total_count)}}</th>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
