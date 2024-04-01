@csrf
<input type="hidden" name="status_id" value="{{isset($product)?$product->status->id:$status_id}}">
<input type="hidden" name="featured" value="{{isset($product)?$product->featured:0}}">
<ul class="nav nav-pills" role="tablist">
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center active" id="first-tab" data-toggle="tab" href="#main"
            aria-controls="first" role="tab" aria-selected="true">
            <i data-feather="info"></i></i><span class="d-none d-sm-block">Baisc Info</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center" id="description-tab" data-toggle="tab" href="#description"
            aria-controls="description" role="tab" aria-selected="false">
            <i data-feather="align-justify"></i></i><span class="d-none d-sm-block">Description</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center" id="media-tab" data-toggle="tab" href="#media"
            aria-controls="media" role="tab" aria-selected="false">
            <i data-feather="image"></i></i><span class="d-none d-sm-block">Media</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center" id="icons-tab" data-toggle="tab" href="#icons"
            aria-controls="icons" role="tab" aria-selected="false">
            <i data-feather="check-circle"></i></i><span class="d-none d-sm-block">Icons</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center" id="attributes-tab" data-toggle="tab" href="#attributes"
            aria-controls="attributes" role="tab" aria-selected="false">
            <i data-feather="archive"></i></i><span class="d-none d-sm-block">Attributes</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center" id="-variationstab" data-toggle="tab" href="#variations"
            aria-controls="variations" role="tab" aria-selected="false">
            <i data-feather="shopping-cart"></i></i><span class="d-none d-sm-block">Variations</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center" id="shipping-tab" data-toggle="tab" href="#shipping"
            aria-controls="shipping" role="tab" aria-selected="false">
            <i data-feather="shopping-bag"></i></i><span class="d-none d-sm-block">Shipping</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center" id="faq-tab" data-toggle="tab" href="#faq" aria-controls="faq"
            role="tab" aria-selected="false">
            <i data-feather="help-circle"></i></i><span class="d-none d-sm-block">FAQ</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center" id="deals-tab" data-toggle="tab" href="#deals"
            aria-controls="deals" role="tab" aria-selected="false">
            <i data-feather="percent"></i></i><span class="d-none d-sm-block">Deals</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center" id="additional-tab" data-toggle="tab" href="#additional"
            aria-controls="additional" role="tab" aria-selected="false">
            <i data-feather="plus-circle"></i></i><span class="d-none d-sm-block">Additional Fields</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center" id="additional-tab" data-toggle="tab" href="#specification"
            aria-controls="specification" role="tab" aria-selected="false">
            <i data-feather="plus-circle"></i></i><span class="d-none d-sm-block">Specifications</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center" id="additional-tab" data-toggle="tab" href="#directions"
            aria-controls="dosage" role="tab" aria-selected="false">
            <i data-feather="plus-circle"></i></i><span class="d-none d-sm-block">Direction</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center" id="additional-tab" data-toggle="tab" href="#ingredients"
            aria-controls="nutrition" role="tab" aria-selected="false">
            <i data-feather="plus-circle"></i></i><span class="d-none d-sm-block">Ingredients</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center" id="second-tab" data-toggle="tab" href="#seo"
            aria-controls="second" role="tab" aria-selected="false">
            <i data-feather="share-2"></i></i><span class="d-none d-sm-block">SEO</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center" id="notes-tab" data-toggle="tab" href="#notes"
            aria-controls="notes" role="tab" aria-selected="false">
            <i data-feather="align-justify"></i></i><span class="d-none d-sm-block">Notes</span>
        </a>
    </li>
</ul>
<div class="tab-content">
    @include('pages.products.manager.partials.forms.main')
    @include('pages.products.manager.partials.forms.description')
    @include('pages.products.manager.partials.forms.media')
    @include('pages.products.manager.partials.forms.icons')
    @include('pages.products.manager.partials.forms.attributes',(isset($product))?['model'=>$product]:[])
    @include('pages.products.manager.partials.forms.variations')
    @include('pages.products.manager.partials.forms.shipping')
    @include('pages.products.manager.partials.forms.faq')
    @include('pages.products.manager.partials.forms.deals')
    @include('pages.products.manager.partials.forms.additional')
    @include('pages.products.manager.partials.forms.specifications')
    @include('pages.products.manager.partials.forms.directions')
    @include('pages.products.manager.partials.forms.ingredients')
    @include('pages.products.manager.partials.forms.seo')
    @include('pages.products.manager.partials.forms.notes')
</div>