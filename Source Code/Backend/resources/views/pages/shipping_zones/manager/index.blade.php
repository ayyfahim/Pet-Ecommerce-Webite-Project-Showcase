@extends('layouts.admin.dashboard')
@section('title','Shipping Zones')
@section('d-buttons')
    <a href="{{route('shipping_zone.admin.create')}}"
       class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light uk-float-right">
        Add New Shipping Zone
    </a>
@endsection
@section('d-content')
    @if (!$shipping_zones->count())
        @include('pages._partials.no-listing-data')
    @else
        <h3 class="uk-text-large ml-20">({{$shipping_zones->total()}}) Shipping Zones</h3>
        <div class="md-card uk-margin-medium-bottom">
            <div class="md-card-content">
                <div class="uk-overflow-container">
                    <table class="uk-table uk-table-nowrap">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Cities</th>
                            <th>Regular Price</th>
                            <th>Express Price</th>
                            <th class="uk-width-3-10 uk-text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($shipping_zones as $shipping_zone)
                            @include('pages.shipping_zones.manager.partials.info')
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        @include('layouts.admin.partials.pagination',['collection'=>$shipping_zones])
    @endif
@endsection
