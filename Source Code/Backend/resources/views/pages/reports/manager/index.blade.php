@extends('layouts.admin.dashboard')
@section('title','Reports')
@section('d-content')
    <div class="md-card uk-margin-medium-bottom">
        <div class="md-card-content">
            <form action="{{route('report.admin.index')}}">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="uk-input-group">
                            <span class="uk-input-group-addon">
                                <i class="uk-input-group-icon uk-icon-calendar"></i>
                            </span>
                            <label for="uk_dp_start">Date From</label>
                            <input class="md-input" type="text" name="created_at_from" autocomplete="off"
                                   value="{{$date_from}}"
                                   id="uk_dp_start">
                        </div>

                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="uk-input-group">
                            <span class="uk-input-group-addon">
                                <i class="uk-input-group-icon uk-icon-calendar"></i>
                            </span>
                            <label for="uk_dp_end">Date To</label>
                            <input class="md-input" name="created_at_to" autocomplete="off"
                                   value="{{$date_to}}"
                                   type="text" id="uk_dp_end">
                        </div>

                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-2-3">
                        <select id="productId" name="product_id" data-md-selectize data-md-selectize-bottom>
                            <option value="">Product</option>
                            <option @if(request('product_id') == 'all') selected
                                    @endif value="all">All
                            </option>
                            @foreach($products as $product)
                                <option @if(request('product_id') == $product->id) selected
                                        @endif
                                        value="{{$product->id}}">{{$product->info->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <select id="category_id" name="category_id" data-md-selectize data-md-selectize-bottom>
                            <option value="">Category</option>
                            <option @if(request('category_id') == 'all') selected
                                    @endif value="all">All
                            </option>
                            @foreach($categories as $category)
                                <option @if(request('category_id') == $category->id) selected
                                        @endif
                                        value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1 uk-text-right" style="padding-top: 11px;">
                        <a class="md-btn md-btn-flat md-btn-wave waves-effect waves-button"
                           href="{{route('report.admin.index')}}">Reset Filters</a>
                        <button type="submit"
                                class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light">
                            Filter Results
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="uk-grid uk-grid-width-large-1-2 uk-grid-width-medium-1-2 uk-grid-medium hierarchical_show"
         data-uk-grid-margin>
        <div>
            <div class="md-card py-5">
                <div class="md-card-content">
                    <span class="uk-text-muted uk-text-small">Completed Orders</span>
                    <h2 class="uk-margin-remove">{{$orders->total()}}</h2>
                </div>
            </div>
        </div>
        <div>
            <div class="md-card py-5">
                <div class="md-card-content">
                    <span class="uk-text-muted uk-text-small">Sales</span>
                    <h2 class="uk-margin-remove">{{$sales}} EGP</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="md-card uk-margin-medium-bottom">
        <div class="md-card-content">
            <div class="uk-overflow-container">
                <table class="uk-table uk-table-nowrap">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th class="uk-width-2-10">Status</th>
                        <th class="uk-width-2-10 uk-text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        @include('pages.orders.manager.partials.info')
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    @include('layouts.admin.partials.pagination',['collection'=>$orders])
@endsection
@section('d-scripts')
    <script>
        $(function () {
            altair_form_adv.date_range()
        }), altair_form_adv = {
            date_range: function () {
                var t = $("#uk_dp_start"), e = $("#uk_dp_end"), i = UIkit.datepicker(t, {format: "YYYY-MM-DD"}),
                    n = UIkit.datepicker(e, {format: "YYYY-MM-DD"});
                t.on("change", function () {
                    n.options.minDate = t.val(), setTimeout(function () {
                        e.focus()
                    }, 300)
                }), e.on("change", function () {
                    i.options.maxDate = e.val()
                })
            }
        };
    </script>
@endsection