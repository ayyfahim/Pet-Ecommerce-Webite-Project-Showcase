@extends('layouts.admin.dashboard')
@section('title','News Notifications')
@section('d-buttons')
    <a href="{{route('event.admin.create')}}"
       class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light uk-float-right">
        Add News Notification
    </a>
@endsection
@section('d-content')
    @if (!$events->count())
        @include('pages._partials.no-listing-data')
    @else
        <h3 class="uk-text-large ml-20">({{$events->total()}}) News Notification</h3>
        <div class="md-card uk-margin-medium-bottom">
            <div class="md-card-content">
                <div class="uk-overflow-container">
                    <table class="uk-table uk-table-nowrap">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Body</th>
                            <th class="uk-width-3-10 uk-text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($events as $event)
                            @include('pages.events.manager.partials.info')
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        @include('layouts.admin.partials.pagination',['collection'=>$events])
    @endif
@endsection