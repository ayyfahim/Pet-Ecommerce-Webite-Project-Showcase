@csrf
<div class="uk-grid" data-uk-grid-margin>
    @foreach($locales as $key=>$locale)
        <div class="uk-width-medium-1-1" data-locale="{{$key}}">
            <label for="event_title">Title [{{$locale['name']}}]</label>
            <input class="md-input"
                   type="text"
                   @isset($event) value="{{isset($event)? $event->getTranslationWithoutFallback('title',$key) :''}}"
                   @endisset
                   id="event_title"
                   name="title[{{$key}}]"/>
            @include("layouts.partials.form-errors",['field'=>"title.$key"])
        </div>
    @endforeach
</div>
<div class="uk-grid" data-uk-grid-margin>
    @foreach($locales as $key=>$locale)
        <div class="uk-width-medium-1-1" data-locale="{{$key}}">
            <label for="event_body">Body [{{$locale['name']}}]</label>
            <input class="md-input"
                   type="text"
                   @isset($event) value="{{isset($event)? $event->getTranslationWithoutFallback('body',$key) :''}}"
                   @endisset
                   id="event_body"
                   name="body[{{$key}}]"/>
            @include("layouts.partials.form-errors",['field'=>"body.$key"])
        </div>
    @endforeach
</div>
<div class="uk-grid" data-uk-grid-margin>
    @foreach($locales as $key=>$locale)
        <div class="uk-width-medium-1-1" data-locale="{{$key}}">
            <label for="event_link">Link [{{$locale['name']}}]</label>
            <input class="md-input"
                   type="text"
                   @isset($event) value="{{isset($event)? $event->getTranslationWithoutFallback('link',$key) :''}}"
                   @endisset
                   id="event_link"
                   name="link[{{$key}}]"/>
            @include("layouts.partials.form-errors",['field'=>"link.$key"])
        </div>
    @endforeach
</div>