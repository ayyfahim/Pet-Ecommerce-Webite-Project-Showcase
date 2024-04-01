@extends('layouts.admin.dashboard')
@section('title',$question->question)
@section('d-content')
    <div class="col-12">
        <div class="card">
            <form action="{{route('question.admin.update',$question->id)}}" enctype="multipart/form-data" class="ajax"
                  method="POST" id="BasicInfo">
                <input type="hidden" name="redirect_to" value="{{url()->previous()}}">
                <div class="card-body">
                    @method('PATCH')
                    @include('pages.questions.partials.form')
                </div>
            </form>
        </div>
    </div>
@endsection
