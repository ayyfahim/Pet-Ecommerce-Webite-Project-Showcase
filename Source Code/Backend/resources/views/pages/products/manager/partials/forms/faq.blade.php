<div class="tab-pane fade" id="faq" role="tabpanel"
     aria-labelledby="main-tab">
    <div class="faq-wrapper">
        @if(isset($product) && $product->info->faq)
            @foreach($product->info->faq as $faqKey=>$faqItem)
                @include('pages.products.manager.partials.form-items.faq')
            @endforeach
        @else
            @include('pages.products.manager.partials.form-items.faq',['faqKey'=>0])
        @endif
    </div>
    <div class="text-right">

        <button type="button" class="btn btn-sm btn-light add-faq-button ajax_without_form"
                data-action="{{route('product.admin.faq.add')}}"
                data-key="{{(isset($product) && $product->info->faq)?sizeof($product->info->faq)-1:0}}"
                data-method="POST"
                data-append="1"
                data-append-view-wrapper=".faq-wrapper">Add FAQ
        </button>
    </div>
</div>
