@csrf


<div class="row">
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Banner Section Title</label>
            <input type="text" class="form-control" name="banner_section_title"
                @isset($page) value="{{ $page->banner_section_title }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Banner Section Description</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="banner_section_description"> @isset($page) {{ $page->banner_section_description }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> Banner Section Image
                </button>
            </div>
            <input type="file" name="banner_section_image" class="files"
                    data-wrapper="#banner_section_image-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="banner_section_image-wrapper">
            @if (isset($page) && $page->banner_section_image)
                <img src="{{ $page->banner_section_image->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Our Mission Title</label>
            <input type="text" class="form-control" name="our_mission_title"
                @isset($page) value="{{ $page->our_mission_title }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Our Mission Description</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="our_mission_description"> @isset($page) {{ $page->our_mission_description }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> Our Mission Image
                </button>
            </div>
            <input type="file" name="our_mission_image" class="files"
                    data-wrapper="#our_mission_image-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="our_mission_image-wrapper">
            @if (isset($page) && $page->our_mission_image)
                <img src="{{ $page->our_mission_image->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Customised Options Section Title</label>
            <input type="text" class="form-control" name="customised_options_section_title"
                @isset($page) value="{{ $page->customised_options_section_title }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Customised Options Section Description</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="customised_options_section_description"> @isset($page) {{ $page->customised_options_section_description }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> Customised Options Section Image
                </button>
            </div>
            <input type="file" name="customised_options_section_image" class="files"
                    data-wrapper="#customised_options_section_image-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="customised_options_section_image-wrapper">
            @if (isset($page) && $page->customised_options_section_image)
                <img src="{{ $page->customised_options_section_image->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Why Section Title</label>
            <input type="text" class="form-control" name="why_section_title"
                @isset($page) value="{{ $page->why_section_title }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Why Section Description</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="why_section_description"> @isset($page) {{ $page->why_section_description }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> Why Section Image
                </button>
            </div>
            <input type="file" name="why_section_image" class="files"
                    data-wrapper="#why_section_image-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="why_section_image-wrapper">
            @if (isset($page) && $page->why_section_image)
                <img src="{{ $page->why_section_image->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Options Title</label>
            <input type="text" class="form-control" name="options_title"
                @isset($page) value="{{ $page->options_title }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Options Description</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="options_description"> @isset($page) {{ $page->options_description }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> Options Image
                </button>
            </div>
            <input type="file" name="options_image" class="files"
                    data-wrapper="#options_image-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="options_image-wrapper">
            @if (isset($page) && $page->options_image)
                <img src="{{ $page->options_image->getUrl() }}">
            @endif
        </div>
    </div>

    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Our Story Title (Responsive)</label>
            <input type="text" class="form-control" name="our_story_title"
                @isset($page) value="{{ $page->our_story_title }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Our Story Description (Responsive)</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="our_story_description"> @isset($page) {{ $page->our_story_description }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> Our Story Image (Responsive)
                </button>
            </div>
            <input type="file" name="our_story_image" class="files"
                    data-wrapper="#our_story_image-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="our_story_image-wrapper">
            @if (isset($page) && $page->our_story_image)
                <img src="{{ $page->our_story_image->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>About Company Title (Responsive)</label>
            <input type="text" class="form-control" name="about_company_title"
                @isset($page) value="{{ $page->about_company_title }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>About Company Description (Responsive)</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="about_company_description"> @isset($page) {{ $page->about_company_description }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 text-right mt-1">
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Cancel</a>
    </div>
</div>
