<tr>
    <td>{{$attribute->name}}</td>
    {{--<td>0</td>--}}
    <td>
        <a href="{{route('attribute.admin.edit',$attribute->id)}}"><i class="md-icon material-icons">&#xE254;</i></a>
        <a class="confirm-action-button"
           data-uk-modal="{target:'#confirmationModal'}"
           data-action="{{route('attribute.admin.destroy',$attribute->id)}}"
           data-custom_method='@method('DELETE')'
        ><i class="md-icon material-icons">delete</i></a>
    </td>
</tr>