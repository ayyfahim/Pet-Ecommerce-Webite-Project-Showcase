<div class="dropdown">
    <a class="btn btn-secondary dropdown-toggle mb-1" href="#" role="button"
       id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
       aria-expanded="false">Sort By:
        @if (request('sort_by'))
            @if (request('sort_dir'))
                @foreach ($sorting as $item)
                    @if(request('sort_by') == $item['sort_by'] && request('sort_dir') == $item['sort_dir'])
                        {{ $item['title'] }}
                        @break
                    @endif
                @endforeach
            @else
                @foreach ($sorting as $item)
                    @if(request('sort_by') == $item['sort_by'])
                        {{ $item['title'] }}
                        @break
                    @endif
                @endforeach
            @endif
        @else
            {{$sorting[0]['title']}}
        @endif
    </a>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" x-placement="bottom-start">
        @foreach ($sorting as $item)
            <a class="dropdown-item" href="{{$item['url']}}">{{$item['title']}}</a>
        @endforeach
    </div>
</div>
