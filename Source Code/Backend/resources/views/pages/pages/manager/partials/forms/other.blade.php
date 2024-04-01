<div class="tab-pane fade show" id="other" role="tabpanel"
     aria-labelledby="other-tab">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Sub Title</label>
                <input class="form-control" value="{{isset($page)?$page->info['title']:''}}" name="info[title]"/>
                @include('layouts.admin.partials.form-errors')
            </div>

        </div>
        <div class="col-12">
            <div class="fileinput-button">
                <div class="grid grid-cols-12 gap-2">
                    <button class="btn btn-light"
                            type="button">
                        <i class="iconsminds-photo"></i>
                        Select Side Image
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
        <div class="col-md-6">
            <div class="form-group">
                <label>Vision</label>
                <textarea class="form-control" rows="7"
                          name="info[vision]">{{isset($page)?$page->info['vision']:''}}</textarea>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Mission</label>
                <textarea class="form-control" rows="7"
                          name="info[mission]">{{isset($page)?$page->info['mission']:''}}</textarea>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-12">
            <div class="fileinput-button">
                <div class="grid grid-cols-12 gap-2">
                    <button class="btn btn-light"
                            type="button">
                        <i class="iconsminds-photo"></i>
                        As Seen On Images
                    </button>
                </div>
                <input type="file" name="gallery[]" data-wrapper="#gallery-preview-wrapper"
                       class="files" multiple
                       accept="image/*"><br/>
            </div>
            <div class="gallery-images text-left" id="gallery-preview-wrapper">
                @if(isset($page) && $page->gallery)
                    @foreach($page->gallery as $key=>$gallery)
                        <div class="img-preview text-center">
                            <img src="{{$gallery->getUrl()}}" alt="">
                            <div class="text-center mt-2">
                                <a class="img-remove pointer"
                                   data-id="{{$gallery->id}}"
                                   data-wrapper=".gallery-images">
                                    <i class="iconsminds-close text-danger"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
