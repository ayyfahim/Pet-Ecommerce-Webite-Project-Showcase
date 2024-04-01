<!DOCTYPE html>
<html lang="{{LaravelLocalization::getCurrentLocale()}}" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
@include('layouts.partials.head')
<body class="disable_transitions sidebar_main_open sidebar_main_swipe">
{{--@include('layouts.partials.confirmation')--}}
{{--@include('layouts.partials.alerts-wrapper')--}}
{{--@include('layouts.partials.front.menu')--}}
@yield('content')

@yield('modals')
@yield('scripts')
</body>
</html>
