@if(request()->route()->getName() == "login")
    <div class="other-login-wrap">
        <a class="btn btn-outline-facebook btn-block mt-4"
           href="{{route('login_by_social', 'facebook')}}">
            <img src="{{asset('images/icons/facebook-icon.png')}}" alt="facebook icon">
            @lang('auth.login_with_facebook')
        </a>
        <a class="btn btn-outline-google btn-block mt-4"
           href="{{route('login_by_social', 'google')}}">
            <img src="{{asset('images/icons/google-icon.png')}}" alt="google icon">
            @lang('auth.login_with_google')
        </a>
    </div>
@else
    <div class="other-signup-wrap">
        <div class="col-md-6">
            <a class="btn btn-outline-facebook btn-block mt-4"
               href="{{route('login_by_social', 'facebook')}}">
                <img src="{{asset('images/icons/facebook-icon.png')}}" alt="facebook icon">
                @lang('auth.join_with_facebook')
            </a>
        </div>
        <div class="col-md-6">
            <a class="btn btn-outline-google btn-block mt-4"
               href="{{route('login_by_social', 'google')}}">
                <img src="{{asset('images/icons/google-icon.png')}}" alt="google icon">
                @lang('auth.join_with_google')
            </a>
        </div>
    </div>
@endif
