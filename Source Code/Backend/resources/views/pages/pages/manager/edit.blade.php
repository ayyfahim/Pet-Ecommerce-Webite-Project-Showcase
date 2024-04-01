@extends('layouts.admin.dashboard')
@section('title',$page->title)
@section('d-content')
    <div class="col-12">
        <div class="card">
            <form action="{{route('content.admin.page.update',$page->id)}}" method="POST" class="ajax" id="pageUpdate"
                  enctype="multipart/form-data">
                @method('PATCH')
                <input type="hidden" name="redirect_to" value="{{url()->previous()}}">
                <div class="card-body">
                    @include('pages.pages.manager.partials.form')
                </div>
            </form>
        </div>
    </div>
@endsection
