@csrf


<div class="row">
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Banner Section Header</label>
            <input type="text" class="form-control" name="banner_section_header"
                @isset($page) value="{{ $page->banner_section_header }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    {{-- <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Banner Section Header Formatted Text</label>
            <input type="text" class="form-control" name="banner_section_header_formatted_text" @isset($page) value="{{ $page->banner_section_header_formatted_text }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div> --}}
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
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> Banner Section Image Mobile
                </button>
            </div>
            <input type="file" name="banner_section_mobile_image" class="files"
                    data-wrapper="#banner_section_mobile_image-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="banner_section_mobile_image-wrapper">
            @if (isset($page) && $page->banner_section_mobile_image)
                <img src="{{ $page->banner_section_mobile_image->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Banner Button 1 Text</label>
            <input type="text" class="form-control" name="banner_button_1_text" @isset($page) value="{{ $page->banner_button_1_text }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Banner Button 1 Link</label>
            <input type="text" class="form-control" name="banner_button_1_link" @isset($page) value="{{ $page->banner_button_1_link }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Banner Button 2 Text</label>
            <input type="text" class="form-control" name="banner_button_2_text" @isset($page) value="{{ $page->banner_button_2_text }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Banner Button 2 Link</label>
            <input type="text" class="form-control" name="banner_button_2_link" @isset($page) value="{{ $page->banner_button_2_link }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Why Buy From Us 1 Text</label>
            <input type="text" class="form-control" name="sub_banner_1_text" @isset($page) value="{{ $page->sub_banner_1_text }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> Why Buy From Us 1 Icon
                </button>
            </div>
            <input type="file" name="sub_banner_1_icon" class="files"
                    data-wrapper="#sub_banner_1_icon-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="sub_banner_1_icon-wrapper">
            @if (isset($page) && $page->sub_banner_1_icon)
                <img src="{{ $page->sub_banner_1_icon->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Why Buy From Us 2 Text</label>
            <input type="text" class="form-control" name="sub_banner_2_text" @isset($page) value="{{ $page->sub_banner_2_text }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> Why Buy From Us 2 Icon
                </button>
            </div>
            <input type="file" name="sub_banner_2_icon" class="files"
                    data-wrapper="#sub_banner_2_icon-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="sub_banner_2_icon-wrapper">
            @if (isset($page) && $page->sub_banner_2_icon)
                <img src="{{ $page->sub_banner_2_icon->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Why Buy From Us 3 Text</label>
            <input type="text" class="form-control" name="sub_banner_3_text" @isset($page) value="{{ $page->sub_banner_3_text }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> Why Buy From Us 3 Icon
                </button>
            </div>
            <input type="file" name="sub_banner_3_icon" class="files"
                    data-wrapper="#sub_banner_3_icon-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="sub_banner_3_icon-wrapper">
            @if (isset($page) && $page->sub_banner_3_icon)
                <img src="{{ $page->sub_banner_3_icon->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Why Buy From Us 4 Text</label>
            <input type="text" class="form-control" name="sub_banner_4_text" @isset($page) value="{{ $page->sub_banner_4_text }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> Why Buy From Us 4 Icon
                </button>
            </div>
            <input type="file" name="sub_banner_4_icon" class="files"
                    data-wrapper="#sub_banner_4_icon-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="sub_banner_4_icon-wrapper">
            @if (isset($page) && $page->sub_banner_4_icon)
                <img src="{{ $page->sub_banner_4_icon->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Concern Section Header</label>
            <input type="text" class="form-control" name="concern_section_header" @isset($page) value="{{ $page->concern_section_header }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Concern Section Description</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="concern_section_description"> @isset($page) {{ $page->concern_section_description }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Top Selling Section Header</label>
            <input type="text" class="form-control" name="top_selling_section_header" @isset($page) value="{{ $page->top_selling_section_header }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Top Selling Section Description</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="top_selling_section_description"> @isset($page) {{ $page->top_selling_section_description }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Quality Ingredients Section Header</label>
            <input type="text" class="form-control" name="quality_ingredients_section_header" @isset($page) value="{{ $page->quality_ingredients_section_header }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Quality Ingredients Section Description</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="quality_ingredients_section_description"> @isset($page) {{ $page->quality_ingredients_section_description }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> Ingredient Section Main Image
                </button>
            </div>
            <input type="file" name="ingredient_section_main_image" class="files"
                    data-wrapper="#ingredient_section_main_image-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="ingredient_section_main_image-wrapper">
            @if (isset($page) && $page->ingredient_section_main_image)
                <img src="{{ $page->ingredient_section_main_image->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Ingr 1 Header</label>
            <input type="text" class="form-control" name="ingr_1_header" @isset($page) value="{{ $page->ingr_1_header }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Ingr 1 Description</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="ingr_1_description"> @isset($page) {{ $page->ingr_1_description }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> Ingr 1 Image
                </button>
            </div>
            <input type="file" name="ingr_1_image" class="files"
                    data-wrapper="#ingr_1_image-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="ingr_1_image-wrapper">
            @if (isset($page) && $page->ingr_1_image)
                <img src="{{ $page->ingr_1_image->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Ingr 2 Header</label>
            <input type="text" class="form-control" name="ingr_2_header" @isset($page) value="{{ $page->ingr_2_header }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Ingr 2 Description</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="ingr_2_description"> @isset($page) {{ $page->ingr_2_description }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> Ingr 2 Image
                </button>
            </div>
            <input type="file" name="ingr_2_image" class="files"
                    data-wrapper="#ingr_2_image-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="ingr_2_image-wrapper">
            @if (isset($page) && $page->ingr_2_image)
                <img src="{{ $page->ingr_2_image->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Ingr 3 Header</label>
            <input type="text" class="form-control" name="ingr_3_header" @isset($page) value="{{ $page->ingr_3_header }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Ingr 3 Description</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="ingr_3_description"> @isset($page) {{ $page->ingr_3_description }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> Ingr 3 Image
                </button>
            </div>
            <input type="file" name="ingr_3_image" class="files"
                    data-wrapper="#ingr_3_image-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="ingr_3_image-wrapper">
            @if (isset($page) && $page->ingr_3_image)
                <img src="{{ $page->ingr_3_image->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Ingr 4 Header</label>
            <input type="text" class="form-control" name="ingr_4_header" @isset($page) value="{{ $page->ingr_4_header }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Ingr 4 Description</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="ingr_4_description"> @isset($page) {{ $page->ingr_4_description }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> Ingr 4 Image
                </button>
            </div>
            <input type="file" name="ingr_4_image" class="files"
                    data-wrapper="#ingr_4_image-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="ingr_4_image-wrapper">
            @if (isset($page) && $page->ingr_4_image)
                <img src="{{ $page->ingr_4_image->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Ingr 5 Header</label>
            <input type="text" class="form-control" name="ingr_5_header" @isset($page) value="{{ $page->ingr_5_header }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Ingr 5 Description</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="ingr_5_description"> @isset($page) {{ $page->ingr_5_description }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> Ingr 5 Image
                </button>
            </div>
            <input type="file" name="ingr_5_image" class="files"
                    data-wrapper="#ingr_5_image-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="ingr_5_image-wrapper">
            @if (isset($page) && $page->ingr_5_image)
                <img src="{{ $page->ingr_5_image->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Ingr 6 Header</label>
            <input type="text" class="form-control" name="ingr_6_header" @isset($page) value="{{ $page->ingr_6_header }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Ingr 6 Description</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="ingr_6_description"> @isset($page) {{ $page->ingr_6_description }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> Ingr 6 Image
                </button>
            </div>
            <input type="file" name="ingr_6_image" class="files"
                    data-wrapper="#ingr_6_image-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="ingr_6_image-wrapper">
            @if (isset($page) && $page->ingr_6_image)
                <img src="{{ $page->ingr_6_image->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Why Us Section Header</label>
            <input type="text" class="form-control" name="why_us_section_header" @isset($page) value="{{ $page->why_us_section_header }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Why Us Section Description</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="why_us_section_description"> @isset($page) {{ $page->why_us_section_description }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> Why Us Section Image
                </button>
            </div>
            <input type="file" name="why_us_section_image" class="files"
                    data-wrapper="#why_us_section_image-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="why_us_section_image-wrapper">
            @if (isset($page) && $page->why_us_section_image)
                <img src="{{ $page->why_us_section_image->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Why Us 1 Header</label>
            <input type="text" class="form-control" name="why_us_1_header" @isset($page) value="{{ $page->why_us_1_header }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Why Us 1 Text</label>
            <input type="text" class="form-control" name="why_us_1_text" @isset($page) value="{{ $page->why_us_1_text }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> Why Us 1 Icon
                </button>
            </div>
            <input type="file" name="why_us_1_icon" class="files"
                    data-wrapper="#why_us_1_icon-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="why_us_1_icon-wrapper">
            @if (isset($page) && $page->why_us_1_icon)
                <img src="{{ $page->why_us_1_icon->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Why Us 2 Header</label>
            <input type="text" class="form-control" name="why_us_2_header" @isset($page) value="{{ $page->why_us_2_header }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Why Us 2 Text</label>
            <input type="text" class="form-control" name="why_us_2_text" @isset($page) value="{{ $page->why_us_2_text }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> Why Us 2 Icon
                </button>
            </div>
            <input type="file" name="why_us_2_icon" class="files"
                    data-wrapper="#why_us_2_icon-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="why_us_2_icon-wrapper">
            @if (isset($page) && $page->why_us_2_icon)
                <img src="{{ $page->why_us_2_icon->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Why Us 3 Header</label>
            <input type="text" class="form-control" name="why_us_3_header" @isset($page) value="{{ $page->why_us_3_header }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Why Us 3 Text</label>
            <input type="text" class="form-control" name="why_us_3_text" @isset($page) value="{{ $page->why_us_3_text }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> Why Us 3 Icon
                </button>
            </div>
            <input type="file" name="why_us_3_icon" class="files"
                    data-wrapper="#why_us_3_icon-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="why_us_3_icon-wrapper">
            @if (isset($page) && $page->why_us_3_icon)
                <img src="{{ $page->why_us_3_icon->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Why Us 4 Header</label>
            <input type="text" class="form-control" name="why_us_4_header" @isset($page) value="{{ $page->why_us_4_header }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Why Us 4 Text</label>
            <input type="text" class="form-control" name="why_us_4_text" @isset($page) value="{{ $page->why_us_4_text }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> Why Us 4 Icon
                </button>
            </div>
            <input type="file" name="why_us_4_icon" class="files"
                    data-wrapper="#why_us_4_icon-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="why_us_4_icon-wrapper">
            @if (isset($page) && $page->why_us_4_icon)
                <img src="{{ $page->why_us_4_icon->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Why Us 5 Header</label>
            <input type="text" class="form-control" name="why_us_5_header" @isset($page) value="{{ $page->why_us_5_header }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Why Us 5 Text</label>
            <input type="text" class="form-control" name="why_us_5_text" @isset($page) value="{{ $page->why_us_5_text }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> Why Us 5 Icon
                </button>
            </div>
            <input type="file" name="why_us_5_icon" class="files"
                    data-wrapper="#why_us_5_icon-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="why_us_5_icon-wrapper">
            @if (isset($page) && $page->why_us_5_icon)
                <img src="{{ $page->why_us_5_icon->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Why Us 6 Header</label>
            <input type="text" class="form-control" name="why_us_6_header" @isset($page) value="{{ $page->why_us_6_header }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Why Us 6 Text</label>
            <input type="text" class="form-control" name="why_us_6_text" @isset($page) value="{{ $page->why_us_6_text }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> Why Us 6 Icon
                </button>
            </div>
            <input type="file" name="why_us_6_icon" class="files"
                    data-wrapper="#why_us_6_icon-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="why_us_6_icon-wrapper">
            @if (isset($page) && $page->why_us_6_icon)
                <img src="{{ $page->why_us_6_icon->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Review Section Header</label>
            <input type="text" class="form-control" name="review_section_header" @isset($page) value="{{ $page->review_section_header }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Review Section Description</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="review_section_description"> @isset($page) {{ $page->review_section_description }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Review 1 Header</label>
            <input type="text" class="form-control" name="review_1_header" @isset($page) value="{{ $page->review_1_header }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Review 1 Author Name</label>
            <input type="text" class="form-control" name="review_1_author_name" @isset($page) value="{{ $page->review_1_author_name }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Review 1 Star (1-5)</label>
            <input type="number" class="form-control" name="review_1_star" @isset($page) value="{{ $page->review_1_star }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Review 1 Description</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="review_1_description"> @isset($page) {{ $page->review_1_description }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> Review 1 Image
                </button>
            </div>
            <input type="file" name="review_1_image" class="files"
                    data-wrapper="#review_1_image-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="review_1_image-wrapper">
            @if (isset($page) && $page->review_1_image)
                <img src="{{ $page->review_1_image->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Review 2 Header</label>
            <input type="text" class="form-control" name="review_2_header" @isset($page) value="{{ $page->review_2_header }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Review 2 Author Name</label>
            <input type="text" class="form-control" name="review_2_author_name" @isset($page) value="{{ $page->review_2_author_name }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Review 2 Star (1-5)</label>
            <input type="number" class="form-control" name="review_2_star" @isset($page) value="{{ $page->review_2_star }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Review 2 Description</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="review_2_description"> @isset($page) {{ $page->review_2_description }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> Review 2 Image
                </button>
            </div>
            <input type="file" name="review_2_image" class="files"
                    data-wrapper="#review_2_image-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="review_2_image-wrapper">
            @if (isset($page) && $page->review_2_image)
                <img src="{{ $page->review_2_image->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Review 3 Header</label>
            <input type="text" class="form-control" name="review_3_header" @isset($page) value="{{ $page->review_3_header }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Review 3 Author Name</label>
            <input type="text" class="form-control" name="review_3_author_name" @isset($page) value="{{ $page->review_3_author_name }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Review 3 Star (1-5)</label>
            <input type="number" class="form-control" name="review_3_star" @isset($page) value="{{ $page->review_3_star }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Review 3 Description</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="review_3_description"> @isset($page) {{ $page->review_3_description }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> Review 3 Image
                </button>
            </div>
            <input type="file" name="review_3_image" class="files"
                    data-wrapper="#review_3_image-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="review_3_image-wrapper">
            @if (isset($page) && $page->review_3_image)
                <img src="{{ $page->review_3_image->getUrl() }}">
            @endif
        </div>
    </div>
     <div class="col-12 col-md-12">
        <div class="form-group">
            <label>How It Works Section Header</label>
            <input type="text" class="form-control" name="how_it_works_section_header" @isset($page) value="{{ $page->how_it_works_section_header }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>How It Works Section Description</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="how_it_works_section_description"> @isset($page) {{ $page->how_it_works_section_description }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> How It Works Section Main Image
                </button>
            </div>
            <input type="file" name="how_it_works_section_main_image" class="files"
                    data-wrapper="#how_it_works_section_main_image-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="how_it_works_section_main_image-wrapper">
            @if (isset($page) && $page->how_it_works_section_main_image)
                <img src="{{ $page->how_it_works_section_main_image->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> How It Works Section Bubble Image
                </button>
            </div>
            <input type="file" name="how_it_works_section_bubble_image" class="files"
                    data-wrapper="#how_it_works_section_bubble_image-wrapper"
                    accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview" id="how_it_works_section_bubble_image-wrapper">
            @if (isset($page) && $page->how_it_works_section_bubble_image)
                <img src="{{ $page->how_it_works_section_bubble_image->getUrl() }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>How It Works 1 Header</label>
            <input type="text" class="form-control" name="how_it_works_1_header" @isset($page) value="{{ $page->how_it_works_1_header }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>How It Works 1 Description</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="how_it_works_1_description"> @isset($page) {{ $page->how_it_works_1_description }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>How It Works 2 Header</label>
            <input type="text" class="form-control" name="how_it_works_2_header" @isset($page) value="{{ $page->how_it_works_2_header }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>How It Works 2 Description</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="how_it_works_2_description"> @isset($page) {{ $page->how_it_works_2_description }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>How It Works 3 Header</label>
            <input type="text" class="form-control" name="how_it_works_3_header" @isset($page) value="{{ $page->how_it_works_3_header }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>How It Works 3 Description</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="how_it_works_3_description"> @isset($page) {{ $page->how_it_works_3_description }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Blogs Section Header</label>
            <input type="text" class="form-control" name="blogs_section_header" @isset($page) value="{{ $page->blogs_section_header }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Blogs Section Desctiption</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="blogs_section_desctiption"> @isset($page) {{ $page->blogs_section_desctiption }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
     <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Instagram Section Text</label>
            <input type="text" class="form-control" name="instagram_section_text" @isset($page) value="{{ $page->instagram_section_text }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
     <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Instagram Section Username</label>
            <input type="text" class="form-control" name="instagram_section_username" @isset($page) value="{{ $page->instagram_section_username }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
     <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Instagram Section Profile Link</label>
            <input type="text" class="form-control" name="instagram_section_profile_link" @isset($page) value="{{ $page->instagram_section_profile_link }}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Disclaimer Text</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="disclaimer_text"> @isset($page) {{ $page->disclaimer_text }} @endif</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>


    {{-- 
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Content</label>
            <textarea type="text" style="height:400px;" class="form-control"
                        name="content"> @isset($article) {{ $article->content }} @endif</textarea>
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
            @if (isset($article) && $article->avatar)
                <img src="{{ $article->avatar->getUrl() }}">
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
            @if (isset($article) && $article->cover)
                <img src="{{ $article->cover->getUrl() }}">
            @endif
        </div>
    </div>
     --}}
</div>

<div class="row">
    <div class="col-12 text-right mt-1">
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Cancel</a>
    </div>
</div>
