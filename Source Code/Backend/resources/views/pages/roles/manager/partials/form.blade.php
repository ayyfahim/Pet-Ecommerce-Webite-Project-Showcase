@csrf
<div class="row">
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Role Name</label>
            <input class="form-control" value="{{isset($role)?$role->display_name:''}}" name="display_name"/>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h6>Permissions</h6>
        <div id="accordion">
            @foreach($permissions as $key=>$perms)
                <div class="border">
                    <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$key}}"
                            aria-expanded="true" aria-controls="collapseOne">
                        {{$key}}
                    </button>
                    <div id="collapse{{$key}}" class="collapse @if($key == 'dashboard') show @endif"
                         data-parent="#accordion">
                        <div class="pl-4">
                        @foreach($perms as $perm)
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" name="permissions[]" @if(isset($role) && in_array($perm->id,$role->perms->pluck('id')->toArray())) checked @endif value="{{$perm->id}}" class="custom-control-input" id="customCheck{{$perm->name}}">
                                <label class="custom-control-label" for="customCheck{{$perm->name}}">
                                    {{$perm->display_name}}
                                </label>
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
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
