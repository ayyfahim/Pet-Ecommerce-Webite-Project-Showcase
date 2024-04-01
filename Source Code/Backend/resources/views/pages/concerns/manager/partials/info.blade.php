<tr>
    <td>
        <img width="60" src="{{$concern->getUrlFor('badge')}}" alt="">
    </td>
    <td><a href="{{route('concern.admin.edit',$concern->id)}}">{{$concern->name}}</a></td>
{{--    <td>{{$concern->products->count()}}</td>--}}
{{--    <td>{{$concern->order_products->sum('quantity')}}</td>--}}
{{--    <td>$ {{$concern->order_products->sum('total')}}</td>--}}
    <td style="min-width: 150px;">
        @permission('edit_brands')
        <a href="{{route('concern.admin.edit',$concern->id)}}"
           class="btn rounded-circle btn-icon btn-sm btn-info">
            <i data-feather="edit-2"></i>
        </a>
        @endpermission
        @permission('delete_brands')
        <a
            class="btn rounded-circle btn-icon btn-sm btn-danger confirm-action-button"
            data-action="{{route("concern.admin.destroy",$concern->id)}}"
            data-custom_method='@method('DELETE')'
            data-reload="1">
            <i data-feather="trash"></i>
        </a>
        @endpermission
    </td>
</tr>
