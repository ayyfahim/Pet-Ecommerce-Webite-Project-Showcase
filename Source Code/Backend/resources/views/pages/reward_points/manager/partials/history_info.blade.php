<tr>
    <td>{{$reward_point->event}}</td>
    <td>{{$reward_point->points}}</td>
    <td>{{$reward_point->created_at}}</td>
    <td>{{$reward_point->admin?$reward_point->admin->full_name:'-'}}</td>
    <td style="min-width: 150px;">
        @permission('edit_reward_points')
        <a href="{{route('reward_point.admin.edit',$reward_point->id)}}"
           class="btn rounded-circle btn-icon btn-sm btn-info">
            <i data-feather="edit-2"></i>
        </a>
        @endpermission
        @permission('delete_reward_points')
        <a
            class="btn rounded-circle btn-icon btn-sm btn-danger confirm-action-button"
            data-action="{{route("reward_point.admin.destroy",$reward_point->id)}}"
            data-custom_method='@method('DELETE')'
            data-reload="1">
            <i data-feather="trash"></i>
        </a>
        @endpermission
    </td>
</tr>
