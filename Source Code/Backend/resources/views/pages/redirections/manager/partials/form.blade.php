@csrf
<div class="row">
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Old URL</label>
            <input class="form-control" value="{{isset($redirection)?$redirection->from:''}}" name="from"/>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>New URL</label>
            <input class="form-control" value="{{isset($redirection)?$redirection->to:''}}" name="to"/>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Status</label>
            <select data-minimum-results-for-search="Infinity" class="form-control text-capitalize select2"
                    name="status_id">
                @foreach($status as $statusItem)
                    <option @if(isset($redirection) && $redirection->status_id == $statusItem->id) selected
                            @elseif($statusItem->order == 1) selected
                            @endif value="{{$statusItem->id}}">{{$statusItem->title}}</option>
                @endforeach
            </select>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Type</label>
            <select data-minimum-results-for-search="Infinity" class="form-control text-capitalize select2"
                    name="type">
                @foreach([301,307] as $item)
                    <option @if(isset($redirection) && $redirection->type == $item) selected
                            @endif value="{{$item}}">
                        {{$item=='301'? 'Permanent (301)':'Temporary (307)'}}
                    </option>
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
