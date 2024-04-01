<tr>
    <td>{{$user->full_name}}</td>
    <td>{{$user->email}}</td>
    <td>{{$user->role?$user->role->display_name:''}}</td>
    <td>
        <span class="badge badge-pill badge-{{$user->status->color}}">{{$user->status->title}}</span>
    </td>
    <td style="min-width: 150px;">
        @permission('edit_admins')
        <a href="{{route('management.admin.user.edit',$user->id)}}"
           class="btn rounded-circle btn-icon btn-sm btn-info">
            <i data-feather="edit-2"></i>
        </a>
        @endpermission
        @permission('delete_admins')
        <a
            class="btn rounded-circle btn-icon btn-sm btn-danger confirm-action-button"
            data-action="{{route('management.admin.user.destroy',$user->id)}}"
            data-custom_method='@method('DELETE')'
            data-reload="1">
            <i data-feather="trash"></i>
        </a>
        @endpermission
    </td>
</tr>
