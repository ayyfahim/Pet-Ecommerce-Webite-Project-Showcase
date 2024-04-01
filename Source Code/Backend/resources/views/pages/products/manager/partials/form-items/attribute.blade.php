<div class="row">
    <div class="col-md-2">
        <p>{{$attribute->name}}</p>
    </div>
    <div class="col-md-10">
        <input type="hidden" disabled name="configuration_index"
               value="{{$modelAttribute?sizeof($modelAttribute->configurations):0}}">
        @if($modelAttribute && $modelAttribute->configurations->count())
            @foreach($modelAttribute->configurations as $configurationKey=>$configuration)
                @include('pages.products.manager.partials.form-items.attribute-configurable',['show_delete_button'=>$configurationKey>0,'show_reset_button'=>$configurationKey==0,'index'=>$attributeMainKey])
            @endforeach
        @else
            @include('pages.products.manager.partials.form-items.attribute-configurable',['configurationKey'=>0,'show_delete_button'=>false,'show_reset_button'=>true])
        @endif
        <div class="text-left add-option-container">
            <button class="btn btn-danger mb-2 btn-sm"
                    onclick="$(this).parent().parent().parent().parent().remove();$('input[name='/'index'/']').data().key--"
                    type="button">
                Delete {{$attribute->name}} Attribute
            </button>
            <button class="btn btn-light add-option-button mb-2 btn-sm"
                    data-action="{{route('attribute.admin.getProductOption')}}"
                    data-attribute_id="{{$attribute->id}}"
                    data-attribute_key="{{$attributeMainKey}}"
                    type="button">
                <i class="simple-icon-plus"></i>
                Add Option
            </button>
        </div>
    </div>
</div>
<div class="separator mb-5"></div>
