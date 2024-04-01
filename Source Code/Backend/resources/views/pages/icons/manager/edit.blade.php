@extends('layouts.admin.dashboard')
@section('title',$icon->name)
@section('d-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{route('icon.admin.update',$icon->id)}}" enctype="multipart/form-data" class="ajax"
                      method="POST" id="BasicInfo">
                    <input type="hidden" name="redirect_to" value="{{url()->previous()}}">
                    <div class="card-body">
                        @method('PATCH')
                        @include('pages.icons.manager.partials.form')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
