@extends('layouts.front')
@section('title') Reset Password @endsection
@section('f-content')
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="card-title text-center">@lang('auth.forgot_password')</h3>
                            </div>
                            <div class="col-12 col-sm-8 offset-sm-2 col-lg-6 offset-lg-3">
                                <form class="ajax"
                                      id="forgot"
                                      method="POST"
                                      action="{{route('password.email')}}">
                                    @csrf

                                    <div class="form-row">
                                        <div class="col-12 my-3">
                                            <div class="form-float-label-group">
                                                <input class="form-control form-float-control"
                                                       id="formInput_forgotEmail" name="email" type="email"
                                                       placeholder="@lang('auth.email')">
                                                @include('layouts.partials.form-errors', ['input'=>'email'])
                                                <label for="formInput_forgotEmail">@lang('auth.email')</label>
                                            </div>
                                        </div>
                                        <div class="col-12 my-3">
                                            <button class="btn btn-outline-primary btn-block"
                                                    type="submit">@lang('auth.reset_password')</button>
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
