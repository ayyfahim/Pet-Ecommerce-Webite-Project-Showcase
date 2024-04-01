<tr>
    <td>
        <a href="{{route('vendor.admin.edit',$vendor->id)}}">{{$vendor->company_name}}</a>
    </td>
    <td>{{$vendor->name}}</td>
    <td>{{$vendor->contact_phone}}</td>
    <td>{{$vendor->email}}</td>
    <td>{{$vendor->products->count()}}</td>
    <td>{{$vendor->order_products->sum('quantity')}}</td>
    <td>$ {{$vendor->order_products->sum('total')}}</td>
    <td style="min-width: 150px;">
        @permission('edit_vendors')
        <a href="{{route('vendor.admin.edit',$vendor->id)}}"
           class="btn rounded-circle btn-icon btn-sm btn-info">
            <i data-feather="edit-2"></i>
        </a>
        @endpermission
        @permission('delete_vendors')
        <a
            class="btn rounded-circle btn-icon btn-sm btn-danger confirm-action-button"
            data-action="{{route("vendor.admin.destroy",$vendor->id)}}"
            data-custom_method='@method('DELETE')'
            data-reload="1">
            <i data-feather="trash"></i>
        </a>
        @endpermission
    </td>
</tr>
