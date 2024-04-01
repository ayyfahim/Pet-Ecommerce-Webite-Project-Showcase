@extends('layouts.dashboard')
@section('title',__('auth.account_verification'))
@section('d-title',__('auth.account_verification'))
@section('d-content')
    <div class="row inner-content" id="profile-verification">
        {{-- email --}}
        <div class="col-12 mb-4">
            @if ($user->hasVerifiedEmail())
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">@lang('auth.email_verification')</h6>
                        <div class="d-flex flex-column">
                            <h6 class="card-subtitle">@lang('auth.your_email_address')</h6>
                            <div class="d-flex align-items-center">
                                <p class="mr-3 mb-0">{{$user->email}}</p>
                                <div class="d-flex align-items-center">
                                    <img src="{{asset('images/icons/verified.png')}}">
                                    <p class="text-success text-capitalize ml-2 mb-0">@lang('auth.verified')</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">@lang('auth.email_verification')</h6>
                        <div class="d-flex flex-column">
                            <h6 class="card-subtitle">@lang('auth.your_email_address')</h6>
                            <div class="d-flex flex-column justify-content-center">
                                <p class="mr-3 mb-2">{{$user->email}}</p>
                                <div class="d-flex flex-column justify-content-center">
                                    <small class="mb-0 text-secondary">
                                        @lang('auth.email_verification_description')
                                    </small>
                                    <br>
                                    <a class="text-danger"
                                       href="{{route('verification.resend')}}">@lang('auth.request_another')</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        {{-- mobile --}}
        <div class="col-12 mb-4">
            @if ($user->hasVerifiedMobile())
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">@lang('auth.mobile_verification')</h6>
                        <div class="d-flex flex-column">
                            <h6 class="card-subtitle">@lang('auth.your_mobile_number')</h6>
                            <div class="d-flex align-items-center">
                                <p class="mr-3 mb-0">{{$user->mobile}}</p>
                                <div class="d-flex align-items-center">
                                    <img src="{{asset('images/icons/verified.png')}}">
                                    <p class="text-success text-capitalize ml-2 mb-0">@lang('auth.verified')</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">@lang('auth.mobile_verification_code')</h6>

                        <form class="ajax" id="verificationMobileForm-1" method="POST"
                              action="{{route('verification.resend.mobile', $authUser->id)}}">
                            @method('PATCH')
                            @csrf

                            <div class="form-row">
                                <div class="col-12">
                                    <small class="text-secondary">
                                        @lang('auth.mobile_verification_description')
                                    </small>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-float-label-group form-float-label-phone"><input
                                                class="form-control form-float-control phone"
                                                id="formInput_registerMobile"
                                                name="mobile"
                                                type="tel"
                                                value="{{$user->mobile}}"
                                                placeholder="mobile">
                                        <label for="formInput_registerMobile">@lang("auth.mobile")</label>
                                        <input class="form-control form-float-control d-none" type="hidden"
                                               name="">
                                        @include('layouts.partials.form-errors', ['input'=>'mobile'])
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 d-flex justify-content-start align-items-center">
                                    <button class="btn btn-link text-primary"
                                            type="submit">@lang('auth.resend_code')</button>
                                </div>
                            </div>
                        </form>

                        <form class="ajax" id="verificationMobileForm-2" method="POST"
                              action="{{route('verification.notice.mobile')}}">
                            @csrf
                            <div class="form-row">
                                <div class="col-12">
                                    <small class="text-secondary">@lang('auth.enter_code_description')
                                    </small>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-float-label-group mb-0">
                                        <input class="form-control form-float-control"
                                               id="formInput_profileVerificationCode"
                                               name="mobile_verification_token"
                                               type="text"
                                               placeholder="enter received code">
                                        @include('layouts.partials.form-errors', ['input'=>'mobile_verification_token'])
                                        <label for="formInput_profileVerificationCode">@lang('auth.enter_received_code')</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 d-flex justify-content-start align-items-end">
                                    <button class="btn btn-danger btn-block py-2 my-2"
                                            type="submit">@lang('auth.verify')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
