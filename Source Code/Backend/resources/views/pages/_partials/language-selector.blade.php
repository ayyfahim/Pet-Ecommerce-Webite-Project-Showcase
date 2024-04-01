<select class="language-selector" data-md-selectize>
    @foreach($locales as $key=>$locale)
        <option value="{{$key}}">{{$locale['name']}}</option>
    @endforeach
</select>