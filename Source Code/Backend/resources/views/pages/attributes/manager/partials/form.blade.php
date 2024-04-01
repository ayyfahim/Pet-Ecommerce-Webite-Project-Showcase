@csrf
<input type="hidden" name="status_id" value="{{isset($attribute)?$attribute->status->id:$active_status}}">
<input type="hidden" name="product" value="{{isset($attribute)?$attribute->product:1}}">
<input type="hidden" name="category" value="{{isset($attribute)?$attribute->category:0}}">
<div class="row">
    <div class="col-12 col-md-9">
        <div class="form-group">
            <label>Attribute Name</label>
            <input class="form-control" value="{{isset($attribute)?$attribute->name:''}}" name="name"/>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="form-group">
            <label>Status</label>
            <select data-minimum-results-for-search="Infinity" class="form-control text-capitalize select2"
                    name="status_id">
                @foreach($status as $statusItem)
                    <option @if(isset($attribute) && $attribute->status_id == $statusItem->id) selected
                            @elseif($statusItem->order == 1) selected
                            @endif value="{{$statusItem->id}}">{{$statusItem->title}}</option>
                @endforeach
            </select>
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
