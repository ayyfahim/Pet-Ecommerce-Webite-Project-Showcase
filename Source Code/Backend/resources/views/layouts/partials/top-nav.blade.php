<div class="header-contain">
    <div class="header-wrap container">
        <div class="logo-wrap">
            <a href="/">
                <img class="logo-img"
                     src="{{asset('images/icons/G_logo.png')}}"
                     alt="logo">
            </a>
        </div>
        <div class="all-items-wrap">
            <div class="user-item-wrap">
                @auth
                    <div class="dropdown navbar-dropdown">
                        <button class="dropdown-toggle" id="headerDropdown" data-toggle="dropdown" type="button"
                                aria-expanded="false" aria-haspopup="true">
                            <div class="user-img-sm">
                                <img src="{{$authUser->getUrlFor('avatar')?:$avatarDef}}" alt="image">
                            </div>
                            <span class="nav-user-name">{{$authUser->full_name}}</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="headerDropdown">
                            <a class="dropdown-item" href="{{ route('user.dashboard') }}">@lang('user.dashboard')</a>
                            <a class="dropdown-item" href="{{route('conversation.index')}}">@lang('message.messages')
                                @if($authUser->messages_count['new'])
                                    <span class="badge badge-danger">{{$authUser->messages_count['new']}}</span>
                                @endif
                            </a>
                            <a href="" class="dropdown-item" style="padding:0 !important; margin: 0 !important;">
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                {{ csrf_field() }}
                                <button class="dropdown-item" href="{{ route('logout') }}" style="cursor: pointer">
                                    @lang('auth.logout')
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="login-data-wrap">
                        <a href="{{route('login')}}">@lang('auth.login')</a>
                        <a class="open-popup login-btn"
                           related-popup="register-popup">@lang('auth.join')</a>
                    </div>
                @endauth
            </div>
            <div class="menu-icon-wrap">
                <i class="menu-open material-icons">menu</i>
            </div>
        </div>
    </div>
</div>
