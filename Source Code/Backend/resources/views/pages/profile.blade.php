@extends('layouts.admin.dashboard')
@section('title','Profile')
@section('d-content')
    <form action="{{route('user.update')}}" method="POST" class="ajax" id="profile" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-large-10-10">
                <div class="md-card">
                    <div class="md-card-toolbar">
                        <h3 class="md-card-toolbar-heading-text">
                            Edit Profile
                        </h3>
                    </div>
                    <div class="md-card-content">
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-2">
                                <label for="user_first_name">First Name</label>
                                <input class="md-input" value="{{$authUser->first_name}}"
                                       type="text"
                                       id="user_first_name"
                                       name="first_name"/>
                                @include("layouts.partials.form-errors",['field'=>'first_name'])
                            </div>
                            <div class="uk-width-medium-1-2">
                                <label for="user_last_name">Last Name</label>
                                <input class="md-input" value="{{$authUser->last_name}}"
                                       type="text"
                                       id="user_last_name"
                                       name="last_name"/>
                                @include("layouts.partials.form-errors",['field'=>'last_name'])
                            </div>
                        </div>
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-1">
                                <label for="user_last_name">Email Address</label>
                                <input class="md-input" value="{{$authUser->email}}"
                                       type="text"
                                       id="user_email"
                                       name="email"/>
                                @include("layouts.partials.form-errors",['field'=>'email'])
                            </div>
                        </div>
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-2">
                                <label for="user_password">Password</label>
                                <input class="md-input"
                                       type="password"
                                       id="user_password"
                                       name="password"/>
                                @include("layouts.partials.form-errors",['field'=>'password'])
                            </div>
                            <div class="uk-width-medium-1-2">
                                <label for="user_password_confirmation">Password Confirmation</label>
                                <input class="md-input"
                                       type="password"
                                       id="user_password_confirmation"
                                       name="password_confirmation"/>
                                @include("layouts.partials.form-errors",['field'=>'password_confirmation'])
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-2-3">
                        <button class="md-btn md-btn-primary md-btn-block md-btn-large md-btn-wave-light waves-effect waves-button waves-light"
                                type="submit">
                            Submit
                        </button>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <a href="{{url()->previous()}}"
                           class="md-btn md-btn-block md-btn-large md-btn-wave-light waves-effect waves-button waves-light">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection