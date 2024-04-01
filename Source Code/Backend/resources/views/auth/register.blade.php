@extends('layouts.front')
@section('title',$page_title)
@section('f-content')
    @php
        $user = session('user') ?? null;
        $firstName = session('firstName') ?? null;
        $lastName = session('lastName') ?? null;
    @endphp
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-md-8 offset-md-2">
                <div class="card" id="registerForm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-8 offset-sm-2 col-lg-6 offset-lg-3">
                                <h1 class="register-title">{{$page_title}}</h1>
                            </div>
                            <div class="col-12">
                                @include('auth._partials.social-login')
                            </div>
                            <div class="col-12">
                                <form class="ajax" id="register" method="POST"
                                      action="{{route('register.store')}}">
                                    @if($user)
                                        <input type="hidden" name="social" value="1">
                                    @endif
                                    @csrf
                                    {{--@if($user && $user->avatar)--}}
                                    {{--<input type="hidden" name="avatar" value="{{$user->avatar}}">--}}
                                    {{--@endif--}}
                                    <input type="hidden" value="{{$type}}" name="register_type">
                                    <div class="form-row">
                                        <div class="col-12 col-md-6 my-3">
                                            <div class="form-float-label-group">
                                                <input class="form-control form-float-control"
                                                       id="formInput_registerFirstName"
                                                       name="first_name"
                                                       tabindex="1"
                                                       value="{{old('first_name', $firstName ? $firstName : '')}}"
                                                       type="text"
                                                       placeholder="first name *">
                                                @include('layouts.partials.form-errors', ['input'=>'first_name'])
                                                <label for="formInput_registerFirstName">@lang("auth.first_name")
                                                    *</label>
                                            </div>
                                            <div class="form-float-label-group form-float-label-phone">
                                                <input class="form-control form-float-control phone"
                                                       id="formInput_registerMobile"
                                                       name="mobile"
                                                       tabindex="3"
                                                       type="tel"
                                                       value="{{old('mobile')}}"
                                                       placeholder="mobile*" required>
                                                <label for="formInput_registerMobile">@lang("auth.mobile")*</label>
                                                <input class="form-control form-float-control d-none" type="hidden"
                                                       name="">
                                                <small class="text-secondary mobile_hint">Ex: 50XXXXXXXX</small>
                                                @include('layouts.partials.form-errors', ['input'=>'mobile'])
                                            </div>
                                            <div class="form-float-label-group">
                                                <input class="form-control form-float-control"
                                                       id="formInput_registerPassword"
                                                       name="password"
                                                       tabindex="5"
                                                       type="password"
                                                       placeholder="password *">
                                                @include('layouts.partials.form-errors', ['input'=>'password'])
                                                <label for="formInput_registerPassword">@lang("auth.password") *</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 my-3">
                                            <div class="form-float-label-group">
                                                <input class="form-control form-float-control"
                                                       id="formInput_registerLastName"
                                                       name="last_name"
                                                       tabindex="2"
                                                       value="{{old('last_name', $lastName ? $lastName : '')}}"
                                                       type="text"
                                                       placeholder="last name *">
                                                @include('layouts.partials.form-errors', ['input'=>'last_name'])
                                                <label for="formInput_registerLastName">@lang("auth.last_name")
                                                    *</label>
                                            </div>
                                            <div class="form-float-label-group">
                                                <input class="form-control form-float-control"
                                                       id="formInput_registerEmail"
                                                       name="email"
                                                       tabindex="4"
                                                       value="{{old('email', $user ? $user->email : '')}}"
                                                       type="text"
                                                       placeholder="email *">
                                                @include('layouts.partials.form-errors', ['input'=>'email'])
                                                <label for="formInput_registerEmail">@lang("auth.email")*</label>
                                            </div>
                                            <div class="form-float-label-group">
                                                <input class="form-control form-float-control"
                                                       id="formInput_registerPasswordConfirm"
                                                       name="password_confirmation"
                                                       tabindex="6"
                                                       type="password"
                                                       placeholder="confirm password *">
                                                @include('layouts.partials.form-errors', ['input'=>'password_confirmation'])
                                                <label for="formInput_registerPasswordConfirm">@lang("auth.confirm_password")
                                                    *</label>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <div class="form-group mb-0 d-flex align-items-center">
                                                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between w-100">
                                                    <label class="" for="formInput_acceptTerms">
                                                        @lang('auth.terms_condition_agree')
{{--                                                        <a class="text-main-color font-weight-bold text-capitalize mx-1"--}}
{{--                                                           href="{{route('page.show',$termsPage->slug)}}">{{$termsPage->title}}</a>--}}
{{--                                                        @lang('common.and')--}}
{{--                                                        <a class="text-main-color font-weight-bold text-capitalize mx-1"--}}
{{--                                                           href="{{route('page.show',$privacyPage->slug)}}">{{$privacyPage->title}}</a>--}}
                                                    </label>
                                                </div>
                                            </div>
                                            @include('layouts.partials.form-errors', ['input'=>'terms_and_conditions'])
                                        </div>

                                        <div class="col-12 col-sm-8 offset-sm-2 col-lg-6 offset-lg-3 my-3">
                                            <button class="btn btn-danger btn-block"
                                                    type="submit">@lang("auth.register")</button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
