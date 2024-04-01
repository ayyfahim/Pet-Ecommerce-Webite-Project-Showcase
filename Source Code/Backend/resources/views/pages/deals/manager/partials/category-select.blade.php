<div class="modal fade" id="categoryTreeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryTreeModalLabel">Select Categories</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <select class="tree-select" name="categories[]" multiple>
                        @foreach($childCategories as $childCategory)
                            <option value="{{$childCategory->id}}"
                                    @if($has_category && in_array($childCategory->id,$deal->categories->pluck('id')->toArray())) selected @endif
                                    @if($childCategory->path) data-section="{{$childCategory->path}}" @endif>
                                {{$childCategory->name}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Confirm</button>
                </div>
        </div>
    </div>
</div>
