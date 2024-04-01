@extends('layouts.admin.dashboard')
@section('title',"Add New Redirection")
@section('d-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{route('redirection.admin.store')}}" enctype="multipart/form-data" class="ajax"
                      method="POST" id="BasicInfo">
                    <div class="card-body">
                        @include('pages.redirections.manager.partials.form')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

