@extends('layouts.admin.dashboard')
@section('title',$redirection->name)
@section('d-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{route('redirection.admin.update',$redirection->id)}}" enctype="multipart/form-data"
                      class="ajax"
                      method="POST" id="BasicInfo">
                    <input type="hidden" name="redirect_to" value="{{url()->previous()}}">
                    <div class="card-body">
                        @method('PATCH')
                        @include('pages.redirections.manager.partials.form')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
