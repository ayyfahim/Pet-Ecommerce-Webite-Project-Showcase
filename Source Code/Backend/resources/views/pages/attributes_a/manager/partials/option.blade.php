<div class="uk-grid">
    @if(isset($option))
        <input type="hidden" name="options[{{$index}}][id]" value="{{$option->id}}">
    @endif
    @foreach($locales as $key=>$locale)
        <div class="uk-width-2-5">
            <label for="d_form_input{{$index}}{{$key}}">Option [{{$locale['name']}}]</label>
            <input type="text"
                   class="md-input @if($index==0 && $key == 'en') to_be_required @endif @if($key=='ar') uk-text-right @endif @if(isset($to_render)) to_render =@endif"
                   @isset($option) value="{{$option->getTranslationWithoutFallback('name',$key)}}" @endisset
                   @if($key=='ar') dir="rtl" @endif name="options[{{$index}}][name][{{$key}}]" id="d_form_input{{$index}}{{$key}}">
        </div>
    @endforeach
    @if($show_delete_button)
        <div class="uk-width-1-5" style="padding-top: 15px;">
            <span class="uk-input-group-addon">
                <a class="delete-option-button"><i class="material-icons md-24">delete</i></a>
            </span>
        </div>
    @endif
</div>