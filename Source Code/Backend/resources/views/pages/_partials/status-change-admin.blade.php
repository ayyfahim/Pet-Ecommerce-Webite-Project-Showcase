<div class="cards-collection new-profile-content mt-4">
    <div class="card">
        <div class="card-body p-3 bg-new-gray">
            <div class="card-title">Change Status</div>
            <form class="d-flex align-items-center justify-content-between ajax"
                  action="{{$route}}" method="POST">
                @csrf
                @method('PATCH')
                <div class="col-12 col-md-6">
                    <div class="form-float-label-group">
                        <select class="selectize-select"
                                id="formInput_sectors"
                                name="status_id"
                                tabindex="1"
                                placeholder="Status"
                                onclick="this.setAttribute('value', this.value);"
                                value="">
                            <option value=""></option>
                            @foreach($statuses as $status)
                                <option @if($status->id == $current_status->id) selected
                                        @endif value="{{$status->id}}">{{$status->title}}</option>
                            @endforeach
                        </select>
                        @include('layouts.partials.form-errors')
                        <label for="formInput_sectors">Status</label>
                    </div>
                </div>
                <div class="col-12 col-md-5 d-flex justify-content-end">
                    <button class="btn btn-danger w-100 m-0 border-0" type="submit">
                        Apply
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>