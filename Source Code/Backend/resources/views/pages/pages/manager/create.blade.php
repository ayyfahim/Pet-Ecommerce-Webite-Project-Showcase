@extends('layouts.admin.dashboard')
@section('title',"Add New Page")
@section('d-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{route('content.admin.page.store')}}" method="POST" class="ajax" id="pageStore"
                      enctype="multipart/form-data">
                    <div class="card-body">
                        @include('pages.pages.manager.partials.form')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
