@extends('layouts.admin.dashboard')
@section('title',"Add New Author")
@section('d-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{route('author.admin.store')}}" method="POST" class="ajax" id="authorStore"
                      enctype="multipart/form-data">
                    <div class="card-body">
                        @include('pages.authors.manager.partials.form')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
