<div style="position: relative" class="border variation-item mb-2" data-variation_id="{{$variation->id}}">
    <div data-toggle="collapse" class="p-2 bg-light pointer"
         data-target="#collapse{{$variationKey}}"
         aria-expanded="true" aria-controls="collapseOne">
        <input type="hidden" name="variations[{{$variationKey}}][id]" value="{{$variation->id}}">
        @foreach($product->attributes as $product_attributeKey=>$product_attribute)
            <select name="variations[{{$variationKey}}][options][{{$product_attributeKey}}][id]"
                    onclick="event.stopPropagation();">
                <option value="">All {{Str::plural($product_attribute->attribute->name)}}</option>
                @foreach($product_attribute->configurations as $product_attribute_option)
                    <option
                        @if(in_array($product_attribute_option->id,$variation->options->pluck('option_id')->toArray())) selected
                        @endif
                        value="{{$product_attribute_option->id}}">
                        {{$product_attribute->attribute->name == 'Colorx'?get_color_name($product_attribute_option->value):$product_attribute_option->value}}
                    </option>
                @endforeach
            </select>
        @endforeach
        <i style="position: absolute;
    top: 18px;
    right: 15px;
    font-size: 16px;
    font-weight: 600;" class="simple-icon-arrow-down"></i>
    </div>
    <div id="collapse{{$variationKey}}" class="collapse show px-4 pt-4">
        <div class="">
            <div class="row">
                <div class="col-md-4 text-center">
                    <button type="button"
                            data-toggle="modal"
                            data-target="#variationMediaModal" data-id="{{$variation->id}}"
                            class="btn btn-light btn-sm btn-block select-variation-image-button" style="padding-top:35px;padding-bottom: 35px">
                        Select Image
                    </button>
                    <img class="{{$variation->media?'':'d-none'}} mt-2"
                         src="{{$variation->media?$variation->media->getUrl('thumb'):''}}">
                    <input type="hidden" class="media_id" name="variations[{{$variationKey}}][media_id]"
                           value="{{$variation->media_id}}">
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Quantity</label>
                        <input class="form-control"
                               @if(isset($variation) && $variation->quantity) value="{{$variation->quantity}}"
                               @endisset name="variations[{{$variationKey}}][quantity]"/>
                        @include('layouts.admin.partials.form-errors')
                    </div>
                    <label class="form-group has-float-label mb-2">

                        <span></span>
                    </label>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Price</label>
                        <input class="form-control"
                               @if(isset($variation) && $variation->regular_price) value="{{$variation->regular_price}}"
                               @endisset name="variations[{{$variationKey}}][regular_price]"/>
                        @include('layouts.admin.partials.form-errors')
                    </div>
                </div>
            </div>
            <div class="text-right">
                <button type="button" class="btn btn-outline-danger btn-sm mb-2 delete-variation-button"
                        data-variation_id="{{$variation->id}}">
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>


