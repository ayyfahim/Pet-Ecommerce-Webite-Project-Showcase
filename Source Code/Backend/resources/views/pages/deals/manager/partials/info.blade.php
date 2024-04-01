@php
$product = $deal->product;
@endphp



<tr>
    <td>
        <a target="_blank" href="{{route('product.show',$product->slug)}}">
            <img width="60" src="{{$product->getUrlFor('cover')}}" alt="">
        </a>
    </td>
    <td>{{$product->short_id}}</td>
    <td>{{$product->info->title}}</td>
    <td>
        {{$product->info->parent_category?$product->info->parent_category->name:''}} /
        <br>
        {{$product->info->category?$product->info->category->name:''}}
    </td>
    <td>$ {{$product->price}}</td>
    <td>$ {{$deal->price}}</td>
    <td>{{$product->vendor?$product->vendor->company_name:''}}</td>
    <td>0</td>
    <td>$ 0</td>
    <td>{{$deal->from->format('d-m-Y')}}</td>
    <td>{{$deal->to->format('d-m-Y')}}</td>
    @if($deal->is_active)
        <td><span class="badge badge-pill badge-success">Active</span></td>
    @else
        <td><span class="badge badge-pill badge-danger">Inactive</span></td>
    @endif
    <td style="min-width: 150px;">
        @permission('edit_products')
        <a href="{{route('deal.admin.edit',$deal->id)}}"
           class="btn rounded-circle btn-icon btn-sm btn-info">
            <i data-feather="edit-2"></i>
        </a>
        @endpermission
        @permission('delete_products')
        <a
            class="btn rounded-circle btn-icon btn-sm btn-danger confirm-action-button"
            data-action="{{route("deal.admin.destroy",$deal->id)}}"
            data-custom_method='@method('DELETE')'
            data-reload="1">
            <i data-feather="trash"></i>
        </a>
        @endpermission
    </td>
</tr>

