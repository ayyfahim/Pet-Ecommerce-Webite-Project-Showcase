@csrf
<div class="row">
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Company Name</label>
            <input type="text" class="form-control" name="name"
                   @isset($courrier) value="{{$courrier->name}}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Tracking Code URL Suffix</label>
            <input type="text" class="form-control" name="url"
                   @isset($courrier) value="{{$courrier->url}}" @endif>
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
