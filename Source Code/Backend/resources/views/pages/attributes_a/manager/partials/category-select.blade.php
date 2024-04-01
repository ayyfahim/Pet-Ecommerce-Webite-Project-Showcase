<div class="uk-modal" id="categoryTreeModal">
    <div class="uk-modal-dialog">
        <div class="uk-modal-header">
            <h3 class="uk-modal-title">Select Category</h3>
        </div>
        <select class="tree-select" name="categories[]" multiple>
            @foreach($childCategories as $childCategory)
                <option value="{{$childCategory->id}}"
                        {{isset($attribute)&&$attribute->categories->pluck('id')->contains($childCategory->id)? 'selected':''}}
                        @if($childCategory->path) data-section="{{$childCategory->path}}" @endif>
                    {{$childCategory->name}}
                </option>
            @endforeach
        </select>
        <div class="uk-modal-footer uk-text-right">
            <button type="button" class="md-btn md-btn-flat uk-modal-close">
                @lang('common.confirm')</button>
        </div>
    </div>
</div>