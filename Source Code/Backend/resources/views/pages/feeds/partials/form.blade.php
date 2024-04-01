@csrf
<div class="row">
    <div class="col-md-12 mb-2">
        <label>Supplier</label>
        <select class="form-control select2" name="vendor_id" data-width="100%">
            @foreach($vendors as $vendor)
                <option @if(isset($feed) && $feed->vendor_id == $vendor->id) selected
                        @endif value="{{$vendor->id}}">{{$vendor->company_name}}</option>
            @endforeach
        </select>
        @include('layouts.admin.partials.form-errors')
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-8">
        <div class="form-group">
            <label>URL</label>
            <input class="form-control" value="{{isset($feed)?$feed->url:''}}" name="url"/>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="form-group" style="padding-top: 25px">
            <button id="fetch-btn" type="button" data-action="{{route('feed.admin.fetch')}}"
                    class="btn btn-dark btn-block">Fetch
            </button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 mb-2">
        <label>Frequency</label>
        <select class="form-control select2" name="frequency" data-width="100%">
            @foreach([1,3,6,12,24] as $item)
                <option @if(isset($feed) && $feed->frequency == $item) selected
                        @endif value="{{$item}}">Every {{$item}} Hour
                </option>
            @endforeach
        </select>
        @include('layouts.admin.partials.form-errors')
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Percentage (%) to add to cost price</label>
            <input type="number"
                   class="form-control" value="{{isset($feed)?$feed->percentage:0}}" name="percentage"/>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Percentage (%) to add to supplier recommended sale price</label>
            <input type="number"
                   class="form-control" value="{{isset($feed)?$feed->discounted_percentage:0}}" name="discounted_percentage"/>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
</div>
<table class="table table-bordered">
    <thead class="thead-dark">
    <tr>
        <th>Deal A Day Field</th>
        <th>Supplier Field</th>
    </tr>
    </thead>
    <tbody id="fields-wrapper">
    @if(isset($feed))
        @include('pages.feeds.partials.field')
    @endif
    </tbody>
</table>
<div>

</div>
<hr>
<div class="row">
    <div class="col-12 text-right mt-1">
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{url()->previous()}}" class="btn btn-outline-secondary">Cancel</a>
    </div>
</div>
