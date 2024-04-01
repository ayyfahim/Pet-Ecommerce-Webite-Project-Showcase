<div class="md-card options-card @if(!(isset($attribute) && $attribute->type=='dropdown')) d-none @endif">
    <div class="md-card-toolbar">
        <div class="md-card-toolbar-actions" style="padding-top: 12px;">
            <div class="uk-float-right">
                <button class="md-btn md-btn-mini md-btn-icon add-option-button"
                        data-action="{{route('attribute.admin.getAttributeOption')}}"
                        type="button">
                    <i class="uk-icon-plus"></i>
                    Add Option
                </button>
            </div>
        </div>
        <h3 class="md-card-toolbar-heading-text">
            Attribute Options
        </h3>
    </div>
    <div class="md-card-content options-wrapper">
        <input type="hidden" disabled name="index" value="{{isset($attribute)?sizeof($attribute->options):0}}">
        @if(isset($attribute) && sizeof($attribute->options))
            @foreach($attribute->options as $key=>$option)
                @include('pages.attributes.manager.partials.option',['show_delete_button'=>$key>0,'index'=>$key])
            @endforeach
        @else
            @include('pages.attributes.manager.partials.option',['show_delete_button'=>false,'index'=>0])
        @endif
    </div>
</div>
