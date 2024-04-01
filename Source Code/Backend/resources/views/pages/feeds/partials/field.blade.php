@foreach(import_fields() as $item)
    <tr>
        <th>
            @if($item == 'supplier_sale_price')
                Supplier Recommended Sale Price
                <small class="form-text">If the supplier has discount price</small>
            @elseif($item == 'supplier_regular_price')
                Regular Price
                <small class="form-text">If the supplier has discount price</small>
            @else
                {{$item}} {{$item == 'sku'?' (required) ':''}}
            @endif
        </th>
        <td>
            <select class="form-control select2" @if($item == 'sku') required @endif name="fields[{{$item}}]"
                    data-width="100%">
                <option value="">- Select Field -</option>
                @foreach($headers as $header)
                    <option @if(isset($feed) && isset($feed->fields[$item]) && $feed->fields[$item] == $header) selected
                            @endif value="{{$header}}">{{$header}}
                    </option>
                @endforeach
            </select>
            <small class="form-text">Leave empty to disable</small>
        </td>
    </tr>
@endforeach
