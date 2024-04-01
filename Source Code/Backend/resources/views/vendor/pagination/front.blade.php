@if ($paginator->hasPages())
    <div class="pagination">
        <a href="{{$paginator->onFirstPage()?'#':$paginator->previousPageUrl()}}"
           class="pagination__arrow pagination-left">
            <img src="/assets/front/images/icons/arrows-custom-chevron-left.svg" width="18" height="19" alt=""/>
        </a>
        <div class="pagination__body">
            @php
            $target = '';
                if(request()->route()->getName() == 'child.index'){
                $target = '#children';
                }
            @endphp
            @foreach ($elements as $element)
                @if (is_string($element))
                    <a class="pagination__item pagination__item_active">{{ $element }}</a>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <a class="pagination__item pagination__item_active">{{ $page }}</a>
                        @else
                            <a href="{{ $url.$target }}" class="pagination__item">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>
        <a href="{{$paginator->hasMorePages()?'#':$paginator->nextPageUrl()}}"
           class="pagination__arrow pagination-right">
            <img src="/assets/front/images/icons/arrows-custom-chevron-left.svg" width="18" height="19" alt=""/>
        </a>
    </div>
@endif
