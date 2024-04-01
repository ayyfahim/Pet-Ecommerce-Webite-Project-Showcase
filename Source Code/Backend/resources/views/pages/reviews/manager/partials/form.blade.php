@csrf
<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-medium-1-1">
        <label for="review_body">Body</label>
        <textarea class="md-input no_autosize"
                  cols="30" rows="3"
                  id="review_body"
                  name="body">{{isset($review)?$review->body:''}}</textarea>
        @include("layouts.partials.form-errors",['field'=>'body'])
    </div>
    <div class="uk-width-medium-1-1">
        <label for="review_rate">Rate</label>
        <input class="md-input"
               type="number"
               @isset($review) value="{{isset($review)? $review->rate :''}}"
               @endisset
               id="review_rate"
               name="rate"/>
        @include("layouts.partials.form-errors",['field'=>'rate'])
    </div>
</div>