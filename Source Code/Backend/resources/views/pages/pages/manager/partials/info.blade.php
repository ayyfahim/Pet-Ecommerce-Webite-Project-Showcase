<tr>
    <td style="min-width: 200px;">
        @if ($page->slug == 'about')
            <a href="{{route('frontend.admin.page.about_us')}}">
                <span class="font-weight-bold">{{$page->title}}</span>
            </a>
        @elseif ($page->slug == 'reward-program')
            <a href="{{route('frontend.admin.page.reward_program')}}">
                <span class="font-weight-bold">{{$page->title}}</span>
            </a>
        @elseif ($page->slug == 'homepage')
            <a href="{{route('frontend.admin.page.homepage')}}">
                <span class="font-weight-bold">{{$page->title}}</span>
            </a>
        @else
            <a href="{{route('content.admin.page.edit',$page->id)}}">
                <span class="font-weight-bold">{{$page->title}}</span>
            </a>
        @endif
    </td>
    <td>
        <span class="badge badge-{{$page->status->color}}">{{$page->status->title}}</span>
    </td>
    <td style="min-width: 150px;">
        @if ($page->slug == 'about')
           <a href="{{route('frontend.admin.page.about_us')}}"
            class="btn rounded-circle btn-icon btn-sm btn-info">
                <i data-feather="edit-2"></i>
            </a>
        @elseif ($page->slug == 'reward-program')
            <a href="{{route('frontend.admin.page.reward_program')}}"
                class="btn rounded-circle btn-icon btn-sm btn-info">
                    <i data-feather="edit-2"></i>
            </a>
        @elseif ($page->slug == 'homepage')
            <a href="{{route('frontend.admin.page.homepage')}}"
                class="btn rounded-circle btn-icon btn-sm btn-info">
                    <i data-feather="edit-2"></i>
            </a>
        @else
            <a href="{{route('content.admin.page.edit',$page->id)}}"
            class="btn rounded-circle btn-icon btn-sm btn-info">
                <i data-feather="edit-2"></i>
            </a>
        @endif
        <a
            class="btn rounded-circle btn-icon btn-sm btn-danger confirm-action-button"
            data-action="{{route("content.admin.page.destroy",$page->id)}}"
            data-custom_method='@method('DELETE')'
            data-reload="1">
            <i data-feather="trash"></i>
        </a>
    </td>
</tr>
