@csrf
<input type="hidden" name="admin_id" value="{{$authUser->id}}">
<div class="row">
    <div class="col-md-12 mb-2">
        @if(isset($user) && $user)
            <label for="rewardpoint_user" class="form-label">
                User
            </label>
            <input type="hidden" name="user_id" value="{{$user->id}}">
            <div>
                <b>
                    {{$user->full_name}}
                </b>
            </div>
        @else


            <label>User</label>
            <select class="form-control select2" name="user_id" data-width="100%">
                <option value=""></option>
                @foreach($users as $user)
                    <option value="{{$user->id}}">{{$user->full_name}}</option>
                @endforeach
            </select>
            @include('layouts.partials.form-errors',['field'=>"user_id"])
        @endif
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label> @if(isset($reward_point))
                    Points
                @else
                    Points to be added
                @endif</label>
            <input class="form-control" type="number" @isset($reward_point) value="{{$reward_point->points}}"
                   @endisset name="points"/>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Reason</label>
            <input class="form-control" type="text" @isset($reward_point) value="{{$reward_point->reason}}"
                   @endisset name="reason"/>
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
