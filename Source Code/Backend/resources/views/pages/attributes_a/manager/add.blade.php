@extends('layouts.admin.dashboard')
@section('title','Add New Attribute')
@section('d-styles')
    <link rel="stylesheet" href="{{asset('assets/admin/css/tree-select.css')}}">
@endsection
@section('d-content')
    <form action="{{route('attribute.admin.store')}}" method="POST" class="ajax" id="attributeStore"
          enctype="multipart/form-data">
        @include('pages.attributes.manager.partials.form',['submit_button'=>'Create'])
    </form>
@endsection
@include('pages.attributes.manager.partials.scripts')