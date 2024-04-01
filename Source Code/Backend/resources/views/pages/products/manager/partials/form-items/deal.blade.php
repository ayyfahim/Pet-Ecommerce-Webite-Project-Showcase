@if($deal)
    <input type="hidden" name="deals[{{$dealKey}}][id]" value="{{$deal->id}}">
@endif
@if(isset($deal_variation))
    <tr>
        <td>
            <input type="hidden" name="deals[{{$dealKey}}][variation_id]" value="{{$deal_variation->id}}">
            <div class="custom-control custom-checkbox d-inline-block">
                <input type="checkbox" class="custom-control-input" name="deals[{{$dealKey}}][is_active]"
                       value="1" @if($deal && $deal->is_active) checked @endif
                       id="deals-enabled-{{$dealKey}}">
                <label class="custom-control-label" for="deals-enabled-{{$dealKey}}">Variation #{{$dealKey+1}}</label>
            </div>
            <div class="mb-1"></div>
            @foreach($deal_variation->options as $variation_option)
                @if($variation_option->option->attribute_name)
                <div class="mb-1">
                    <b>{{$variation_option->option->attribute_name}}:</b>
                    <span>{{$variation_option->option->attribute_name=='Color'?get_color_name($variation_option->option->value):$variation_option->option->value}}</span>
                </div>
                @endif
            @endforeach
        </td>
        <td style="text-align: center">
            {{$deal_variation->regular_price}}
        </td>
        <td>
            <div class="col-md-12">
                <div class="form-group">
                    <select class="form-control select2" data-placeholder="Fixed/Percentage"
                            name="deals[{{$dealKey}}][discount_type]"
                            data-width="100%">
                        <option value=""></option>
                        @foreach(['Fixed Amount','Percentage'] as $type)
                            <option class="text-capitalize"
                                    @if($deal && $deal->discount_type == $type) selected @endif
                                    value="{{$type}}">{{$type}}</option>
                        @endforeach
                    </select>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
        </td>
        <td style="min-width: 200px;">
            <div class="col-md-12">
                <div class="form-group">
                    <input class="form-control"
                           type="number"
                           @if($deal) value="{{$deal->discount_amount}}" @endif
                           name="deals[{{$dealKey}}][discount_amount]"/>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
        </td>
        <td style="text-align: center">
            {{$deal_variation->quantity}}
        </td>
        <td style="min-width: 200px;">
            <div class="col-md-12">
                <div class="form-group">
                    <input class="form-control"
                           @if($deal) value="{{$deal->quantity}}" @endif
                           min="1" max="{{$deal_variation->quantity}}"
                           type="number"
                           name="deals[{{$dealKey}}][quantity]"/>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
        </td>
    </tr>
@else
    <tr>
        <td>
            <div class="custom-control custom-checkbox d-inline-block">
                <input type="checkbox" class="custom-control-input" name="deals[{{0}}][is_active]"
                       value="1" @if($deal && $deal->is_active) checked @endif
                       id="deals-enabled-{{0}}">
                <label class="custom-control-label" for="deals-enabled-{{0}}">Main Product</label>
            </div>
        </td>
        <td style="text-align: center">
            {{$product->info->regular_price}}
        </td>
        <td>
            <div class="col-md-12">
                <div class="form-group">
                    <select class="form-control select2" data-placeholder="Fixed/Percentage"
                            name="deals[{{0}}][discount_type]"
                            data-width="100%">
                        <option value=""></option>
                        @foreach(['Fixed Amount','Percentage'] as $type)
                            <option class="text-capitalize"
                                    @if($deal && $deal->discount_type == $type) selected @endif
                                    value="{{$type}}">{{$type}}</option>
                        @endforeach
                    </select>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
        </td>
        <td style="min-width: 200px;">
            <div class="col-md-12">
                <div class="form-group">
                    <input class="form-control"
                           @if($deal) value="{{$deal->discount_amount}}" @endif
                           type="number"
                           name="deals[{{0}}][discount_amount]"/>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
        </td>
        <td style="text-align: center">
            {{$product->quantity}}
        </td>
        <td style="min-width: 200px;">
            <div class="col-md-12">
                <div class="form-group">
                    <input class="form-control"
                           @if($deal) value="{{$deal->quantity}}" @endif
                           min="1" max="{{$product->quantity}}"
                           type="number"
                           name="deals[{{0}}][quantity]"/>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
        </td>
    </tr>
@endif
