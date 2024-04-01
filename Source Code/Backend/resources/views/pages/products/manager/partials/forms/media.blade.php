<div class="tab-pane fade" id="media" role="tabpanel"
     aria-labelledby="main-tab">
    <div class="gallery-wrapper">
        <div class="col-md-12 text-center">
            <div class="fileinput-button px-4">
                <div class="grid grid-cols-12 gap-2">
                    <button class="btn btn-block default btn-outline-light text-dark"
                            style="height: 170px;line-height: 3;background-image: linear-gradient(to right,rgba(255,255,255,1), rgba(200,200,200,.1));"
                            type="button">
                        <i data-feather="image"></i>
                        Select Photos
                        <br>
                        You can also Drag & Drop
                    </button>
                </div>
                <input type="file" name="gallery[files][]"
                       data-count="{{isset($product)?$product->gallery->count():0}}"
                       data-product="1" data-wrapper="#gallery-preview-wrapper"
                       class="files" multiple
                       accept="image/jpeg, image/png, image/gif,"><br/>
            </div>
            <div class="gallery-images text-left" id="gallery-preview-wrapper">
                @if(isset($product) && $product->gallery->count())
                    @foreach($product->gallery as $mediaKey=>$image)
                        @include('pages.products.manager.partials.form-items.media',['mediaKey'=>$mediaKey])
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
