<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow">
    <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item">
                    <a class="nav-link menu-toggle" href="javascript:void(0);">
                        <i class="ficon" data-feather="menu">
                        </i>
                    </a>
                </li>
            </ul>
        </div>
        <ul class="nav navbar-nav align-items-center ml-auto">
            <li class="nav-item dropdown dropdown-user">
                <a class="nav-link dropdown-toggle dropdown-user-link"
                   id="dropdown-user" href="javascript:void(0);"
                   data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none">
                        <span class="user-name font-weight-bolder">
                            Hi, {{$authUser->first_name}}
                        </span>
                        <span class="user-status">{{$authUser->roles()->first()->display_name}}</span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
                    <a class="dropdown-item"
                       href="{{route('home')}}">
                        <i class="mr-50"
                           data-feather="home">
                        </i>
                        Home Page</a>
{{--                    <a class="dropdown-item" href="{{route('profile')}}">--}}
{{--                        <i class="mr-50" data-feather="user">--}}
{{--                        </i> Profile--}}
{{--                    </a>--}}
                    <div class="dropdown-divider">
                    </div>
                    <a class="dropdown-item" href="#" onclick="$('form#logout-form').submit()">
                        <i class="mr-50" data-feather="power">
                        </i>
                        Logout</a>
                    <form id="logout-form" style="display: none;" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <input type="hidden" name="redirect_to" value="{{route('login')}}">
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>


