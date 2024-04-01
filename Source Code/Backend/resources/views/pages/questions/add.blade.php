@extends('layouts.admin.dashboard')
@section('title',"Add New Question")
@section('d-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{route('question.admin.store')}}" enctype="multipart/form-data" class="ajax"
                      method="POST" id="BasicInfo">
                    <div class="card-body">
                        @include('pages.questions.partials.form')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
