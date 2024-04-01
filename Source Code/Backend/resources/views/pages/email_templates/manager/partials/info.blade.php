<tr>
    <td>{{$key+1}}</td>
    <td>{{$email_template->title}}</td>
    <td>
        <span class="badge badge-{{$email_template->email_notification->is_active?'success':'danger'}}">
            {{$email_template->email_notification->is_active?'Active':'Inactive'}}
        </span>
    </td>
    <td>
        <a href="{{route('content.admin.email_template.edit',$email_template->id)}}"
           class="btn rounded-circle btn-icon btn-sm btn-info">
            <i data-feather="edit-2"></i>
        </a>
        <a href="{{route('content.admin.email_template.show',$email_template->id)}}"
           class="btn rounded-circle btn-icon btn-sm btn-warning">
            <i data-feather="eye"></i>
        </a>
    </td>
</tr>
