<tr>
    <td>
        <a href="{{route('user.admin.edit',$user->id)}}">{{$user->full_name}}</a>
    </td>
    <td>{{$user->email}}</td>
    <td>{{$user->mobile}}</td>
    <td>0</td>
    <td>0 $</td>
    <td>0</td>
    <td>{{$user->created_at->format('d-m-Y')}}</td>
    <td>{{$user->last_login}}</td>
    <td>
        <span class="badge badge-pill badge-{{$user->status->color}}">{{$user->status->title}}</span>
    </td>
    <td style="min-width: 150px;">
        @permission('edit_customers')
        <a href="{{route('user.admin.edit',$user->id)}}"
           class="btn rounded-circle btn-icon btn-sm btn-info">
            <i data-feather="edit-2"></i>
        </a>
        @endpermission
        @permission('edit_customers')
        <a
            class="btn rounded-circle btn-icon btn-sm btn-danger confirm-action-button"
            data-action="{{route("user.admin.destroy",$user->id)}}"
            data-custom_method='@method('DELETE')'
            data-reload="1">
            <i data-feather="trash"></i>
        </a>
        @endpermission
    </td>
</tr>
