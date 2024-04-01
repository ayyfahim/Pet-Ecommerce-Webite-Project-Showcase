<div class="media-item" @isset($image) data-media_id="{{$image->id}}" @endisset>
    @isset($image)
        <input type="hidden" name="gallery[current][{{$mediaKey}}][id]" value="{{$image->id}}">
    @endisset
    <div class="row">
        <div class="col-md-3 text-center mb-2">
            @if(isset($image) && $image)
                <img width="100" src="{{$image->getUrl('thumb')}}" alt="">
            @endif
        </div>
        <div class="col-md-5 text-center pt-4">
            <div class="form-group">
                <input class="form-control"
                       value="{{(isset($image,$image->custom_properties['alt']))?$image->custom_properties['alt']:''}}"
                       name="gallery[current][{{$mediaKey}}][alt]"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-4 text-center mb-2 mt-2">
            <div class="custom-control custom-checkbox d-inline-block mr-4 mt-4">
                <input type="radio" class="custom-control-input" name="main" value="{{$mediaKey}}"
                       @if(
                       (isset($image) && isset($image->custom_properties['main']) && $image->custom_properties['main'])
                       || (!isset($image) && $mediaKey == 0)
                       )
                       checked
                       @endif
                       id="media-main-{{$mediaKey}}">
                <label class="custom-control-label" for="media-main-{{$mediaKey}}">Main</label>
            </div>
            <button type="button" class="btn btn-danger delete-media-btn btn-xs mt-2"
                    @isset($image) data-media_id="{{$image->id}}" @endisset>
                Delete
            </button>
        </div>
    </div>
    <div class="separator mb-5"></div>
</div>
