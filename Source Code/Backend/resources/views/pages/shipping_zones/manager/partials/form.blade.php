@csrf
<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-large-7-10">
        <div class="md-card">
            <div class="md-card-toolbar">
                <h3 class="md-card-toolbar-heading-text">
                    @if(isset($shipping_zone))
                        Edit Shipping Zone
                    @else
                        Add New Shipping Zone
                    @endif
                </h3>
            </div>
            <div class="md-card-content">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1">
                        <label for="shipping_zone_title">Title</label>
                        <input class="md-input"
                               type="text"
                               value="{{isset($shipping_zone)? $shipping_zone->title :''}}"
                               id="shipping_zone_title"
                               name="title"/>
                        @include("layouts.partials.form-errors",['field'=>"title"])
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1">
                        <label for="product_edit_linked_products" class="uk-form-label">
                            Cities
                        </label>
                        <select id="product_edit_linked_products" name="cities[]" multiple data-md-selectize
                                data-md-selectize-bottom>
                            <option value="">Select Cities</option>
                            @foreach($cities as $city)
                                <option
                                    @if(isset($shipping_zone) && $shipping_zone->cities && in_array($city->color,$shipping_zone->cities)) selected
                                    @endif
                                    value="{{$city->color}}">{{$city->title}}</option>
                            @endforeach
                        </select>
                        @include("layouts.partials.form-errors",['field'=>'cities'])
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <label for="shipping_zone_regular">Regular Price</label>
                        <input class="md-input"
                               type="text"
                               value="{{isset($shipping_zone)? $shipping_zone->regular_price :''}}"
                               id="shipping_zone_regular"
                               name="regular_price"/>
                        @include("layouts.partials.form-errors",['field'=>"regular_price"])
                    </div>
                    <div class="uk-width-medium-1-2">
                        <label for="shipping_zone_regular">Express Price</label>
                        <input class="md-input"
                               type="text"
                               value="{{isset($shipping_zone)? $shipping_zone->quick_price :''}}"
                               id="shipping_zone_regular"
                               name="quick_price"/>
                        <span class="uk-form-help-block">Leave empty to be disabled</span>
                        @include("layouts.partials.form-errors",['field'=>"quick_price"])
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
        @if(isset($shipping_zone))
            <button
                data-uk-modal="{target:'#confirmationModal'}"
                data-action="{{route('shipping_zone.admin.destroy',$shipping_zone->id)}}"
                data-append-input="1"
                data-field_name="redirect_to"
                data-field_value="{{ url()->previous() }}"
                data-custom_method='@method('DELETE')'
                class="confirm-action-button md-btn md-btn-danger md-btn-block md-btn-large md-btn-wave-light waves-effect waves-button waves-light mt-20">
                Delete Shipping Zone
            </button>
        @endif
    </div>
</div>
