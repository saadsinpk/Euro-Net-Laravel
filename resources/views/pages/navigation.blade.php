<div id="kt_header" style="" class="header align-items-stretch">
    <!--begin::Brand-->
    <div class="header-brand">
        <!--begin::Logo-->
        <a href="/">
            <img alt="Logo" src="{{ asset('public/assets/media/logos/logowebsite.jpg') }}" class="h-25px h-lg-25px" />
        </a>
        <!--end::Logo-->

    </div>
    <div class="toolbar">
        @if(auth()->user())
        <!--begin::Toolbar-->
        <div class="container-fluid py-6 py-lg-0 d-flex flex-column flex-lg-row align-items-lg-stretch justify-content-lg-end">
            <!--begin::Action group-->
            <div class="d-flex align-items-center pt-3 pt-lg-0 gap-10">
                 <!--begin::Aside Toolbarl-->
                <div class="aside-toolbar flex-column-auto" id="kt_aside_toolbar">
                    <!--begin::Symbol-->
                    <a href="#" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-overflow="true" >
                        <div class="symbol symbol-50px">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('public/uploads/avatar/'. auth()->user()->avatar)  }}" alt="" />
                            @else
                                <div class="symbol-label fs-1 fw-bolder bg-white text-primary border">{{ substr(auth()->user()->name, 0, 1) }}</div>
                            @endif
                        </div>
                    </a>

                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-50px me-5">
                                    @if(auth()->user()->avatar)
                                        <img src="{{ asset('public/uploads/avatar/'. auth()->user()->avatar)  }}" alt="" />
                                    @else
                                        <img src="{{ asset('public/assets/media/avatars/blank.png') }}" alt="" />
                                    @endif
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Username-->
                                <div class="d-flex flex-column">
                                    <div class="fw-bolder d-flex align-items-center fs-5">{{ auth()->user()->name }}</div>
                                    <a href="#" class="fw-bold text-muted text-hover-primary fs-7">{{ auth()->user()->email }}</a>
                                </div>
                                <!--end::Username-->
                            </div>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->
    
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href="{{ route("logout") }}" class="menu-link px-5"  onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">Sign Out</a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->
                    </div>

                    <!--end::Aside user-->
                </div>
                <!--end::Aside Toolbarl-->
                <div class="d-flex align-items-center">

                    <a href="#" class="btn btn-icon btn-sm btn-active-color-primary mt-n2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-overflow="true">
                        <span class="flag-icon flag-icon-{{Config::get('languages')[App::getLocale()]['flag-icon']}}"></span> <img src="{{ asset('public/assets/media/') }}/{{ Config::get('languages')[App::getLocale()]['display'] }}.png" style="  max-width: 25px;    margin-right: 10px;"> {{ Config::get('languages')[App::getLocale()]['display'] }}
                    </a>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-150px" data-kt-menu="true">
                        @foreach (Config::get('languages') as $lang => $language)
                            @if ($lang != App::getLocale())
                            <div class="menu-item px-3">
                                <a class="menu-link px-5" href="{{ route('lang.switch', $lang) }}"> <span class="flag-icon flag-icon-{{$language['flag-icon']}}"></span> {{$language['display']}}</a>
                            </div>
                            @endif
                        @endforeach
                    </div>

                </div>
            </div>
            <!--end::Action group-->
        </div>
        <!--end::Toolbar-->
        @else
        <div class="align-items-lg-stretch container-fluid text-end">
            <a href="{{ route('login') }}" class="btn btn-success me-10">{{__('auth.signin') }}</a>

            <a href="#" class="btn btn-icon btn-sm btn-active-color-primary mt-n2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-overflow="true">
                <span class="flag-icon flag-icon-{{Config::get('languages')[App::getLocale()]['flag-icon']}}"></span><img src="{{ asset('public/assets/media/') }}/{{ Config::get('languages')[App::getLocale()]['display'] }}.png" style="  max-width: 25px;    margin-right: 10px;"> {{ Config::get('languages')[App::getLocale()]['display'] }}
            </a>
            <!--begin::Menu-->
            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-150px" data-kt-menu="true">
                @foreach (Config::get('languages') as $lang => $language)
                    @if ($lang != App::getLocale())
                    <div class="menu-item px-3">
                        <a class="menu-link px-5" href="{{ route('lang.switch', $lang) }}"> <span class="flag-icon flag-icon-{{$language['flag-icon']}}"></span> <img src="{{ asset('public/assets/media/') }}/{{$language['display']}}.png" style="  max-width: 25px;    margin-right: 10px;"> {{$language['display']}}</a>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>