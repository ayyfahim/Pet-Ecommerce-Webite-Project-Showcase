@extends('layouts.admin.dashboard')
@section('title',"Edit Article")
@section('d-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{route('article.admin.update',$article->id)}}" method="POST" class="ajax" id="articleUpdate"
                      enctype="multipart/form-data">
                    @method('PATCH')
                    <input type="hidden" name="redirect_to" value="{{url()->previous()}}">
                    <div class="card-body">
                        @include('pages.articles.manager.partials.form')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
