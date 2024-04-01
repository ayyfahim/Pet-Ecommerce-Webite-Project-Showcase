<tr>
    <td>{{$role->display_name}}</td>
    <td style="min-width: 150px;">
        @permission('edit_roles')
        <a href="{{route('management.admin.role.edit',$role->id)}}"
           class="btn rounded-circle btn-icon btn-sm btn-info">
            <i data-feather="edit-2"></i>
        </a>
        @endpermission
        @permission('delete_roles')
        <a
            class="btn rounded-circle btn-icon btn-sm btn-danger confirm-action-button"
            data-action="{{route("management.admin.role.destroy",$role->id)}}"
            data-custom_method='@method('DELETE')'
            data-reload="1">
            <i data-feather="trash"></i>
        </a>
        @endpermission
    </td>
</tr>
