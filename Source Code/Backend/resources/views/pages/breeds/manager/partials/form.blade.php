@csrf
<ul class="nav nav-pills" role="tablist">
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center active" id="information-tab" data-toggle="tab" href="#information"
           aria-controls="information" role="tab" aria-selected="true">
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
    <!-- Account Tab starts -->
    <div class="tab-pane active" id="information" aria-labelledby="information-tab" role="tabpanel">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="form-group">
                    <label>Breed Name</label>
                    <input type="text" class="form-control" name="name"
                           @isset($breed) value="{{$breed->name}}" @endif>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
            <div class="col-md-12 mb-2">
                <label>Pet Type</label>
                <select class="form-control select2" name="pet_type_id" data-width="100%">
                    @foreach($pet_types as $animal)
                        <option @if(isset($breed) && $breed->pet_type_id == $animal->id)
                                selected
                                @endif value="{{$animal->id}}">{{$animal->name}}</option>
                    @endforeach
                </select>
                @include('layouts.partials.form-errors',['field'=>"animal"])
            </div>
            <div class="col-12 col-md-12">
                <div class="form-group">
                    <label>Breed Description</label>
                    <textarea type="text" style="height:400px;" class="form-control tinymce-text"
                              name="description"> @isset($breed) {{$breed->description}} @endif</textarea>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="fileinput-button mt-1">
                    <div class="grid grid-cols-12 gap-2">
                        <button type="button"
                                class="btn btn-light btn-block">
                            <i data-feather="image"></i> Select Image
                        </button>
                    </div>
                    <input type="file" name="badge" class="files"
                           data-wrapper="#image-wrapper"
                           accept="image/*"><br/>
                    @include('layouts.admin.partials.form-errors')
                </div>
                <div class="images-preview" id="image-wrapper">
                    @if(isset($breed) && $breed->badge)
                        <img src="{{$breed->badge->getUrl()}}">
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Account Tab ends -->

    <div class="tab-pane" id="seo" aria-labelledby="seo-tab" role="tabpanel">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="form-group">
                    <label>Breed URL</label>
                    <input type="text" class="form-control" name="slug"
                           @isset($breed) value="{{$breed->slug}}" @endif>
                    <small class="form-text">Leave empty to auto generate</small>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="form-group">
                    <label>Meta Title</label>
                    <input type="text" class="form-control" name="seo_title"
                           @isset($breed) value="{{$breed->seo_title}}" @endif>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="form-group">
                    <label>Meta Description</label>
                    <textarea type="text" class="form-control"
                              name="seo_description">@isset($breed) {{$breed->seo_description}} @endif</textarea>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="form-group">
                    <label>Keywords</label>
                    <input type="text" class="form-control" name="keywords"
                           @isset($breed) value="{{$breed->keywords}}" @endif>
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
