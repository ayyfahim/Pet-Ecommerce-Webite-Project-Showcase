@extends('layouts.admin.dashboard')
@section('title',$email_template->title)
@section('d-buttons')
    <a href="{{route('content.admin.email_template.show',$email_template->id)}}" class="btn btn-block btn-warning">
        Preview Email
    </a>
@endsection
@section('d-content')
    <div class="col-12">
        <div class="card">
            <form action="{{route('content.admin.email_template.update',$email_template->id)}}"
                  enctype="multipart/form-data" class="ajax"
                  method="POST" id="BasicInfo">
                <input type="hidden" name="redirect_to" value="{{url()->previous()}}">
                <div class="card-body">
                    @method('PATCH')
                    @include('pages.email_templates.manager.partials.form')
                </div>
            </form>
        </div>
    </div>
@endsection
