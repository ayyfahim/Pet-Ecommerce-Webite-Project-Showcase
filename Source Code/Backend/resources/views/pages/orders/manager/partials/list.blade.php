<table class="table table-bordered">
    <thead class="thead-dark">
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Date</th>
        <th scope="col">Customer</th>
        <th scope="col">Products</th>
        <th scope="col">Qtty</th>
        <th scope="col">Price</th>
        <th scope="col">Total</th>
        <th scope="col">Discount</th>
        <th scope="col">Discount Code</th>
        <th scope="col">Payment Method</th>
        <th scope="col">Tracking Code</th>
        <th scope="col">Payment Status</th>
        <th scope="col">Order Status</th>
        <th scope="col" style="width:200px">Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach($orders as $key=>$order)
        @include('pages.orders.manager.partials.info')
    @endforeach
    </tbody>
</table>
