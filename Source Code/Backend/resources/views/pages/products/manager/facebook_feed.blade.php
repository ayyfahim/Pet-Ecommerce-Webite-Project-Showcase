<table>
    <thead>
    <tr>
        <th>id</th>
        <th>title</th>
        <th>description</th>
        <th>availability</th>
        <th>condition</th>
        <th>price</th>
        <th>link</th>
        <th>image_link</th>
        <th>brand</th>
        <th>google_product_category</th>
        <th>sale_price</th>
        <th>additional_image_link</th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $key=>$product)
        <tr>
            <td>{{$product->id}}</td>
            <td>{{$product->info->title}}</td>
            <td>{{$product->info->description}}</td>
            <td>{{$product->in_stock_label}}</td>
            <td>new</td>
            <td>{{$product->info->regular_price}} USD</td>
            <td>{{route('product.show',$product->slug)}}</td>
            <td>{{$product->cover ? asset($product->cover->getUrl()) : ''}}</td>
            <td>{{$product->info->brand ? $product->info->brand->name : ''}}</td>
            <td>{{$product->google_category}}</td>
            <td>{{$product->info->sale_price ?: 0}} USD</td>
            <td>
                @php
                    $urls = [];
                    foreach ($product->gallery->where('custom_properties.main', false) as $image){
                    $urls[] = $image->getUrl();
                    }
                @endphp
                {{implode(',',$urls)}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
