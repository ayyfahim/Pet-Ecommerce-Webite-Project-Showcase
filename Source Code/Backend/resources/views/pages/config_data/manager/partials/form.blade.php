<div class="col-12 {{isset($config->info['class'])?$config->info['class']:'col-md-12'}}">
    <input type="hidden" name="config[{{$key}}][id]" value="{{$config->id}}">
    @if($config->type == 'file')
        <div class="fileinput-button mt-1">
            <div class="grid grid-cols-12 gap-2">
                <button type="button"
                        class="btn btn-light btn-block">
                    <i data-feather="image"></i> {{$config->label}}
                </button>
            </div>
            <input type="file" name="config[{{$key}}][cover]" class="files"
                   data-wrapper="#image-wrapper-{{$key}}"
                   accept="image/*"><br/>
            @include('layouts.admin.partials.form-errors')
        </div>
        <div class="images-preview"
             id="image-wrapper-{{$key}}">
            @if($config->cover)
                <img src="{{$config->cover->getUrl()}}">
            @endif
        </div>
    @else


        <div class="form-group">
            <label>{{$config->label}}</label>
            @if($config->type =='textarea')
                <textarea type="text"
                          class="form-control {{!in_array($config->group,['integrations']) && !isset($config->info['hint'])?'tinymce-text':''}}"
                          name="config[{{$key}}][value]" rows="20">{{$config->value}}</textarea>
            @else
                <input type="text" class="form-control @if($config->type =='tags') inputtags @endif"
                       name="config[{{$key}}][value]"
                       value="{{$config->value}}">
            @endif
            @if(isset($config->info['hint']))
                <small class="form-text">{{$config->info['hint']}}</small>
            @endif
            @include('layouts.admin.partials.form-errors')
        </div>
    @endif
</div>
