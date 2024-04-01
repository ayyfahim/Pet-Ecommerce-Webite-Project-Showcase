@csrf


<div class="row">
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Reward Program Banner Title</label>
            <input type="text" class="form-control" name="reward_program_banner_title"
                @isset($page) value="{{ $page->reward_program_banner_title }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Reward Program Banner Description</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="reward_program_banner_description"> @isset($page) {{ $page->reward_program_banner_description }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> Banner Image
                </button>
            </div>
            <input type="file" name="banner_image" class="files"
                    data-wrapper="#banner_image-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="banner_image-wrapper">
            @if (isset($page) && $page->banner_image)
                <img src="{{ $page->banner_image->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>How it works section Title</label>
            <input type="text" class="form-control" name="how_it_works_section_title"
                @isset($page) value="{{ $page->how_it_works_section_title }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>How it works section Description</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="how_it_works_section_description"> @isset($page) {{ $page->how_it_works_section_description }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>How it works 1 Title</label>
            <input type="text" class="form-control" name="how_it_works_1_title"
                @isset($page) value="{{ $page->how_it_works_1_title }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> How it works 1 Icon
                </button>
            </div>
            <input type="file" name="how_it_works_1_icon" class="files"
                    data-wrapper="#how_it_works_1_icon-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="how_it_works_1_icon-wrapper">
            @if (isset($page) && $page->how_it_works_1_icon)
                <img src="{{ $page->how_it_works_1_icon->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>How it works 1 Description</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="how_it_works_1_description"> @isset($page) {{ $page->how_it_works_1_description }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>How it works 2 Title</label>
            <input type="text" class="form-control" name="how_it_works_2_title"
                @isset($page) value="{{ $page->how_it_works_2_title }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> How it works 2 Icon
                </button>
            </div>
            <input type="file" name="how_it_works_2_icon" class="files"
                    data-wrapper="#how_it_works_2_icon-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="how_it_works_2_icon-wrapper">
            @if (isset($page) && $page->how_it_works_2_icon)
                <img src="{{ $page->how_it_works_2_icon->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>How it works 2 Description</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="how_it_works_2_description"> @isset($page) {{ $page->how_it_works_2_description }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>How it works 3 Title</label>
            <input type="text" class="form-control" name="how_it_works_3_title"
                @isset($page) value="{{ $page->how_it_works_3_title }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> How it works 3 Icon
                </button>
            </div>
            <input type="file" name="how_it_works_3_icon" class="files"
                    data-wrapper="#how_it_works_3_icon-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="how_it_works_3_icon-wrapper">
            @if (isset($page) && $page->how_it_works_3_icon)
                <img src="{{ $page->how_it_works_3_icon->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>How it works 3 Description</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="how_it_works_3_description"> @isset($page) {{ $page->how_it_works_3_description }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>How to collect Title</label>
            <input type="text" class="form-control" name="how_to_collect_title"
                @isset($page) value="{{ $page->how_to_collect_title }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>How to collect Description</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="how_to_collect_description"> @isset($page) {{ $page->how_to_collect_description }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> How to collect Image
                </button>
            </div>
            <input type="file" name="how_to_collect_image" class="files"
                    data-wrapper="#how_to_collect_image-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="how_to_collect_image-wrapper">
            @if (isset($page) && $page->how_to_collect_image)
                <img src="{{ $page->how_to_collect_image->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>How to collect 1 Title</label>
            <input type="text" class="form-control" name="how_to_collect_1_title"
                @isset($page) value="{{ $page->how_to_collect_1_title }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>How to collect 1 Point Text</label>
            <input type="text" class="form-control" name="how_to_collect_1_point"
                @isset($page) value="{{ $page->how_to_collect_1_point }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>How to collect 2 Title</label>
            <input type="text" class="form-control" name="how_to_collect_2_title"
                @isset($page) value="{{ $page->how_to_collect_2_title }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>How to collect 2 Point Text</label>
            <input type="text" class="form-control" name="how_to_collect_2_point"
                @isset($page) value="{{ $page->how_to_collect_2_point }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>How to collect 3 Title</label>
            <input type="text" class="form-control" name="how_to_collect_3_title"
                @isset($page) value="{{ $page->how_to_collect_3_title }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>How to collect 3 Point Text</label>
            <input type="text" class="form-control" name="how_to_collect_3_point"
                @isset($page) value="{{ $page->how_to_collect_3_point }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>How to collect 4 Title</label>
            <input type="text" class="form-control" name="how_to_collect_4_title"
                @isset($page) value="{{ $page->how_to_collect_4_title }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>How to collect 4 Point Text</label>
            <input type="text" class="form-control" name="how_to_collect_4_point"
                @isset($page) value="{{ $page->how_to_collect_4_point }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>How to collect 5 Title</label>
            <input type="text" class="form-control" name="how_to_collect_5_title"
                @isset($page) value="{{ $page->how_to_collect_5_title }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>How to collect 5 Point Text</label>
            <input type="text" class="form-control" name="how_to_collect_5_point"
                @isset($page) value="{{ $page->how_to_collect_5_point }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>How to collect 6 Title</label>
            <input type="text" class="form-control" name="how_to_collect_6_title"
                @isset($page) value="{{ $page->how_to_collect_6_title }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>How to collect 6 Point Text</label>
            <input type="text" class="form-control" name="how_to_collect_6_point"
                @isset($page) value="{{ $page->how_to_collect_6_point }}" @endif>
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
