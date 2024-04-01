@csrf
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>Subject</label>
            <input class="form-control"
                   value="{{isset($email_template)?$email_template->email_notification->subject:''}}"
                   name="subject">
            @include('layouts.admin.partials.form-errors',['field'=>"subject"])
        </div>
        <div class="form-group">
            <label>Body</label>
            <textarea class="form-control tinymce-text" style="height: 400px"
                      name="body">{!!isset($email_template)?$email_template->email_notification->body:''!!}</textarea>
            @include('layouts.admin.partials.form-errors',['field'=>"body"])
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
