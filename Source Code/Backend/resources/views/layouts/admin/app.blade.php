<!doctype html>
<html lang="en" data-textdirection="ltr">
<head>
    @include('layouts.admin.partials.head')
</head>
<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static @yield('body_class')" data-open="click"
      data-menu="vertical-menu-modern" data-col="">
{{--<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click"--}}
{{--      data-menu="vertical-menu-modern" data-col="blank-page">--}}

{{--<body>--}}
@if (flash()->message)
    @php
        $str = \Illuminate\Support\Str::after(flash()->class, '-');
        $title = $str != 'danger' ? $str : 'error';
    @endphp
    <div class="alerts-wrapper">
        <div class="alert {{flash()->class}}  show fade">
            <div class="alert-body">
                <button class="close">
                    <span>×</span>
                </button>
                <p>{{flash()->message}}</p>
            </div>
        </div>
    </div>
@else
    <div class="alerts-wrapper">
        <div class="alert d-none alert-success show fade">
            <div class="alert-body">
                <button class="close">
                    <span>×</span>
                </button>
                <p></p>
            </div>
        </div>
        <div class="alert d-none alert-danger show fade">
            <div class="alert-body">
                <button class="close">
                    <span>×</span>
                </button>
                <p></p>
            </div>
        </div>
    </div>
@endif
@yield('content')
@include('layouts.admin.partials.scripts')
</body>
</html>
