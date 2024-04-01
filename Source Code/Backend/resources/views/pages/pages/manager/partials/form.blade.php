@csrf
<ul class="nav nav-pills" role="tablist">
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center active" id="information-tab" data-toggle="tab" href="#information"
           aria-controls="information" role="tab" aria-selected="true">
            <i data-feather="info"></i></i><span class="d-none d-sm-block">Information</span>
        </a>
    </li>
    @if(isset($page) && $page->type == 'about')
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center" id="other-tab" data-toggle="tab" href="#other"
               aria-controls="seo" role="tab" aria-selected="false">
                <i data-feather="info"></i><span class="d-none d-sm-block">Other Info</span>
            </a>
        </li>
    @endif
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center" id="seo-tab" data-toggle="tab" href="#seo"
           aria-controls="seo" role="tab" aria-selected="false">
            <i data-feather="share-2"></i><span class="d-none d-sm-block">SEO</span>
        </a>
    </li>
</ul>
<div class="tab-content">
    <!-- Account Tab starts -->
    <div class="tab-pane active" id="information" aria-labelledby="information-tab" role="tabpanel">
        <div class="row">
            <div class="col-12 col-md-9">
                <div class="form-group">
                    <label>Page Title</label>
                    <input type="text" class="form-control" name="title"
                           @isset($page) value="{{$page->title}}" @endif>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label>Status</label>
                    <select data-minimum-results-for-search="Infinity" class="form-control text-capitalize select2"
                            name="status_id">
                        @foreach($status as $statusItem)
                            <option @if(isset($page) && $page->status_id == $statusItem->id) selected
                                    @elseif($statusItem->order == 1) selected
                                    @endif value="{{$statusItem->id}}">{{$statusItem->title}}</option>
                        @endforeach
                    </select>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="form-group">
                    <label>Banner Description</label>
                    <textarea type="text" style="height:400px;" class="form-control"
                              name="banner_description"> @isset($page) {{$page->banner_description}} @endif</textarea>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="form-group">
                    <label>Page Content</label>
                    <textarea type="text" style="height:400px;" class="form-control tinymce-text"
                              name="content"> @isset($page) {{$page->content}} @endif</textarea>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
            <div class="col-12">
                <div class="fileinput-button">
                    <div class="grid grid-cols-12 gap-2">
                        <button class="btn btn-light"
                                type="button">
                            <i class="iconsminds-photo"></i>
                            Select Banner Image
                        </button>
                    </div>
                    <input type="file" name="cover" data-wrapper="#cover-preview-wrapper"
                        class="files"
                        accept="image/*"><br/>
                </div>
                <div class="images-preview text-left" id="cover-preview-wrapper">
                    @if(isset($page) && $page->getUrlFor('cover'))
                        <div class="img-preview text-center">
                            <img src="{{$page->getUrlFor('cover')}}" alt="">
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Account Tab ends -->

    @if(isset($page) && $page->type == 'about')
        @include('pages.pages.manager.partials.forms.other')
    @endif

    <div class="tab-pane" id="seo" aria-labelledby="seo-tab" role="tabpanel">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="form-group">
                    <label>Page URL</label>
                    <input type="text" class="form-control" name="slug"
                           @isset($page) value="{{$page->slug}}" @endif>
                    <small class="form-text">Leave empty to auto generate</small>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="form-group">
                    <label>Meta Title</label>
                    <input type="text" class="form-control" name="seo_title"
                           @isset($page) value="{{$page->seo_title}}" @endif>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="form-group">
                    <label>Meta Description</label>
                    <textarea type="text" class="form-control"
                              name="seo_description">@isset($page) {{$page->seo_description}} @endif</textarea>
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
