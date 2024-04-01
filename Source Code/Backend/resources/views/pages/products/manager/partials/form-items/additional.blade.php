<div class="additional-item">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Question [{{$additionalKey+1}}]</label>
                <input class="form-control"
                       value="{{(isset($additionalItem) && isset($additionalItem['question']))?$additionalItem['question']:''}}"
                       name="additional[{{$additionalKey}}][question]"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Answers [{{$additionalKey+1}}]</label>
                <textarea class="form-control" rows="7"
                          name="additional[{{$additionalKey}}][answer]">{{(isset($additionalItem) && isset($additionalItem['answer']))?$additionalItem['answer']:''}}</textarea>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
    </div>
    <div class="text-right">
        <button type="button" class="btn btn-outline-danger btn-sm mb-2"
                onclick="$(this).parent().parent().remove();$('.add-additional-button').data().key--">
            Delete
        </button>
    </div>
</div>
