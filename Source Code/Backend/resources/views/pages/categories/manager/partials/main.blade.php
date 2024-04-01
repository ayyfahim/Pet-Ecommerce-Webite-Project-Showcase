<div class="tab-pane fade show active" id="main" role="tabpanel"
     aria-labelledby="main-tab">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Category Name</label>
                <input class="form-control" value="{{isset($category)?$category->name:''}}" name="name"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Order</label>
                <input type="number" class="form-control" value="{{isset($category)?$category->sort_order:''}}"
                       name="sort_order"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Category Description</label>
                <textarea class="form-control"
                          name="description">{{isset($category)?$category->description:''}}</textarea>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-4">
            <label>Parent Category</label>
            <select class="form-control select2" name="parent_id" data-width="100%">
                <option value=""></option>
                <option value="parent">Set as Parent</option>
                @foreach($parents as $parent)
                    <option @if(isset($category) && $category->parent_id == $parent->id) selected
                            @endif value="{{$parent->id}}">{{$parent->name}}</option>
                @endforeach
            </select>
            @include('layouts.partials.form-errors',['field'=>"parent_id"])
        </div>
        <div class="col-12 col-md-4">
            <div class="form-group">
                <label>Status</label>
                <select data-minimum-results-for-search="Infinity" class="form-control text-capitalize select2"
                        name="status_id">
                    @foreach($status as $statusItem)
                        <option @if(isset($category) && $category->status_id == $statusItem->id) selected
                                @elseif($statusItem->order == 1) selected
                                @endif value="{{$statusItem->id}}">{{$statusItem->title}}</option>
                    @endforeach
                </select>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-group">
                <label>Featured</label>
                <select data-minimum-results-for-search="Infinity" class="form-control text-capitalize select2"
                        name="featured">
                    @foreach([1,0] as $item)
                        <option @if(isset($category) && $category->featured == $item) selected
                                @elseif($item == 0) selected
                                @endif value="{{$item}}">{{$item==1?'Yes':'No'}}</option>
                    @endforeach
                </select>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-6">
            <div class="fileinput-button">
                <div class="grid grid-cols-12 gap-2">
                    <button class="btn btn-light btn-block"
                            type="button">
                        <i data-feather="image"></i>
                        Select Photo
                    </button>
                </div>
                <input type="file" name="badge" data-wrapper="#gallery-preview-wrapper"
                       class="files"
                       accept="image/*"><br/>
            </div>
            <div class="form-group">
                <label>Alt Image Name</label>
                <input class="form-control"
                       value="{{(isset($category) && $category->badge && isset($category->badge->custom_properties['alt']))?$category->badge->custom_properties['alt']:''}}"
                       name="badge_alt"/>
                @include('layouts.admin.partials.form-errors')
            </div>
            <div class="images-preview text-left" id="gallery-preview-wrapper">
                @if(isset($category) && $category->getUrlFor('badge'))
                    <div class="img-preview text-center">
                        <img src="{{$category->getUrlFor('badge')}}" alt="">
                    </div>
                @endif
            </div>
        </div>

        <div class="col-md-6">
            <div class="fileinput-button">
                <div class="grid grid-cols-12 gap-2">
                    <button class="btn btn-light btn-block"
                            type="button">
                        <i data-feather="image"></i>
                        Select Icon
                    </button>
                </div>
                <input type="file" name="icon" data-wrapper="#icon-preview-wrapper"
                       class="files"
                       accept="image/*"><br/>
            </div>
            <div class="form-group">
                <label>Alt Image Name</label>
                <input class="form-control"
                       value="{{(isset($category) && $category->icon && isset($category->icon->custom_properties['alt']))?$category->icon->custom_properties['alt']:''}}"
                       name="icon_alt"/>
                @include('layouts.admin.partials.form-errors')
            </div>
            <div class="images-preview text-left" id="icon-preview-wrapper">
                @if(isset($category) && $category->getUrlFor('icon'))
                    <div class="img-preview text-center">
                        <img src="{{$category->getUrlFor('icon')}}" alt="">
                    </div>
                @endif
            </div>
        </div>

        <div class="col-12 col-md-12">
            <div class="form-group">
                <label>Banner Overlay Text Heading</label>
                <input type="text" class="form-control" name="banner_title"
                       @isset($category) value="{{$category->banner_title}}" @endif>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>

        <div class="col-12 col-md-12">
            <div class="form-group">
                <label>Banner Overlay Text Body</label>
                <textarea type="text" style="height:400px;" class="form-control tinymce-text"
                          name="banner_description"> @isset($category) {{$category->banner_description}} @endif</textarea>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
    </div>
</div>
