<div class="tab-pane fade" id="icons" role="tabpanel"
     aria-labelledby="main-tab">
    @foreach($icons as $key=>$icon)
        @include('pages.products.manager.partials.form-items.icon')
    @endforeach
</div>
