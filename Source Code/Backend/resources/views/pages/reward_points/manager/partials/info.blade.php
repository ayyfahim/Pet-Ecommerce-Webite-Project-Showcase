<tr>
    <td>{{$reward_point_user->full_name}}</td>
    <td>{{$reward_point_user->total_reward_points}}</td>
    <td style="min-width: 150px;">
        <a href="{{route('reward_point.admin.show',$reward_point_user->id)}}"
           class="btn rounded-circle btn-icon btn-sm btn-info">
            <i data-feather="eye"></i>
        </a>
        <a href="{{route('reward_point.admin.create',$reward_point_user->id)}}"
           class="btn rounded-circle btn-icon btn-sm btn-primary">
            <i data-feather="plus"></i>
        </a>
    </td>
</tr>
