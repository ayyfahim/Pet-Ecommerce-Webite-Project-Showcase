<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="{{route('admin.dashboard')}}">
                    <h2 class="brand-text">{{config('app.name')}}</h2>
                </a>
            </li>
            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                    <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i>
                    <i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc"
                       data-ticon="disc"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom">
    </div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            @foreach($helper->get_dashboard_menu_items() as $menu_item)
                @if($menu_item['type'] == 'menu_item')
                    <li class="nav-item @if(isset($menu_item['children']) && sizeof($menu_item['children'])) {{$menu_item['is_active']?'open':''}} @else {{$menu_item['is_active']?'active':''}} @endif">
                        <a class="d-flex align-items-center" href="{{$menu_item['route']}}">
                            <i data-feather="{{$menu_item['icon']}}"></i>
                            <span class="menu-title text-truncate">{{$menu_item['label']}}</span>
                        </a>
                        @if(isset($menu_item['children']) && sizeof($menu_item['children']))
                            <ul class="menu-content">
                                @foreach($menu_item['children'] as $child_menu_item)
                                    <li class="{{$child_menu_item['is_active']?'active':''}}">
                                        <a class="d-flex align-items-center" href="{{$child_menu_item['route']}}">
                                            <i data-feather="circle"></i>
                                            <span class="menu-item text-truncate">{{$child_menu_item['label']}}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @else
                    <li class="navigation-header">
                        <span>{{$menu_item['label']}}</span>
                        <i data-feather="more-horizontal"></i>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
