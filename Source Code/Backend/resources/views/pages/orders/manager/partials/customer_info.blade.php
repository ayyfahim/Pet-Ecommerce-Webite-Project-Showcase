<div class="card mb-4">
    <form action="{{route('address.updateInfo',$order->address_info_id)}}" method="POST" class="ajax" id="addressInfo">
        @method('PATCH')
        @csrf
        <div class="card-body">
            <h5 class="card-title">Customer Information</h5>
            <table class="table table-bordered">
                <tr>
                    <th scope="col">Contact Name</th>
                    <td><input type="text" class="form-control form-control-sm" value="{{$order->address_info?->name}}" name="name">
                    </td>
                </tr>
                <tr>
                    <th>Contact Email</th>
                    <td><input type="text" class="form-control form-control-sm" value="{{$order->address_info?->email}}" name="email">
                    </td>
                </tr>
                <tr>
                    <th>Contact Number</th>
                    <td><input type="text" class="form-control form-control-sm" value="{{$order->address_info?->phone}}" name="phone">
                    </td>
                </tr>
                <tr>
                    <th>Address Title</th>
                    <td><input type="text" class="form-control form-control-sm" value="{{$order->address_info?->title}}" name="title">
                    </td>
                </tr>
                <tr>
                    <th>Business Name</th>
                    <td><input type="text" class="form-control form-control-sm"
                               value="{{$order->address_info?->business_name}}" name="business_name"></td>
                </tr>
                <tr>
                    <th>Street Address</th>
                    <td><input type="text" class="form-control form-control-sm"
                               value="{{$order->address_info?->street_address}}" name="street_address"></td>
                </tr>
                <tr>
                    <th>Suburb</th>
                    <td><input type="text" class="form-control form-control-sm" value="{{$order->address_info?->area}}" name="area">
                    </td>
                </tr>
                <tr>
                    <th>City</th>
                    <td><input type="text" class="form-control form-control-sm" value="{{$order->address_info?->city}}" name="city">
                    </td>
                </tr>
                <tr>
                    <th>Country</th>
                    <td><input type="text" class="form-control form-control-sm"
                               value="{{$order->address_info?->country}}" name="country"></td>
                </tr>
                <tr>
                    <th>Postal Code</th>
                    <td><input type="text" class="form-control form-control-sm"
                               value="{{$order->address_info?->postal_code}}" name="postal_code"></td>
                </tr>
            </table>
            <div class="mt-2 text-right">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </form>
</div>
