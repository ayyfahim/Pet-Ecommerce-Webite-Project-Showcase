<tr>
    <td>
        {{$redirection->from}}
    </td>
    <td>{{$redirection->to}}</td>
    <td><span class="badge badge-pill badge-{{$redirection->status->color}}">{{$redirection->status->title}}</span></td>
    <td style="min-width: 150px;">
        {{--        @permission('edit_redirections')--}}
        <a href="{{route('redirection.admin.edit',$redirection->id)}}"
           class="btn rounded-circle btn-icon btn-sm btn-info">
            <i data-feather="edit-2"></i>
        </a>
        {{--        @endpermission--}}
        {{--        @permission('delete_redirections')--}}
        <a
            class="btn rounded-circle btn-icon btn-sm btn-danger confirm-action-button"
            data-action="{{route("redirection.admin.destroy",$redirection->id)}}"
            data-custom_method='@method('DELETE')'
            data-reload="1">
            <i data-feather="trash"></i>
        </a>
        {{--        @endpermission--}}
    </td>
</tr>
