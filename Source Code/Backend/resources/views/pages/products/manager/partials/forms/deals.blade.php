<div class="tab-pane fade" id="deals" role="tabpanel"
     aria-labelledby="deals-tab">
    @if(!isset($product))
        <h5 class="text-center">
            You'll be able to add deals after you create the product and submit the form.
        </h5>
    @else
        <div class="row mt-2">
            <div class="col-md-6 form-group">
                <label for="fp-date-time">Start Date</label>
                <input type="text" id="fp-date-time"
                       name="deal_from"
                       value="{{$product->getOriginal('deal_from')?$product->deal_from->format('Y-m-d G:i'):''}}"
                       class="form-control flatpickr-date-time"
                       placeholder="YYYY-MM-DD HH:MM"/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label for="fp-date-time">End Date</label>
                <input type="text" id="fp-date-time"
                       name="deal_to"
                       value="{{$product->getOriginal('deal_to')?$product->deal_to->format('Y-m-d G:i'):''}}"
                       class="form-control flatpickr-date-time"
                       placeholder="YYYY-MM-DD HH:MM"/>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label>Show Countdown Timer</label>
                    <select data-minimum-results-for-search="Infinity" class="form-control text-capitalize select2"
                            name="deal_show_counter">
                        @foreach([1,0] as $item)
                            <option @if($product->deal_show_counter == $item) selected
                                    @endif value="{{$item}}">{{$item==1?'Yes':'No'}}</option>
                        @endforeach
                    </select>
                    @include('layouts.admin.partials.form-errors')
                </div>
            </div>
        </div>
        <div class="table-responsive" style="min-height: 250px">
            <table class="table table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Product</th>
                    <th scope="col">Current Price</th>
                    <th scope="col">Discount Type</th>
                    <th scope="col">Discount Amount</th>
                    <th scope="col">Current Quantity</th>
                    <th scope="col">Quantity</th>
                </tr>
                </thead>
                <tbody>
                @forelse($product->variations as $dealKey=>$deal_variation)
                    @php
                        $deal = $product->deals->firstWhere('variation_id',$deal_variation->id);
                    @endphp
                    @include('pages.products.manager.partials.form-items.deal')
                @empty
                    @php
                        $deal = $product->deals->firstWhere('variation_id',null);
                    $dealKey = 0;
                    @endphp
                    @include('pages.products.manager.partials.form-items.deal')
                @endforelse
                </tbody>
            </table>
        </div>
    @endif
</div>
