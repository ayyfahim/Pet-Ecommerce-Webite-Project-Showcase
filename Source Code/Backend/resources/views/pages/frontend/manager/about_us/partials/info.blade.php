<tr>
    <td>
        <a href="{{route('article.admin.edit',$article->id)}}"><span class="font-weight-bold">{{$article->title}}</span></a>
    </td>
    <td>
        @if($article->author && isset($article->author['name']))
           {{$article->author['name']}}
        @else
            -
        @endif
    </td>
    <td>{{$article->user->full_name}}</td>
    <td>{{$article->updated_at->toDateString()}}</td>
    <td>
        <span class="badge badge-{{$article->status->color}}">{{$article->status->title}}</span>
    </td>
    <td style="min-width: 150px;">
        <a href="{{route('article.admin.edit',$article->id)}}"
           class="btn rounded-circle btn-icon btn-sm btn-info">
            <i data-feather="edit-2"></i>
        </a>
        <a
            class="btn rounded-circle btn-icon btn-sm btn-danger confirm-action-button"
            data-action="{{route("article.admin.destroy",$article->id)}}"
            data-custom_method='@method('DELETE')'
            data-reload="1">
            <i data-feather="trash"></i>
        </a>
    </td>
</tr>
