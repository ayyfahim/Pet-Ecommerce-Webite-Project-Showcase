<div class="card-inner-side">
    <div class="card-header text-center px-0 pb-0">
        <div class="user-img-md align-items-center mb-2">
            <a href="{{ route('user.dashboard') }}">
                <img src="{{ $authUser->getUrlFor('avatar') ?: $avatarDef }}" alt="">
            </a>
            <a class="user-img-name" href="{{ route('user.dashboard') }}">
                {{$authUser->full_name}}
            </a>
        </div>
        @if($authUser->active_package)
            <p class="bg-blue-dark py-2">
                    <span class="badge badge-white font-weight-bold text-uppercase my-1 w-75">
                        provider package: {{$authUser->active_package->info->title}}
                    </span>
            </p>
        @endif
    </div>
    <div class="card-body">
        <ul class="list-group list-group-dark">
            <li class="list-group-item @if(request()->is(['*/conversations','*/conversations/*'])) active @endif">
                <a class="border-0" href="{{route('conversation.index')}}">@lang('message.messages')
                    @if($authUser->messages_count['new'])
                        <span class="badge btn-danger">{{$authUser->messages_count['new']}}</span>
                    @endif
                </a>
                {{--                <span class="badge">{{$authUser->messages_count['all']}}</span>--}}
            </li>
        </ul>
        @php
            $show_my_profile = request()->is([
            '*/users/dashboard','*/user/verify','*/users/provider-info','*/users/verify-provider','*/users/provider-subscription',
            '',
            ]);
        @endphp
        <div class="accordion accordion-dark" id="InnerSideCard">
            <div class="card">
                <div class="card-header" id="innerSide-1">
                    <h6 class="mb-0">
                        <button class="btn btn-link collapsed" data-target="#innerCollapse-1"
                                data-toggle="collapse" type="button"
                                aria-controls="innerCollapse-1"
                                @if($show_my_profile)
                                aria-expanded="true"
                            @endif
                        >
                            @lang('user.my_profile')
                        </button>
                    </h6>
                </div>
                <div class="collapse @if($show_my_profile) show @endif" id="innerCollapse-1"
                     aria-labelledby="innerSide-1"
                     data-parent="">
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item @if(request()->is(['*/users/dashboard'])) active @endif">
                                <a href="{{route('user.dashboard')}}">
                                    @lang('user.account_info')
                                </a>
                            </li>
                            @if(!$authUser->hasRole('admin'))
                                <li class="list-group-item @if(request()->is(['*/user/verify'])) active @endif">
                                    <a href="{{route('verification.notice')}}">
                                        @lang('auth.account_verification')
                                    </a>
                                </li>
                            @endif
                            @if($authUser->hasRole('provider'))
                                <li class="list-group-item @if(request()->is(['*/users/provider-info'])) active @endif">
                                    <a href="{{route('user.provider.info')}}">@lang('user.provider_info')</a>
                                </li>
                                <li class="list-group-item @if(request()->is(['*/users/verify-provider'])) active @endif">
                                    <a href="{{route('user.provider.verify')}}">@lang('user.provider_verification')</a>
                                </li>
                                <li class="list-group-item @if(request()->is(['*/users/provider-subscription'])) active @endif">
                                    <a href="{{route('user.provider.subscription')}}">@lang('subscription.my_subscription')</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            @if($authUser->hasCompleteVerification())
                @if($authUser->hasRole('customer'))
                    @php
                        $active_customer_order = (request()->route()->getName() == 'order.show' && isset($order) && $order->customer->is($authUser));
                        $active_customer_request = (request()->route()->getName() == 'request.show' && isset($service_request) && $service_request->customer->is($authUser));
                        $show_customer = (request()->is([
                        '*/requests/sent','*/orders/received','*/payments','*/reviews','*/rfps*'
                       ]) || $active_customer_order || $active_customer_request);
                    @endphp
                    <div class="card">
                        <div class="card-header" id="innerSide-2">
                            <h6 class="mb-0">
                                <button class="btn btn-link collapsed" data-target="#innerCollapse-2"
                                        data-toggle="collapse" type="button"
                                        aria-controls="innerCollapse-2"
                                        @if($show_customer)
                                        aria-expanded="true"
                                    @endif
                                >
                                    @lang('user.customer_dashboard')
                                </button>
                            </h6>
                        </div>
                        <div class="collapse @if($show_customer) show @endif" id="innerCollapse-2"
                             aria-labelledby="innerSide-2"
                             data-parent="">
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item @if(request()->is(['*/requests/sent']) || $active_customer_request) active @endif">
                                        <a
                                            href="{{route('request.index','sent')}}">@lang('service.sent_requests')</a>
                                    </li>
                                    <li class="list-group-item @if(request()->is(['*/orders/received']) || $active_customer_order) active @endif">
                                        <a
                                            href="{{route('order.index','received')}}">@lang('order.orders_to_receive')</a>
                                    </li>
                                    <li class="list-group-item @if(request()->is(['*/rfps*'])) active @endif">
                                        <a href="{{route('rfp.manager.index')}}">@lang('rfp.my_rfps')</a>
                                    </li>
                                    <li class="list-group-item @if(request()->is(['*/payments'])) active @endif">
                                        <a href="{{route('payment.index')}}">@lang('finance.my_payments')</a>
                                    </li>
                                    <li class="list-group-item @if(request()->is(['*/reviews'])) active @endif">
                                        <a href="{{route('review.index')}}">@lang('review.my_reviews')</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @php
                        $active_provider_order = (request()->route()->getName() == 'order.show' && isset($order) && $order->provider->is($authUser));
                            $active_provider_request = (request()->route()->getName() == 'request.show' && isset($service_request) && $service_request->service->user->is($authUser));
                            $show_provider = request()->is(['*/orders/deliver','*/requests/received','*/services/*','*/earnings','*/rfp/proposals'])
                            || $active_provider_order || $active_provider_request ;
                    @endphp
                    <div class="card">
                        <div class="card-header" id="innerSide-3">
                            <h6 class="mb-0">
                                <button class="btn btn-link collapsed" data-target="#innerCollapse-3"
                                        data-toggle="collapse" type="button"
                                        aria-controls="innerCollapse-3"
                                        @if($show_provider)
                                        aria-expanded="true"
                                    @endif
                                >
                                    @lang('user.provider_dashboard')
                                </button>
                            </h6>
                        </div>
                        <div class="collapse @if($show_provider) show @endif" id="innerCollapse-3"
                             aria-labelledby="innerSide-3"
                             data-parent="">
                            <div class="card-body">
                                @if(!$authUser->hasRole('provider'))
                                    <h6 class="text-center px-3 font-weight-light">
                                        <a class="btn btn-block btn-lg my-3 py-2 become-provider-btn"
                                           href="{{route('user.provider.info')}}">@lang('user.provide_your_service')</a>
                                        <small>
                                            @lang('user.start_selling_description')
                                        </small>
                                    </h6>
                                @else
                                    @if($authUser->is_verified_provider)
                                        <ul class="list-group">
                                            <li class="list-group-item @if(request()->is(['*/orders/deliver']) || $active_provider_order) active @endif">
                                                <a href="{{route('order.index','deliver')}}">@lang('order.orders_to_deliver')</a>
                                            </li>
                                            <li class="list-group-item @if(request()->is(['*/requests/received']) || $active_provider_request) active @endif">
                                                <a href="{{route('request.index','received')}}">@lang('service.received_requests')</a>
                                            </li>
                                            <li class="list-group-item @if(request()->is(['*/services/*'])) active @endif">
                                                <a href="{{route('service.manager.index')}}">@lang('service.my_service_manager')</a>
                                            </li>
                                            <li class="list-group-item @if(request()->is(['*/rfp/proposals'])) active @endif">
                                                <a href="{{route('earning.index')}}">@lang('rfp.proposals')</a>
                                            </li>
                                            <li class="list-group-item @if(request()->is(['*/earnings'])) active @endif">
                                                <a href="{{route('earning.index')}}">@lang('finance.my_earnings')</a>
                                            </li>
                                        </ul>
                                    @else
                                        <h6 class="text-center px-3 font-weight-light">
                                            <a class="btn btn-block btn-lg my-3 py-2 waiting-verify-msg">
                                                @lang('user.pending_admin_verification_label')
                                            </a>
                                            <small>
                                                @lang('user.pending_admin_verification_description')
                                            </small>
                                        </h6>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
                @if($authUser->hasRole('admin'))
                    @php
                        $show_admin =
                        request()->is([
                        '*/services/*','*/categories','*/categories/*','*/requests','*/requests/*',
                        '*/orders','*/orders/*','*/payments','*/earnings','*/reviews/service',
                        '*rfps/list','*/rfp/proposals*','*/packages*','*/taggroups*','*/notifications*',
                        '*/manager/users','*/manager/edit/*','*/subscriptions',
                        '*/manager/pages','*/manager/pages/*','*/config*'
                        ]);
                    @endphp
                    <div class="card">
                        <div class="card-header" id="innerSide-6">
                            <h6 class="mb-0">
                                <button class="btn btn-link collapsed" data-target="#innerCollapse-6"
                                        data-toggle="collapse" type="button"
                                        aria-controls="innerCollapse-6"
                                        @if($show_admin)
                                        aria-expanded="true"
                                    @endif
                                >
                                    Admin
                                    Dashboard
                                </button>
                            </h6>
                        </div>
                        <div class="collapse @if($show_admin) show @endif" id="innerCollapse-6"
                             aria-labelledby="innerSide-6"
                             data-parent="">
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item @if(request()->is(['*/requests','*/requests/*'])) active @endif">
                                        <a href="{{route('request.index')}}">All Requests</a>
                                    </li>
                                    <li class="list-group-item @if(request()->is(['*/orders','*/orders/*'])) active @endif">
                                        <a href="{{route('order.index')}}">All Orders</a>
                                    </li>
                                    <li class="list-group-item @if(request()->is(['*/manager/users','*/manager/edit/*'])) active @endif">
                                        <a href="{{route('user.manager.index')}}">Users
                                            Manager</a>
                                    </li>
                                    <li class="list-group-item @if(request()->is(['*/services/*'])) active @endif">
                                        <a href="{{route('service.manager.index')}}">Services Manager</a>
                                    </li>
                                    <li class="list-group-item @if(request()->is(['*/rfps/list'])) active @endif">
                                        <a href="{{route('rfp.manager.index')}}">RFP Manager</a>
                                    </li>
                                    <li class="list-group-item @if(request()->is(['*/rfp/proposals'])) active @endif">
                                        <a href="{{route('proposal.index')}}">All Proposals</a>
                                    </li>
                                    <li class="list-group-item @if(request()->is(['*/payments'])) active @endif">
                                        <a href="{{route('payment.index')}}">@lang('finance.payments')</a>
                                    </li>
                                    <li class="list-group-item @if(request()->is(['*/earnings'])) active @endif">
                                        <a href="{{route('earning.index')}}">@lang('finance.earnings')</a>
                                    </li>
                                    <li class="list-group-item @if(request()->is(['*/packages*'])) active @endif">
                                        <a href="{{route('package.manager.index')}}">Packages Manager</a>
                                    </li>
                                    <li class="list-group-item @if(request()->is(['*/subscriptions'])) active @endif">
                                        <a href="{{route('subscription.manager.index')}}">Subscription Manager</a>
                                    </li>
                                    <li class="list-group-item @if(request()->is(['*/categories','*/categories/*'])) active @endif">
                                        <a
                                            href="{{route('category.manager.index')}}">Categories</a>
                                    </li>
                                    <li class="list-group-item @if(request()->is(['*/taggroups*'])) active @endif">
                                        <a
                                            href="{{route('taggroup.manager.index')}}">Tags</a>
                                    </li>
                                    <li class="list-group-item @if(request()->is(['*/reviews*'])) active @endif">
                                        <a href="{{route('review.index','service')}}">Reviews</a>
                                    </li>
                                    <li class="list-group-item @if(request()->is(['*/manager/pages','*/manager/pages/*'])) active @endif">
                                        <a href="{{route('page.manager.index')}}">System Pages Manager</a>
                                    </li>
                                    <li class="list-group-item @if(request()->is(['*/config/home','*/config/home/*'])) active @endif">
                                        <a href="{{route('config.manager.home')}}">Homepage Settings</a>
                                    </li>
                                    <li class="list-group-item @if(request()->is(['*/config/data','*/config/data/*'])) active @endif">
                                        <a href="{{route('config.manager.data')}}">General Settings</a>
                                    </li>
                                    <li class="list-group-item @if(request()->is(['*/notifications*'])) active @endif">
                                        <a href="{{route('notification.manager.index')}}">System Notifications</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif            @endif
        </div>
    </div>
</div>
