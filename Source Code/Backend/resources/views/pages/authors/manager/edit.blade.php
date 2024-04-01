@extends('layouts.admin.dashboard')
@section('title',"Edit Author")
@section('d-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{route('author.admin.update',$author->id)}}" method="POST" class="ajax" id="authorUpdate"
                      enctype="multipart/form-data">
                    @method('PATCH')
                    <input type="hidden" name="redirect_to" value="{{url()->previous()}}">
                    <div class="card-body">
                        @include('pages.authors.manager.partials.form')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
