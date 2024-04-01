@extends('layouts.admin.dashboard')
@section('title',"Add New Deal")
@include('pages.deals.manager.partials.styles')
@section('d-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{route('deal.admin.store')}}" enctype="multipart/form-data" class="ajax"
                      method="POST" id="BasicInfo">
                    <div class="card-body">
                        @include('pages.deals.manager.partials.form')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@include('pages.deals.manager.partials.scripts')
