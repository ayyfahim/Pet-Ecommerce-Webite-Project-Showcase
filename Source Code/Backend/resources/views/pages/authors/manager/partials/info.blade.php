<tr>
    <td>
        <a href="{{route('author.admin.edit',$author->id)}}"><span class="font-weight-bold">{{$author->name}}</span></a>
    </td>
    <td>
        {{$author->title}}
    </td>
    <td style="min-width: 150px;">
        <a href="{{route('author.admin.edit',$author->id)}}"
           class="btn rounded-circle btn-icon btn-sm btn-info">
            <i data-feather="edit-2"></i>
        </a>
        <a
            class="btn rounded-circle btn-icon btn-sm btn-danger confirm-action-button"
            data-action="{{route("author.admin.destroy",$author->id)}}"
            data-custom_method='@method('DELETE')'
            data-reload="1">
            <i data-feather="trash"></i>
        </a>
    </td>
</tr>
