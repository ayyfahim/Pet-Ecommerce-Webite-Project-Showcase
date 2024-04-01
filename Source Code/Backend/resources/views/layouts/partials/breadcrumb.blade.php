@isset($breadcrumb)
    <nav class="" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('menu.home')</a></li>
            @foreach($breadcrumb['pages'] as $page)
                <li class="breadcrumb-item"><a href="{{ $page['route'] }}">{{$page['title']}}</a></li>
            @endforeach
            <li class="breadcrumb-item active" aria-current="page">{{$breadcrumb['current']}}</li>
        </ol>
    </nav>
@endisset
