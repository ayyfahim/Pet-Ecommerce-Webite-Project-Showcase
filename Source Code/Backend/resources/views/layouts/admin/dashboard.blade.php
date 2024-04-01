@extends('layouts.admin.app')
@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

    @yield('d-styles')
    <style>
        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            display: none;
            float: left;
            min-width: 10rem;
            padding: .5rem 0;
            margin: .125rem 0 0;
            font-size: 1rem;
            color: #212529;
            text-align: left;
            list-style: none;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: .25rem;
        }
    </style>
@endsection
@section('content')
    @include('layouts.admin.partials.navbar')
    @include('layouts.admin.partials.sidebar')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-8 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">@yield('title')</h2>
                            @if(isset($breadcrumb) && sizeof($breadcrumb))
                                @include('layouts.admin.partials.breadcrumb')
                            @endif
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-right col-md-4 col-12">
                    <div class="form-group breadcrumb-right">
                        <div class="dropdown">
                            @yield('d-buttons')
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body pt-2">
                @hasSection('d-filters')
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <form action="@yield('route')">
                                    <div class="card-body">
                                        @yield('d-filters')
                                    </div>
                                    <div class="card-footer text-right">
                                        @yield('d-filters-btn')
                                        <a href="@yield('filter-route')" class="btn btn-outline-secondary">Reset
                                            Filters</a>
                                        <button type="submit" class="btn btn-primary">Filter Results</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
                @yield('d-content')
            </div>
        </div>
    </div>
    @include('layouts.admin.partials.footer')
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
         aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="ajaxx" id="confirmation" method="POST" data-appointment-destroy="0">
                @csrf
                <div class="modal-content">
                    <div class="modal-header"><h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <p>
                            This action cannot be reversed. Are you sure?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Confirm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @yield('modals')
@endsection
@section('scripts')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready( function () {
            $('.table-datatable').DataTable({
                "searching": false,
                "initComplete": function(settings, json) {
                    $('h5.card-title').html($('#DataTables_Table_0_info'));
                    $('#DataTables_Table_0_length').addClass('mb-2');
                    $('#DataTables_Table_0_length').insertAfter('.card-title');
                }
            });
            $()
        } );
    </script>
    @yield('d-scripts')
@endsection
