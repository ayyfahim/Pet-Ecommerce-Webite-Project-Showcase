@extends('layouts.admin.dashboard')
@section('title','FAQ')
@section('d-buttons')
    <a href="{{route('question.admin.create')}}" class="btn btn-primary btn-block">
        New Question
    </a>
@endsection
@section('d-filters')
    <div class="row">
        <div class="col-md-8">
            <input class="form-control" name="q" value="{{request('q')}}" placeholder="Search..">
        </div>
        <div class="col-md-4">
            <select class="form-control select2" name="category" data-width="100%">
                <option value="all">Category</option>
                @foreach($categories as $item)
                    <option @if(request('category') == $item) selected
                            @endif value="{{$item}}">{{$item}}</option>
                @endforeach
            </select>
        </div>
    </div>
@endsection
@section('filter-route',route('question.admin.index'))
@section('d-content')
    <div class="col-md-12 mb-4">
        <h5 class="card-title">{{$helper->pagination_label($questions)}}</h5>
        <div class="card">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Question</th>
                        <th scope="col">Answer</th>
                        <th scope="col">Category</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($questions as $key=>$question)
                        @include('pages.questions.partials.info')
                    @endforeach
                    </tbody>
                </table>
            </div>
            @include('layouts.admin.partials.pagination',['collection'=>$questions])
        </div>
    </div>
@endsection
