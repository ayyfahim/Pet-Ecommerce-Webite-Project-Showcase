@csrf
<div class="row">
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Title</label>
            <input class="form-control" value="{{isset($deal)?$deal->title:''}}" name="title"/>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>

    <div class="col-md-12 mb-2">
        <label>Product</label>
        <select class="form-control select2" required name="product_id"
                data-width="100%">
            <option value="">Select Product</option>
            @foreach($products as $product)
                <option
                    @if(isset($deal) && $deal->product_id == $product->id) selected
                    @endif value="{{$product->id}}">{{$product->info->title}}</option>
            @endforeach
        </select>
        @include('layouts.admin.partials.form-errors')
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Price</label>
            <input class="form-control" type="number" step="0.01" value="{{isset($deal)?$deal->price:''}}"
                   name="price"/>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Quantity</label>
            <input class="form-control" type="number" value="{{isset($deal)?$deal->quantity:''}}"
                   name="quantity"/>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>

    <div class="col-12 col-md-6 mb-2">
        <label>Date From</label>
        <input type="text" id="fp-default" class="form-control flatpickr-basic"
               name="from"
               placeholder="Date From"
               value="{{isset($deal)?$deal->from:''}}"/>
        @include('layouts.admin.partials.form-errors')

    </div>
    <div class="col-12 col-md-6 mb-2">
        <label>Date To</label>
        <input type="text" id="fp-default" class="form-control flatpickr-basic"
               name="to"
               placeholder="Date To"
               value="{{isset($deal)?$deal->to:''}}"/>
        @include('layouts.admin.partials.form-errors')
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Notes</label>
            <textarea class="form-control" name="notes">{{isset($deal)?$deal->notes:''}}</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
</div>

<hr>
<div class="row">
    <div class="col-12 text-right mt-1">
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{url()->previous()}}" class="btn btn-outline-secondary">Cancel</a>
    </div>
</div>
