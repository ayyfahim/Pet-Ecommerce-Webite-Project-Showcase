@csrf
<h5 class="mb-2">Company Info</h5>
<div class="row">
    <div class="col-12 col-md-9">
        <div class="form-group">
            <label>Company Name</label>
            <input type="text" class="form-control" name="company_name"
                   @isset($vendor) value="{{$vendor->company_name}}" @endif>
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
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Address</label>
            <input type="text" class="form-control" name="address"
                   @isset($vendor) value="{{$vendor->address}}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="form-group">
            <label>Company Number</label>
            <input type="text" class="form-control" name="company_phone"
                   @isset($vendor) value="{{$vendor->company_phone}}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="form-group">
            <label>Supplier Email</label>
            <input type="text" class="form-control" name="company_email"
                   @isset($vendor) value="{{$vendor->company_email}}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="form-group">
            <label>Website</label>
            <input type="text" class="form-control" name="website"
                   @isset($vendor) value="{{$vendor->website}}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>

    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Categories</label>
            <input type="text" class="form-control" name="categories"
                   @isset($vendor) value="{{$vendor->categories}}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Emails for orders</label>
            <input type="text" class="form-control" name="cc"
                   @isset($vendor) value="{{$vendor->cc}}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> Company Logo
                </button>
            </div>
            <input type="file" name="cover" class="files"
                   data-wrapper="#image-wrapper"
                   accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="image-wrapper">
            @if(isset($vendor) && $vendor->cover)
                <img src="{{$vendor->cover->getUrl()}}">
            @endif
        </div>
    </div>
</div>
<hr>
<h5 class="mb-2">Contact Info</h5>
<div class="row">
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Contact Name</label>
            <input type="text" class="form-control" name="name"
                   @isset($vendor) value="{{$vendor->name}}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="form-group">
            <label>Designation</label>
            <input type="text" class="form-control" name="designation"
                   @isset($vendor) value="{{$vendor->designation}}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="form-group">
            <label>Contact Phone</label>
            <input type="text" class="form-control" name="contact_phone"
                   @isset($vendor) value="{{$vendor->contact_phone}}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="form-group">
            <label>Contact Email</label>
            <input type="text" class="form-control" name="email"
                   @isset($vendor) value="{{$vendor->email}}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
</div>
<hr>
<h5 class="mb-2">Payment Info</h5>
<div class="row">
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Bank Account Name</label>
            <input type="text" class="form-control" name="bank_account_name"
                   @isset($vendor) value="{{$vendor->bank_account_name}}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Bank Account Number</label>
            <input type="text" class="form-control" name="bank_account_number"
                   @isset($vendor) value="{{$vendor->bank_account_number}}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Bank Swift Code</label>
            <input type="text" class="form-control" name="bank_swift"
                   @isset($vendor) value="{{$vendor->bank_swift}}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Bank Routing Code</label>
            <input type="text" class="form-control" name="routing_code"
                   @isset($vendor) value="{{$vendor->routing_code}}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>ABA Number</label>
            <input type="text" class="form-control" name="aba_number"
                   @isset($vendor) value="{{$vendor->aba_number}}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Bank Name</label>
            <input type="text" class="form-control" name="bank_name"
                   @isset($vendor) value="{{$vendor->bank_name}}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Bank Address</label>
            <input type="text" class="form-control" name="bank_address"
                   @isset($vendor) value="{{$vendor->bank_address}}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Paypal</label>
            <input type="text" class="form-control" name="paypal"
                   @isset($vendor) value="{{$vendor->paypal}}" @endif>
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
