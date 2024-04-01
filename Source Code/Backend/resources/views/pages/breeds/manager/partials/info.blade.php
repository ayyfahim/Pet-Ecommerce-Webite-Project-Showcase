<tr>
    <td>
        <img width="60" src="{{$breed->getUrlFor('badge')}}" alt="">
    </td>
    <td><a href="{{route('breed.admin.edit',$breed->id)}}">{{$breed->name}}</a></td>
    <td>{{$breed->products->count()}}</td>
{{--    <td>{{$breed->order_products->sum('quantity')}}</td>--}}
{{--    <td>$ {{$breed->order_products->sum('total')}}</td>--}}
    <td style="min-width: 150px;">
        @permission('edit_brands')
        <a href="{{route('breed.admin.edit',$breed->id)}}"
           class="btn rounded-circle btn-icon btn-sm btn-info">
            <i data-feather="edit-2"></i>
        </a>
        @endpermission
        @permission('delete_brands')
        <a
            class="btn rounded-circle btn-icon btn-sm btn-danger confirm-action-button"
            data-action="{{route("breed.admin.destroy",$breed->id)}}"
            data-custom_method='@method('DELETE')'
            data-reload="1">
            <i data-feather="trash"></i>
        </a>
        @endpermission
    </td>
</tr>
