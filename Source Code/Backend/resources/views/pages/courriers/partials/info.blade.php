<tr>
    <td>{{$key+1}}</td>
    <td>{{$courrier->name}}</td>
    <td>{{$courrier->url}}</td>
    <td style="min-width: 150px;">
        <a href="{{route('courrier.admin.edit',$courrier->id)}}"
           class="btn rounded-circle btn-icon btn-sm btn-info">
            <i data-feather="edit-2"></i>
        </a>
        <a
            class="btn rounded-circle btn-icon btn-sm btn-danger confirm-action-button"
            data-action="{{route("courrier.admin.destroy",$courrier->id)}}"
            data-custom_method='@method('DELETE')'
            data-reload="1">
            <i data-feather="trash"></i>
        </a>
    </td>
</tr>
