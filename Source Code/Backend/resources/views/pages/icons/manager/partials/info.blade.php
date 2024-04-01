<tr>
    <td><img width="40" src="{{$icon->getUrlFor('badge')}}" alt=""></td>
    <td>
        <a href="{{route('icon.admin.edit',$icon->id)}}">{{$icon->title}}</a>
    </td>
    <td style="min-width: 150px;">
        @permission('edit_icons')
        <a href="{{route('icon.admin.edit',$icon->id)}}"
           class="btn rounded-circle btn-icon btn-sm btn-info">
            <i data-feather="edit-2"></i>
        </a>
        @endpermission
        @permission('delete_icons')
        <a
            class="btn rounded-circle btn-icon btn-sm btn-danger confirm-action-button"
            data-action="{{route("icon.admin.destroy",$icon->id)}}"
            data-custom_method='@method('DELETE')'
            data-reload="1">
            <i data-feather="trash"></i>
        </a>
        @endpermission
    </td>
</tr>
