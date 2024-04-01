@extends('layouts.admin.dashboard')
@section('title','Add News Notification')
@section('d-content')
    <form action="{{route('event.admin.store')}}" method="POST" class="ajax" id="eventStore" enctype="multipart/form-data">
        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-large-7-10">
                <div class="md-card">
                    <div class="md-card-toolbar">
                        <div class="md-card-toolbar-actions">
                            <div class="uk-float-right">
                            @include('pages._partials.language-selector')
                            </div>
                        </div>
                        <h3 class="md-card-toolbar-heading-text">
                            Add News Notification
                        </h3>
                    </div>
                    <div class="md-card-content">
                        @include('pages.events.manager.partials.form')
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-2-3">
                        <button class="md-btn md-btn-primary md-btn-block md-btn-large md-btn-wave-light waves-effect waves-button waves-light"
                                type="submit">
                            Submit
                        </button>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <a href="{{url()->previous()}}" class="md-btn md-btn-block md-btn-large md-btn-wave-light waves-effect waves-button waves-light">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('d-scripts')
    <script src="{{asset('assets/admin/js/uikit_fileinput.js')}}"></script>
    <script>
        $("input#status").on('change', function () {
            if ($(this).prop("checked") === true) {
                $("input[type='hidden'][name='status_id']").val(1);
            } else {
                $("input[type='hidden'][name='status_id']").val(2);
            }
        })
    </script>
@endsection