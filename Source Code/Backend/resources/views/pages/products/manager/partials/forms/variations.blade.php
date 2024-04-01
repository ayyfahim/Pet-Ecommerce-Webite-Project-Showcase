<div class="tab-pane fade" id="variations" role="tabpanel"
     aria-labelledby="main-tab">
    @if(!isset($product))
        <h5 class="text-center">
            You'll be able to add variations after you create the product with attributes and submit the form.
        </h5>
    @else
        <div id="accordion" class="variations-items-wrapper">
            @foreach($product->variations as $variationKey=>$variation)
                @include('pages.products.manager.partials.form-items.variation-item')
            @endforeach
        </div>

        <div class="text-right">
            <button type="button" class="btn btn-sm btn-light ajax_without_form"
                    data-action="{{route('product.admin.variation.add',$product->id)}}"
                    data-key="{{(isset($product) && $product->info->faq)?sizeof($product->info->faq):0}}"
                    data-method="POST"
                    data-append="1"
                    data-append-view-wrapper=".variations-items-wrapper"
            >Add Variation
            </button>
        </div>
    @endif
</div>
