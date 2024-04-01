<div class="tab-pane fade" id="voucher" role="tabpanel"
     aria-labelledby="main-tab">
    <div class="row">
        <div class="col-md-12 mb-2">
            <label>Region</label>
            <select class="form-control select2" data-placeholder="Select Region" name="region"
                    data-width="100%">
                <option value=""></option>
                @foreach($regions as $region)
                    <option @if(isset($product) && $product->info->region == $region) selected
                            @endif value="{{$region}}">{{$region}}</option>
                @endforeach
            </select>
            @include('layouts.partials.form-errors',['field'=>"region"])
        </div>
        <div class="col-md-4 mb-2">
            <label>Country</label>
            <select class="form-control select2" data-placeholder="Select Country" name="country_id"
                    data-width="100%">
                <option value=""></option>
                @foreach($countries as $country)
                    <option @if(isset($product) && $product->info->country_id == $country->id) selected
                            @endif value="{{$country->id}}">{{$country->name}}</option>
                @endforeach
            </select>
            @include('layouts.partials.form-errors',['field'=>"country_id"])
        </div>
        <div class="col-md-8 mb-2">
            <label>Cities</label>
            <select class="form-control select2 cities" data-placeholder="Select Cities" name="cities[]" multiple
                    data-width="100%">
                <option value=""></option>
                @foreach($cities as $city)
                    <option @if(isset($product) && in_array($city,$product->info->cities)) selected
                            @endif value="{{$city}}">{{$city}}</option>
                @endforeach
            </select>
            @include('layouts.partials.form-errors',['field'=>"cities"])
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Address</label>
                <input class="form-control" value="{{isset($product)?$product->info->address:''}}" name="address"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Voucher Code</label>
                <input class="form-control" value="{{isset($product)?$product->info->voucher_code:$voucher_code}}"
                       name="voucher_code"/
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
    </div>
</div>
