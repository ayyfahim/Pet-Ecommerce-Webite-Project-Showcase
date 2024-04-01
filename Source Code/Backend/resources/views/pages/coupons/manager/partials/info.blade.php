<tr>
    <td>{{$coupon->title}}</td>
    <td>{{$coupon->code}}</td>
    <td>{{$coupon->discount_amount}}</td>
    <td>{{$coupon->discount_type}}</td>
    <td>{{$coupon->uses_per_coupon}}</td>
    <td>{{$coupon->orders->count()}}</td>
    <td>{{$coupon->orders->sum('amount')}}</td>
    <td>{{$coupon->from->format('d-m-Y')}}</td>
    <td>{{$coupon->to->format('d-m-Y')}}</td>
    <td><span class="badge badge-pill badge-{{$coupon->status->color}}">{{$coupon->status->title}}</span></td>
    <td style="min-width: 150px;">
        @permission('edit_coupons')
        <a href="{{route('coupon.admin.edit',$coupon->id)}}"
           class="btn rounded-circle btn-icon btn-sm btn-info">
            <i data-feather="edit-2"></i>
        </a>
        @endpermission
        @permission('delete_coupons')
        <a
            class="btn rounded-circle btn-icon btn-sm btn-danger confirm-action-button"
            data-action="{{route("coupon.admin.destroy",$coupon->id)}}"
            data-custom_method='@method('DELETE')'
            data-reload="1">
            <i data-feather="trash"></i>
        </a>
        @endpermission
    </td>
</tr>
