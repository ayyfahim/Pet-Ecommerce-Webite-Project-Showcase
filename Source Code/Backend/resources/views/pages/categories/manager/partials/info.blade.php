<tr @isset($tr_class) class="{{$tr_class}}" @endisset
@isset($tr_id) id="{{$tr_id}}" @endisset
    @isset($data_parent) data-parent="{{$data_parent}}" @endisset
    @isset($data_top_parent) data-top_parent="{{$data_top_parent}}" @endisset>
    <td>
        @if(sizeof($category->children))
            {{isset($indicator)?$indicator:''}}
            {{$category->name}}
        @else
            {{isset($indicator)?$indicator:''}}
            {{$category->name}}
        @endif
    </td>
    <td>
        <img width="60" src="{{$category->getUrlFor('badge')}}" alt="">
    </td>
    <td>{{$category->products_count}}</td>
    <td>{{$category->sales_quantity}}</td>
    <td>$ {{$category->sales_amount}}</td>
    <td><span class="badge badge-pill badge-{{$category->status->color}}">{{$category->status->title}}</span></td>
    <td>
        @permission('edit_categories')
        <a href="{{route('category.admin.edit',$category->id)}}"
           class="btn rounded-circle btn-icon btn-sm btn-info">
            <i data-feather="edit-2"></i>
        </a>
        @endpermission
        @permission('delete_categories')
        <a
            class="btn rounded-circle btn-icon btn-sm btn-danger confirm-action-button"
            data-action="{{route("category.admin.destroy",$category->id)}}"
            data-custom_method='@method('DELETE')'
            data-reload="1">
            <i data-feather="trash"></i>
        </a>
        @endpermission
    </td>
</tr>
