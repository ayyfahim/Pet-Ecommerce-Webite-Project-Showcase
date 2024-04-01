@csrf
<ul class="nav nav-pills" role="tablist">
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center active" id="information-tab" data-toggle="tab" href="#information"
           aria-controls="information" role="tab" aria-selected="true">
            <i data-feather="info"></i></i><span class="d-none d-sm-block">Information</span>
        </a>
    </li>
</ul>
<div class="tab-content">
    <!-- Account Tab starts -->
    <div class="tab-pane active" id="information" aria-labelledby="information-tab" role="tabpanel">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="form-group">
                    <label>Pet Type Name</label>
                    <input type="text" class="form-control" name="name"
                           @isset($breed) value="{{$breed->name}}" @endif>
                    @include('layouts.admin.partials.form-errors')
                </div>
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
</div>
<hr>
<div class="row">
    <div class="col-12 text-right mt-1">
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{url()->previous()}}" class="btn btn-outline-secondary">Cancel</a>
    </div>
</div>
