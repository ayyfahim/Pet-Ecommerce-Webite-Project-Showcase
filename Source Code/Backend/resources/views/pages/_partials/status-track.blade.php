<ul class="status-list">
    @foreach($item->statusTrackingPoints as $status)
        <li class="text-{{$status->status->color}}">{{$status->status->title}}</li>
    @endforeach
</ul>
