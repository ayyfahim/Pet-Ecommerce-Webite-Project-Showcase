<div class="tab-pane fade" id="address" role="tabpanel"
     aria-labelledby="address-tab">
    @forelse($user->addresses as $key=>$address)
        <form action="{{route('address.update',$address->id)}}" method="POST" class="ajax mb-4"
              id="Address{{$key}}">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Title</label>
                        <input class="form-control" value="{{$address->info->title}}" name="title"/>
                        @include('layouts.admin.partials.form-errors')
                    </div>
                </div>
                <div class="col-md-4">

                    <div class="form-group">
                        <label>Building</label>
                        <input class="form-control" value="{{$address->info->building_number}}" name="building_number"/>
                        @include('layouts.admin.partials.form-errors')
                    </div>
                </div>
                <div class="col-md-4">

                    <div class="form-group">
                        <label>Floor</label>
                        <input class="form-control" value="{{$address->info->floor_number}}" name="floor_number"/>
                        @include('layouts.admin.partials.form-errors')
                    </div>
                </div>
                <div class="col-md-4">

                    <div class="form-group">
                        <label>Apartment</label>
                        <input class="form-control" value="{{$address->info->apartment_number}}"
                               name="apartment_number"/
                        @include('layouts.admin.partials.form-errors')
                    </div>
                </div>
                <div class="col-md-12">

                    <div class="form-group">
                        <label>Street Address</label>
                        <input class="form-control" value="{{$address->info->street_address}}" name="street_address"/>
                        @include('layouts.admin.partials.form-errors')
                    </div>
                </div>
                <div class="col-md-4">

                    <div class="form-group">
                        <label>City</label>
                        <input class="form-control" value="{{$address->info->city}}" name="city"/>
                        @include('layouts.admin.partials.form-errors')
                    </div>
                </div>
                <div class="col-md-4">

                    <div class="form-group">
                        <label>Country</label>
                        <input class="form-control" value="{{$address->info->country}}" name="country"/>
                        @include('layouts.admin.partials.form-errors')
                    </div>
                </div>
                <div class="col-md-4">

                    <div class="form-group">
                        <label>Postal Code</label>
                        <input class="form-control" value="{{$address->info->postal_code}}" name="postal_code"/>
                        @include('layouts.admin.partials.form-errors')
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
                </div>
            </div>
        </form>
        <div class="separator mb-4"></div>
    @empty
        <h3 class="text-primary">No Addresses Yet</h3>
    @endforelse
</div>
