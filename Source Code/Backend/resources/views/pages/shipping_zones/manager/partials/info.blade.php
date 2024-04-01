<tr>
    <td>{{$shipping_zone->title}}</td>
    <td>{!!implode(', ',$shipping_zone->cities)!!}</td>
    <td>{{$shipping_zone->regular_price}}</td>
    <td>{{$shipping_zone->quick_price}}</td>
    <td>
        <a href="{{route('shipping_zone.admin.edit',$shipping_zone->id)}}"><i
                class="md-icon material-icons">&#xE254;</i></a>
        <a class="confirm-action-button"
           data-uk-modal="{target:'#confirmationModal'}"
           data-action="{{route('shipping_zone.admin.destroy',$shipping_zone->id)}}"
           data-custom_method='@method('DELETE')'
        ><i class="md-icon material-icons">delete</i></a>
    </td>
</tr>
