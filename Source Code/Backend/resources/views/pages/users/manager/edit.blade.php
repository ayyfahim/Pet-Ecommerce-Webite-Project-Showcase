@extends('layouts.admin.dashboard')
@section('title',$user->full_name)
@section('d-content')
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs " role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="first-tab" data-toggle="tab" href="#main" role="tab"
                               aria-controls="first" aria-selected="true">Main Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="second-tab" data-toggle="tab" href="#address" role="tab"
                               aria-controls="second" aria-selected="false">Addresses({{$user->addresses()->count()}})</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="third-tab" data-toggle="tab" href="#orders" role="tab"
                               aria-controls="third" aria-selected="false">Orders({{$user->orders()->count()}})</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        @include('pages.users.manager.partials.forms.info')
                        @include('pages.users.manager.partials.forms.address')
                        @include('pages.users.manager.partials.forms.orders')
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card mb-2">
                <div class="card-body text-center">
                    <form action="{{route('user.admin.reset_password')}}" class="ajax" id="reset" method="POST">
                        @csrf
                        <input type="hidden" name="email" value="{{$user->email}}">
                        <button type="submit" class="btn btn-secondary">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
