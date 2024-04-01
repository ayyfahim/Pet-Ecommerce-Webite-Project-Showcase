<div class="tab-pane fade" id="additional" role="tabpanel"
     aria-labelledby="additional-tab">
    <div class="additional-wrapper">
        @if(isset($product) && $product->info->additional)
            @foreach(array_values($product->info->additional) as $additionalKey=>$additionalItem)
                @include('pages.products.manager.partials.form-items.additional')
            @endforeach
        @else
            @include('pages.products.manager.partials.form-items.additional',['additionalKey'=>0])
        @endif
    </div>
    <div class="text-right">

        <button type="button" class="btn btn-sm btn-light add-additional-button ajax_without_form"
                data-action="{{route('product.admin.additional.add')}}"
                data-key="{{(isset($product) && $product->info->additional)?sizeof($product->info->additional)-1:0}}"
                data-method="POST"
                data-append="1"
                data-append-view-wrapper=".additional-wrapper">Add Question
        </button>
    </div>
</div>
