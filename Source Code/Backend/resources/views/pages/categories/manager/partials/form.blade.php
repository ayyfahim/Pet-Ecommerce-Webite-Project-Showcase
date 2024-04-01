@csrf
<ul class="nav nav-pills" role="tablist">
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center active" id="first-tab" data-toggle="tab" href="#main"
           aria-controls="first" role="tab" aria-selected="true">
            <i data-feather="info"></i></i><span class="d-none d-sm-block">Information</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center" id="seo-tab" data-toggle="tab" href="#seo"
           aria-controls="seo" role="tab" aria-selected="false">
            <i data-feather="share-2"></i><span class="d-none d-sm-block">SEO</span>
        </a>
    </li>
</ul>
<div class="tab-content">
    @include('pages.categories.manager.partials.main')
    <div class="tab-pane" id="seo" aria-labelledby="seo-tab" role="tabpanel">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="form-group">
                    <label>URL Key</label>
                    <input type="text" class="form-control" name="slug"
                           @isset($category) value="{{$category->slug}}" @endif>
                    <small class="form-text">Leave empty to auto generate</small>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="form-group">
                    <label>Meta Title</label>
                    <input type="text" class="form-control" name="seo_title"
                           @isset($category) value="{{$category->seo_title}}" @endif>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="form-group">
                    <label>Meta Description</label>
                    <textarea type="text" class="form-control"
                              name="seo_description">@isset($category) {{$category->seo_description}} @endif</textarea>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="form-group">
                    <label>Keywords</label>
                    <input type="text" class="form-control" name="keywords"
                           @isset($category) value="{{$category->keywords}}" @endif>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
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

