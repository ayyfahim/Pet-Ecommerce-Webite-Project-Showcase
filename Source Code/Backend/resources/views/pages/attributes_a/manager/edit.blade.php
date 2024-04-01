@extends('layouts.admin.dashboard')
@section('title','Edit Attribute')
@section('d-styles')
    <link rel="stylesheet" href="{{asset('assets/admin/css/tree-select.css')}}">
@endsection
@section('d-content')
    <form action="{{route('attribute.admin.update',$attribute->id)}}" method="POST" class="ajax" id="attributeUpdate"
          enctype="multipart/form-data">
        @method('PATCH')
        <input type="hidden" name="redirect_to" value="{{url()->previous()}}">
        @include('pages.attributes.manager.partials.form',['submit_button'=>'Update'])
    </form>
@endsection

@include('pages.attributes.manager.partials.scripts')