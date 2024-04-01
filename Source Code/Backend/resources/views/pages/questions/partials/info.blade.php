<tr>
    <td>{{$key+1}}</td>
    <td>{{$question->question}}</td>
    <td>{{$question->answer}}</td>
    <td>{{$question->category}}</td>
    <td style="min-width: 150px;">
        <a href="{{route('question.admin.edit',$question->id)}}"
           class="btn rounded-circle btn-icon btn-sm btn-info">
            <i data-feather="edit-2"></i>
        </a>
        <a
            class="btn rounded-circle btn-icon btn-sm btn-danger confirm-action-button"
            data-action="{{route("question.admin.destroy",$question->id)}}"
            data-custom_method='@method('DELETE')'
            data-reload="1">
            <i data-feather="trash"></i>
        </a>
    </td>
</tr>
