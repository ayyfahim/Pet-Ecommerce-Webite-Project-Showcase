<div class="row">
    @isset($configuration)
        <input type="hidden"
               name="attributes[configurations][{{$attributeMainKey}}][options][{{$configurationKey}}][id]"
               value="{{$configuration->id}}">
    @endisset
    <div class="col-md-4">
        <div class="form-group">
            <label>Value</label>
            <input class="form-control" @if($attribute->name == 'Colorx') type="color" @endif
            @if(isset($configuration)) value="{{$configuration->value}}" @endif
                   name="attributes[configurations][{{$attributeMainKey}}][options][{{$configurationKey}}][value]">
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
{{--    @if($show_delete_button)--}}
        <div class="col-md-2 pt-2">
            <a class="delete-option-button pointer" @isset($configuration) data-option_id="{{$configuration->id}}" @endif>
                <i class="simple-icon-trash text-danger" style="font-size: 20px;"></i></a>
        </div>
{{--    @endif--}}
</div>
