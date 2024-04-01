<div>
    @php
        $modelAttribute = null;
        if(isset($model)){
        $modelAttribute = $model->attributes()->where('attribute_id',$attribute->id)->first();
        }
    @endphp
    @if($modelAttribute)
        <input type="hidden" name="attributes[configurations][{{$attributeMainKey}}][id]"
               value="{{$modelAttribute->id}}">
    @endif
    <input type="hidden" name="attributes[configurations][{{$attributeMainKey}}][attribute_id]"
           value="{{$attribute->id}}">
    @include('pages.products.manager.partials.form-items.attribute')
</div>
