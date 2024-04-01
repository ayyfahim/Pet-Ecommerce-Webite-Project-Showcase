@csrf
<div class="row">
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Icon Title</label>
            <input type="text" class="form-control" name="title"
                   @isset($icon) value="{{$icon->title}}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-md-12">
        <div class="fileinput-button">
            <div class="grid grid-cols-12 gap-2">
                <button class="btn btn-light"
                        type="button">
                    <i data-feather="image"></i>
                    Select Icon
                </button>
                <small class="ml-2 text-muted">Recommended size 100px x 100px</small>
            </div>
            <input type="file" name="badge" data-wrapper="#gallery-preview-wrapper"
                   class="files"
                   accept="image/*"><br/>
        </div>
        <div class="form-group">
            <label>Alt Image Name</label>
            <input class="form-control"
                   value="{{(isset($icon) && $icon->badge && isset($icon->badge->custom_properties['alt']))?$icon->badge->custom_properties['alt']:''}}"
                   name="alt"/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview text-left" id="gallery-preview-wrapper">
            @if(isset($icon) && $icon->getUrlFor('badge'))
                <div class="img-preview text-center">
                    <img src="{{$icon->getUrlFor('badge')}}" alt="">
                </div>
            @endif
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
