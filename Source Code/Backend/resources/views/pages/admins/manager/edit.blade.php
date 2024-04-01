@extends('layouts.admin.dashboard')
@section('title',$user->full_name)
@section('d-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{route('management.admin.user.update',$user->id)}}" enctype="multipart/form-data" class="ajax"
                      method="POST" id="BasicInfo">
                    <input type="hidden" name="redirect_to" value="{{url()->previous()}}">
                    <div class="card-body">
                        @method('PATCH')
                        @include('pages.admins.manager.partials.form')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
