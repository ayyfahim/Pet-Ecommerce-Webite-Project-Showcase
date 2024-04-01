@extends('layouts.admin.dashboard')
@section('title','Attributes')
@section('d-buttons')
    <a href="{{route('attribute.admin.create')}}"
       class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light uk-float-right">
        Add New Attribute
    </a>
@endsection
@section('d-content')
    <div class="md-card uk-margin-medium-bottom">
        <div class="md-card-content">
            <form action="{{route('attribute.admin.index')}}">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1">
                        <label for="contact_list_search">Search...</label>
                        <input class="md-input" name="q" value="{{request('q')}}" type="text" id="contact_list_search"/>
                    </div>
                </div>
                <div class="uk-text-right mt-20">
                    <a class="md-btn md-btn-flat md-btn-wave waves-effect waves-button"
                       href="{{route('attribute.admin.index')}}">Reset Filters</a>
                    <button type="submit"
                            class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light">
                        Filter Results
                    </button>

                </div>
            </form>
        </div>
    </div>
    @if (!$attributes->count())
        @include('pages._partials.no-listing-data')
    @else
        <h3 class="uk-text-large ml-20">({{$attributes->total()}}) Attributes</h3>
        <div class="md-card uk-margin-medium-bottom">
            <div class="md-card-content">
                <div class="uk-overflow-container">
                    <table class="uk-table uk-table-nowrap">
                        <thead>
                        <tr>
                            <th class="uk-width-7-10">Name</th>
                            {{--<th class="uk-width-2-10">Products</th>--}}
                            <th class="uk-width-3-10 uk-text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($attributes as $attribute)
                            @include('pages.attributes.manager.partials.info')
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        @include('layouts.admin.partials.pagination',['collection'=>$attributes])
    @endif
@endsection