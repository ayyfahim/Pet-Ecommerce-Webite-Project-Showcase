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
            <div class="col-12 col-md-9">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" class="form-control" name="title"
                           @isset($article) value="{{$article->title}}" @endif>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
            <div class="col-12 col-md-5">
                <div class="form-group">
                    <label>Video URL</label>
                    <input type="text" class="form-control" name="video_url"
                           @isset($article) value="{{$article->video_url}}" @endif>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label>Category</label>
                    <select class="form-control text-capitalize select2-tagging"
                            name="category" data-placeholder="Select Or Add New...">
                        <option value=""></option>
                        @foreach($categories as $category)
                            <option
                                @if(isset($article))
                                @if($article->category == $category) selected @endif
                                @else
                                @if($category == 'Blog') selected
                                @endif
                                @endif value="{{$category}}">{{$category}}</option>
                        @endforeach
                    </select>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="text" class="form-control" name="sort_order"
                           @isset($article) value="{{$article->sort_order}}" @endif>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="form-group">
                    <label>Content</label>
                    <textarea type="text" style="height:400px;" class="form-control tinymce-text"
                              name="content"> @isset($article) {{$article->content}} @endif</textarea>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label>Author Name</label>
                    <input type="text" class="form-control" name="author[name]"
                           @if(isset($article) && isset($article->author['name'])) value="{{$article->author['name']}}" @endif>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label>Author Title</label>
                    <input type="text" class="form-control" name="author[title]"
                           @if(isset($article) && isset($article->author['title'])) value="{{$article->author['title']}}" @endif>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>

            <div class="col-12 col-md-12">
                <div class="form-group">
                    <label>Author Bio</label>
                    <textarea type="text" rows="3" class="form-control"
                              name="author[bio]">  @if(isset($article) && isset($article->author['bio'])) {{$article->author['bio']}} @endif</textarea>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="fileinput-button mt-1">
                    <div class="grid grid-cols-12 gap-2">
                        <button type="button"
                                class="btn btn-light btn-block">
                            <i data-feather="image"></i> Select Author Image
                        </button>
                    </div>
                    <input type="file" name="avatar" class="files"
                           data-wrapper="#avatar-wrapper"
                           accept="image/*"><br/>
                    @include('layouts.admin.partials.form-errors')
                </div>
                <div class="images-preview" id="avatar-wrapper">
                    @if(isset($article) && $article->avatar)
                        <img src="{{$article->avatar->getUrl()}}">
                    @endif
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="fileinput-button mt-1">
                    <div class="grid grid-cols-12 gap-2">
                        <button type="button"
                                class="btn btn-light btn-block">
                            <i data-feather="image"></i> Select Cover Image
                        </button>
                    </div>
                    <input type="file" name="cover" class="files"
                           data-wrapper="#image-wrapper"
                           accept="image/*"><br/>
                    @include('layouts.admin.partials.form-errors')
                </div>
                <div class="images-preview" id="image-wrapper">
                    @if(isset($article) && $article->cover)
                        <img src="{{$article->cover->getUrl()}}">
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
                    <label>Page URL</label>
                    <input type="text" class="form-control" name="slug"
                           @isset($article) value="{{$article->slug}}" @endif>
                    <small class="form-text">Leave empty to auto generate</small>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="form-group">
                    <label>Meta Title</label>
                    <input type="text" class="form-control" name="meta_title"
                           @isset($article) value="{{$article->meta_title}}" @endif>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="form-group">
                    <label>Meta Description</label>
                    <textarea type="text" class="form-control"
                              name="meta_title">@isset($article) {{$article->meta_title}} @endif</textarea>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 text-right mt-1">
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{url()->previous()}}" class="btn btn-outline-secondary">Cancel</a>
    </div>
</div>
