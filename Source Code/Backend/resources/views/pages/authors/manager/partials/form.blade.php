@csrf

<div class="row">
    <div class="col-12 ">
        <div class="form-group">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label>Author Name</label>
                        <input type="text" class="form-control" name="name"
                            @if (isset($author) && isset($author->name)) value="{{ $author->name }}" @endif>
                        @include('layouts.admin.partials.form-errors')
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label>Author Title</label>
                        <input type="text" class="form-control" name="title"
                            @if (isset($author) && isset($author->title)) value="{{ $author->title }}" @endif>
                        @include('layouts.admin.partials.form-errors')
                    </div>
                </div>

                <div class="col-12 col-md-12">
                    <div class="form-group">
                        <label>Author Bio</label>
                        <textarea type="text" rows="3" class="form-control" name="bio">@if (isset($author) && isset($author->bio)){{ $author->bio }}@endif</textarea>
                        @include('layouts.admin.partials.form-errors')
                    </div>
                </div>
                <div class="col-12">
                    <div class="fileinput-button mt-1">
                        <div class="grid grid-cols-12 gap-2">
                            <button type="button" class="btn btn-light btn-block">
                                <i data-feather="image"></i> Select Author Image
                            </button>
                        </div>
                        <input type="file" name="avatar" class="files" data-wrapper="#avatar-wrapper"
                            accept="image/*"><br />
                        @include('layouts.admin.partials.form-errors')
                    </div>
                    <div class="images-preview" id="avatar-wrapper">
                        @if (isset($author) && $author->avatar)
                            <img src="{{ $author->avatar->getUrl() }}">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 text-right mt-1">
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Cancel</a>
    </div>
</div>
