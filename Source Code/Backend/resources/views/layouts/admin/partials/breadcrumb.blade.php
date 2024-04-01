<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        @foreach($breadcrumb['pages'] as $page)
            <li class="breadcrumb-item">
                <a href="{{ $page['route'] }}">{{$page['title']}}</a>
            </li>
        @endforeach
        <li class="breadcrumb-item active">
            {{$breadcrumb['current']}}
        </li>
    </ol>
</div>
