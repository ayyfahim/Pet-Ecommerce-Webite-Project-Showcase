<div class="faq-item">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Question [{{$faqKey+1}}]</label>
                <input class="form-control"
                       value="{{(isset($faqItem) && isset($faqItem['question']))?$faqItem['question']:''}}"
                       name="faq[{{$faqKey}}][question]"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Answer [{{$faqKey+1}}]</label>
                <input class="form-control"
                       value="{{(isset($faqItem) && isset($faqItem['answer']))?$faqItem['answer']:''}}"
                       name="faq[{{$faqKey}}][answer]"/>
                @include('layouts.admin.partials.form-errors')
            </div>
        </div>
    </div>
    <div class="text-right">
        <button type="button" class="btn btn-outline-danger btn-sm mb-2"
                onclick="$(this).parent().parent().remove();$('.add-faq-button').data().key--">
            Delete
        </button>
    </div>
</div>
