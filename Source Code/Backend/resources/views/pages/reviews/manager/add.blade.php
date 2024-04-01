@extends('layouts.admin.dashboard')
@section('title','Add New Review')
@section('d-content')
    <form action="{{route('review.admin.store')}}" method="POST" class="ajax" id="reviewStore" enctype="multipart/form-data">
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
                            Add New Review
                        </h3>
                    </div>
                    <div class="md-card-content">
                        @include('pages.reviews.manager.partials.form')
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