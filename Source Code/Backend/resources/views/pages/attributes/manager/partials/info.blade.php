<tr>
    <td>
        <a href="{{route('attribute.admin.edit',$attribute->id)}}">{{$attribute->name}}</a>
    </td>
    <td><span class="badge badge-pill badge-{{$attribute->status->color}}">{{$attribute->status->title}}</span></td>
    <td style="min-width: 150px;">
        @permission('edit_attributes')
        <a href="{{route('attribute.admin.edit',$attribute->id)}}"
           class="btn rounded-circle btn-icon btn-sm btn-info">
            <i data-feather="edit-2"></i>
        </a>
        @endpermission
        @permission('delete_attributes')
        <a
            class="btn rounded-circle btn-icon btn-sm btn-danger confirm-action-button"
            data-action="{{route("attribute.admin.destroy",$attribute->id)}}"
            data-custom_method='@method('DELETE')'
            data-reload="1">
            <i data-feather="trash"></i>
        </a>
        @endpermission
    </td>
</tr>
