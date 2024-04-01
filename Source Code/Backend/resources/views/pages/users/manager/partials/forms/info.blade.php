<div class="tab-pane fade show active" id="main" role="tabpanel"
     aria-labelledby="main-tab">
    <form action="{{route('user.update',$user->id)}}" enctype="multipart/form-data" class="ajax"
          method="POST" id="BasicInfo">
        @csrf
        @method('PATCH')
        <input type="hidden" name="status_id" value="{{$user->status->id}}">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Full Name</label>
                    <input class="form-control" value="{{$user->full_name}}" name="full_name"/>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="form-group">
                    <label>Email Address</label>
                    <input class="form-control" value="{{$user->email}}" name="email"/>
                    @include('layouts.admin.partials.form-errors')
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Mobile</label>
                    <input class="form-control" value="{{$user->mobile}}" name="mobile"/>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Password (Optional)</label>
                    <input class="form-control" name="password"/>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
        </div>
        <div class="text-right">
            <a href="{{url()->previous()}}" class="btn btn-sm btn-outline-primary">Cancel</a>
            <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
        </div>
    </form>
</div>
