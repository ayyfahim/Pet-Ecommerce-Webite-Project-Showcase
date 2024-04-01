@extends('layouts.admin.dashboard')
@section('title',"Add New Article")
@section('d-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{route('article.admin.store')}}" method="POST" class="ajax" id="articleStore"
                      enctype="multipart/form-data">
                    <div class="card-body">
                        @include('pages.articles.manager.partials.form')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
