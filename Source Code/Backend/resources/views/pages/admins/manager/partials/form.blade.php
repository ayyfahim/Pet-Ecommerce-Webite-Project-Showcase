@csrf
<input type="hidden" name="status_id" value="{{isset($user)?$user->status->id:''}}">
<div class="row">
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Full Name</label>
            <input class="form-control" value="{{isset($user)?$user->full_name:''}}" name="full_name"/>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Email Address</label>
            <input class="form-control" value="{{isset($user)?$user->email:''}}" name="email"/>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Mobile</label>
            <input class="form-control" value="{{isset($user)?$user->mobile:''}}" name="mobile"/>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Password (Optional)</label>
            <input class="form-control" type="password" name="password"/>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Password Confirmation (Optional)</label>
            <input class="form-control" type="password" name="password_confirmation"/>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <span class="text-muted">Role</span>
        <select class="form-control select2" name="role_id" data-width="100%">
            @foreach($roles as $role)
                <option @if(isset($user) && $user->hasRole($role->name)) selected
                        @endif value="{{$role->id}}">{{$role->display_name}}</option>
            @endforeach
        </select>
        @include('layouts.partials.form-errors',['field'=>"role_id"])
    </div>
</div>
<hr>
<div class="row">
    <div class="col-12 text-right mt-1">
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{url()->previous()}}" class="btn btn-outline-secondary">Cancel</a>
    </div>
</div>
