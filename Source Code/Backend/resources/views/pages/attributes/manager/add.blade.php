@extends('layouts.admin.dashboard')
@section('title',"Add New Attribute")
@section('d-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{route('attribute.admin.store')}}" enctype="multipart/form-data" class="ajax"
                      method="POST" id="BasicInfo">
                    <div class="card-body">
                        @include('pages.attributes.manager.partials.form')
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

