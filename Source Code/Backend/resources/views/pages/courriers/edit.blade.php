@extends('layouts.admin.dashboard')
@section('title',$courrier->courrier)
@section('d-content')
    <div class="col-12">
        <div class="card">
            <form action="{{route('courrier.admin.update',$courrier->id)}}" enctype="multipart/form-data" class="ajax"
                  method="POST" id="BasicInfo">
                <input type="hidden" name="redirect_to" value="{{url()->previous()}}">
                <div class="card-body">
                    @method('PATCH')
                    @include('pages.courriers.partials.form')
                </div>
            </form>
        </div>
    </div>
@endsection
