@if (flash()->message)
    @php
        $str = \Illuminate\Support\Str::after(flash()->class, '-');
        $title = $str != 'danger' ? $str : 'error';
    @endphp
    <div class="alert alert-success rounded" role="alert">
       <span>{{flash()->message}}</span>
    </div>
    <script>
        $("div.alert").delay(4000).fadeOut();
    </script>
@else
    <div class="alert rounded" role="alert">
        <span>{{flash()->message}}</span>
    </div>
@endif
