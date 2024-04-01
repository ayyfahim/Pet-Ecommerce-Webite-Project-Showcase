<tr>
    <td>{{$key+1}}</td>
    <td>{{$feed->vendor->company_name}}</td>
    <td>Every {{$feed->frequency}} Hour</td>
    <td>{{$feed->next_run_at}}</td>
    <td>{{$feed->updated_at}}</td>
    <td style="min-width: 150px;">
        <a
           data-action="{{route("feed.admin.sync",$feed->id)}}"
           data-custom_method='@method('GET')'
           data-label="It may take up to 5 minutes, please don't refresh or close the page"
           class="btn rounded-circle confirm-action-button btn-icon btn-sm btn-warning">
            <i data-feather="refresh-ccw"></i>
        </a>
        <a href="{{route('feed.admin.edit',$feed->id)}}"
           class="btn rounded-circle btn-icon btn-sm btn-info">
            <i data-feather="edit-2"></i>
        </a>
        <a
            class="btn rounded-circle btn-icon btn-sm btn-danger confirm-action-button"
            data-action="{{route("feed.admin.destroy",$feed->id)}}"
            data-custom_method='@method('DELETE')'
            data-reload="1">
            <i data-feather="trash"></i>
        </a>
    </td>
</tr>
