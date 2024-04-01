<table>
    <thead>
    <tr>
        <th>id</th>
        <th>title</th>
        <th>description</th>
        <th>link</th>
        <th>image_link</th>
        <th>additional_image_link</th>
        <th>availability</th>
        <th>price</th>
        <th>sale_price</th>
        <th>google_product_category</th>
        <th>brand</th>
        <th>gtin</th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $key=>$product)
        <tr>
            <td>{{$product->id}}</td>
            <td>{{$product->info->title}}</td>
            <td>{{$product->info->description}}</td>
            <td>{{route('product.show',$product->slug)}}</td>
            <td>{{$product->cover ? asset($product->cover->getUrl()) : ''}}</td>
            <td>
                @foreach ($product->gallery->where('custom_properties.main', false) as $image)
                    {{$image->getUrl()}}
                    @break
                @endforeach
            </td>
            <td>{{str_replace(' ','_',$product->in_stock_label)}}</td>
            <td>{{$product->info->regular_price}} USD</td>
            <td>{{$product->info->sale_price ?: 0}} USD</td>
            <td>{{$product->info->brand ? $product->info->brand->name : ''}}</td>
            <td>{{$product->google_category}}</td>
            <td>{{$product->sku}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
