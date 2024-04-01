<tr>
    <td>
        <a target="_blank" href="{{route('product.show',$product->slug)}}">
            <img width="60" src="{{$product->getUrlFor('cover')}}" alt="">
        </a>
    </td>
    <td>{{$product->short_id}}</td>
    <td>
        <a href="{{route('product.admin.edit',$product->id)}}"> {{$product->info->title}}</a>
    </td>
    <td>
        {{$product->info->parent_category?$product->info->parent_category->name.'/'.'<br>':''}}
        {{$product->info->category?$product->info->category->name:''}}
    </td>
    <td>{{$product->price}}</td>
    <td>{{$product->info->brand?$product->info->brand->name:''}}</td>
    <td>{{$product->vendor?$product->vendor->company_name:''}}</td>
    <td>{{$product->orders_number}}</td>
    <td>$ {{$product->orders_amount}}</td>
    <td>{{$product->created_at->format('d-m-Y')}}</td>
    <td>
        {{$product->updated_at->format('d-m-Y')}}
    </td>
    <td>
        {{$product->user?$product->user->full_name:''}}
    </td>
    <td><span class="badge badge-pill badge-{{$product->status->color}}">{{$product->status->title}}</span></td>
    <td>@if($product->featured) Yes @else No @endif</td>
    <td><span class="text-{{$product->in_stock_color}}">{{$product->in_stock_label}}</span></td>
    <td style="min-width: 150px;">
        @permission('edit_products')
        <a href="{{route('product.admin.edit',$product->id)}}"
           class="btn rounded-circle btn-icon btn-sm btn-info">
            <i data-feather="edit-2"></i>
        </a>
        @endpermission
        @permission('delete_products')
        <a
            class="btn rounded-circle btn-icon btn-sm btn-danger confirm-action-button"
            data-action="{{route("product.admin.destroy",$product->id)}}"
            data-custom_method='@method('DELETE')'
            data-reload="1">
            <i data-feather="trash"></i>
        </a>
        @endpermission
    </td>
</tr>

