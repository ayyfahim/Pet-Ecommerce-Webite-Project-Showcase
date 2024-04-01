@php
    $has_categories = isset($attribute) && $attribute->categories()->count();
@endphp
@csrf
<input type="hidden" name="configured" value="{{isset($attribute)?$attribute->configured:0}}">
<input type="hidden" name="compare" value="{{isset($attribute)?$attribute->compare:1}}">
<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-large-7-10">
        <div class="md-card">
            <div class="md-card-toolbar">
                <h3 class="md-card-toolbar-heading-text">
                    @if(isset($attribute))
                        Edit Attribute
                    @else
                        Add New Attribute
                    @endif
                </h3>
            </div>
            <div class="md-card-content">

                <div class="uk-grid" data-uk-grid-margin>
                    @foreach($locales as $key=>$locale)
                        <div class="uk-width-medium-1-2">
                            <label for="attribute_title">Name [{{$locale['name']}}]</label>
                            <input class="md-input"
                                   type="text"
                                   @isset($attribute) value="{{$attribute->getTranslationWithoutFallback('name',$key)}}"
                                   @endisset
                                   id="attribute_title"
                                   name="name[{{$key}}]"/>
                            @include("layouts.partials.form-errors",['field'=>"name.$key"])
                        </div>
                    @endforeach
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1">
                        <label for="product_edit_type_control" class="uk-form-label">
                            Type
                        </label>
                        <select id="product_edit_type_control" name="type" data-md-selectize class="text-capitalize"
                                data-md-selectize-bottom>
                            <option value="">Select Attribute Type</option>
                            @foreach($types as $type)
                                <option class="text-capitalize"
                                        @if(isset($attribute) && $attribute->type == $type['value']) selected
                                        @endif
                                        value="{{$type['value']}}">{{$type['label']}}</option>
                            @endforeach
                        </select>
                        @include("layouts.partials.form-errors",['field'=>'type'])
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1">
                        <label class="uk-form-label">
                            Categories
                        </label>
                        <div class="categories-text">
                            @if($has_categories)
                                @foreach($attribute->categories as $category)
                                    <div class='category-value'>{{$category->name}}</div>
                                @endforeach
                            @endif
                        </div>
                        <div class="uk-margin-top uk-margin-bottom">
                            <button
                                data-uk-modal="{target:'#categoryTreeModal'}"
                                type="button" class="md-btn md-btn-primary">
                                @if($has_categories)
                                    Change Categories
                                @else
                                    Select Categories
                                @endif
                            </button>
                        </div>
                        @include('pages.attributes.manager.partials.category-select')
                        @include("layouts.partials.form-errors",['field'=>'categories'])
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-medium-2-3">
                <button
                    class="md-btn md-btn-primary md-btn-block md-btn-large md-btn-wave-light waves-effect waves-button waves-light"
                    type="submit">
                    {{$submit_button}}
                </button>
            </div>
            <div class="uk-width-medium-1-3">
                <a href="{{url()->previous()}}"
                   class="md-btn md-btn-block md-btn-large md-btn-wave-light waves-effect waves-button waves-light">
                    Cancel
                </a>
            </div>
        </div>

    </div>
    <div class="uk-width-large-3-10">
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-float-right">
                    <input type="checkbox"
                           @if(isset($attribute)&& $attribute->configured) checked @endif
                           data-switchery
                           data-input_name="configured"
                           data-value="1"
                           data-reversed_value="0"
                           class="statusChange"/>
                </div>
                <label class="uk-display-block uk-margin-small-top">Use in Cart</label>
            </div>
        </div>
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-float-right">
                    <input type="checkbox"
                           @if(!(isset($attribute) && !$attribute->compare)) checked @endif
                           data-switchery
                           data-input_name="compare"
                           data-value="1"
                           data-reversed_value="0"
                           class="statusChange"/>
                </div>
                <label class="uk-display-block uk-margin-small-top">Use in Compare</label>
            </div>
        </div>
        @if(isset($attribute))
            @if($attribute->type == 'dropdown')
                <a
                    href="{{route('attribute.admin.option.index',$attribute->id)}}"
                    class="md-btn md-btn-info md-btn-block md-btn-large md-btn-wave-light waves-effect waves-button waves-light mt-20">
                    Edit Attribute Options
                </a>
            @endif
            <button
                data-uk-modal="{target:'#confirmationModal'}"
                data-action="{{route('attribute.admin.destroy',$attribute->id)}}"
                data-append-input="1"
                data-field_name="redirect_to"
                data-field_value="{{ url()->previous() }}"
                data-custom_method='@method('DELETE')'
                class="confirm-action-button md-btn md-btn-danger md-btn-block md-btn-large md-btn-wave-light waves-effect waves-button waves-light mt-20">
                Delete Attribute
            </button>
        @endif
    </div>
</div>
