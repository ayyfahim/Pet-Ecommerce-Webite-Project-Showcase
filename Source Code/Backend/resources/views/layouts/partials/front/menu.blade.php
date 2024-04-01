<div class="overlay" data-animation-type="slide" data-enternce-direction="right" data-exit-direction="right"
     data-speed="">
    <i class="menu-close material-icons">close</i>
    <div class="overlay__nav overlay__nav--main">
    </div>
    <div class="overlay__nav overlay__nav--sub">
        <div class="main-services">
            <ul>
                <li>
                    <a href="{{route('service.index')}}">
                        <img class="mob-shape services" src="{{asset('images/icons/services-bg-icon.png')}}" alt="">
                        <img
                            src="{{asset('images/icons/services-mob-icon.png')}}" alt="">@lang('service.services')
                    </a>
                </li>
                <li>
                    <a href="{{route('rfp.index')}}"> <img class="mob-shape events"
                                                             src="{{asset('images/icons/events-bg-icon.png')}}"
                                                             alt="">
                        <img src="{{asset('images/icons/events-mob-icon.png')}}"
                             alt="">@lang('rfp.rfps')</a>
                </li>
            </ul>
        </div>
        <div class="sub-main-services">
            <ul>
                @foreach($pages as $page)
                    <li><a href="{{route('page.show',$page->slug)}}">{{$page->title}}</a></li>
                @endforeach
                <li><a href="{{route('support')}}">{{$supportConfig->title}}</a></li>
            </ul>
        </div>
        <div class="add-services-wrap">
            <ul>
                <li>
                    @if($authUser)
                        @if(!$authUser->hasRole('provider') && $authUser->hasRole('customer'))
                            <a href="{{route('user.provider.info')}}">@lang('service.add_your_service')</a>
                        @elseif($authUser->hasRole('provider'))
                            <a href="{{route('service.create')}}">@lang('service.add_your_service')</a>
                        @endif
                    @else
                        <a href="{{route('register',['type'=>'provider'])}}">@lang('service.add_your_service')</a>
                    @endif
                </li>
            </ul>
        </div>
        <div class="overlay__nav--dropdowns">
            <p>@lang('common.language'):</p>
            <div class="dropdown">
                <button class="btn btn-link dropdown-toggle" id="languageDropdown" data-toggle="dropdown" type="button"
                        aria-expanded="false" aria-haspopup="true">
                    {{app()->getLocale()}}
                </button>
                <div class="dropdown-menu" aria-labelledby="languageDropdown">
                    <a class="dropdown-item" href="{{$helper->changeLocale('en')}}">english</a>
                    <a class="dropdown-item rtl" href="{{$helper->changeLocale('ar')}}">عربي</a>
                </div>
            </div>
        </div>
        <div class="phoneDropDown">
            <p>@lang('common.language'):</p>
            <select class="form-control" onchange="location.href = this.value">
                <option @if(app()->getLocale() == 'en') selected @endif value="{{$helper->changeLocale('en')}}">
                    English
                </option>
                <option @if(app()->getLocale() == 'ar') selected @endif value="{{$helper->changeLocale('ar')}}">
                    عربي
                </option>
            </select>
        </div>
    </div>
</div>
