@if (count($categories) > 2)
    @foreach ($categories->slice(0,2) as $item)
        <div class="categories-list">
            @if ($item->parent)
                <span data-placement="top" data-toggle="tooltip" title=""
                      data-original-title="{{$item->parent->name}}">{{$item->parent->name}}</span>
            @endif
            <span data-placement="top" data-toggle="tooltip" title=""
                  data-original-title="{{$item->name}}">{{$item->name}}</span>
        </div>
    @endforeach
    <div class="categories-list">
        <span data-placement="top" data-toggle="tooltip" title="sector / activity">
            +{{count($categories) - 2}} sectors
        </span>
    </div>
@else
    @foreach ($categories as $item)
        <div class="categories-list">
            @if ($item->parent)
                <span data-placement="top" data-toggle="tooltip" title=""
                      data-original-title="{{$item->parent->name}}">{{$item->parent->name}}</span>
            @endif
            <span data-placement="top" data-toggle="tooltip" title=""
                  data-original-title="{{$item->name}}">{{$item->name}}</span>
        </div>
    @endforeach
@endif
