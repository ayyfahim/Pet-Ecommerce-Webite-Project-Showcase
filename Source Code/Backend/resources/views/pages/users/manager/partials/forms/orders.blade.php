<div class="tab-pane fade" id="orders" role="tabpanel"
     aria-labelledby="orders-tab">
    <div class="table-responsive">
        @include('pages.orders.manager.partials.list',['orders'=>$user->orders])
    </div>
</div>
