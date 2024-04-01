<div class="row">
    <div class="col-md-6">
        <label class="form-group has-float-label mb-4">
            <textarea class="form-control" rows="7"
                      name="info[office]">{{isset($page)?$page->info['office']:''}}</textarea>
            <span>Office Address</span>
            @include('layouts.partials.form-errors',['field'=>"info.office"])
        </label>
    </div>
    <div class="col-md-6">
        <label class="form-group has-float-label mb-4">
            <textarea class="form-control" rows="7"
                      name="info[postal]">{{isset($page)?$page->info['postal']:''}}</textarea>
            <span>Postal Address</span>
            @include('layouts.partials.form-errors',['field'=>"info.postal"])
        </label>
    </div>
    <div class="col-md-12">
        <label class="form-group has-float-label mb-4">
            <input class="form-control" value="{{isset($page)?$page->info['email']:''}}" name="info[email]"/>
            <span>Email</span>
            @include('layouts.partials.form-errors',['field'=>"info.email"])
        </label>
    </div>
    <div class="col-md-12">
        <label class="form-group has-float-label mb-4">
            <input class="form-control" value="{{isset($page)?$page->info['phone']:''}}" name="info[phone]"/>
            <span>Phone</span>
            @include('layouts.partials.form-errors',['field'=>"info.phone"])
        </label>
    </div>
</div>


