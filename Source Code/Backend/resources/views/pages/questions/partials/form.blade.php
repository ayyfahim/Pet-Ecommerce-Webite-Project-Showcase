@csrf
<div class="row">
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Question</label>
            <input type="text" class="form-control" name="question"
                   @isset($question) value="{{$question->question}}" @endif>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Answer</label>
            <textarea class="form-control" rows="7" name="answer"
            >{{isset($question)?$question->answer:''}}</textarea>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="form-group">
            <label>Category</label>
            <select class="form-control text-capitalize select2-tagging"
                    name="category" data-placeholder="Start typing...">
                <option value=""></option>
                @foreach($categories as $category)
                    <option @if(isset($question) && $question->category == $category) selected
                            @endif value="{{$category}}">{{$category}}</option>
                @endforeach
            </select>
            <small class="form-text">Start typing to select from current list or add something new to it</small>
            @include('layouts.admin.partials.form-errors')
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-12 text-right mt-1">
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{url()->previous()}}" class="btn btn-outline-secondary">Cancel</a>
    </div>
</div>
