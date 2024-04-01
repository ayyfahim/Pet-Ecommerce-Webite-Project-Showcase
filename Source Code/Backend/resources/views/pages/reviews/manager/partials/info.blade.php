<tr>
    <td>{{$review->product->info->title}}</td>
    <td>#{{$review->order->short_id}}</td>
    <td>{{$review->user->full_name}}</td>
    <td>{{str_trim($review->body,5)}}</td>
    <td>{{$review->rate}}</td>
    <td>
        <a href="{{route('review.admin.edit',$review->id)}}"><i class="md-icon material-icons">&#xE254;</i></a>
        <a class="confirm-action-button"
           data-uk-modal="{target:'#confirmationModal'}"
           data-action="{{route('review.admin.destroy',$review->id)}}"
           data-custom_method='@method('DELETE')'
        ><i class="md-icon material-icons">delete</i></a>
    </td>
</tr>