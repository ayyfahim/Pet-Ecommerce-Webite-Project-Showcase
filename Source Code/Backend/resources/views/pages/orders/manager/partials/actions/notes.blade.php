<div class="card mb-2">
    <div class="card-body">
        <h5 class="card-title">Notes</h5>
        <div class="notes-wrapper" style="max-height: 200px;overflow-y: scroll">
            @foreach($order->order_notes as $order_note)
                <div class="border p-2 mb-2">
                    <div class="mb-2">
                        {{$order_note->notes}}
                    </div>
                    <div class="text-right">
                        <small>{{$order_note->user->full_name}}</small>
                        <br>
                        <small>{{$order_note->created_at}}</small>
                    </div>
                </div>
            @endforeach
        </div>
        <form action="{{route('order_note.admin.store')}}" method="post" class="ajax"
              id="shipOrder">
            @csrf
            <input type="hidden" name="order_id" value="{{$order->id}}">
            <div class="form-row">
                <div class="col-12 col-md-12">
                    <div class="form-group">
                        <label>Notes</label>
                        <textarea class="form-control" name="notes"></textarea>

                        @include('layouts.admin.partials.form-errors')
                    </div>
                </div>
            </div>
            <div class="mt-2">
                <button type="submit" class="btn btn-block btn-primary">Add Note</button>
            </div>
        </form>
    </div>
</div>
