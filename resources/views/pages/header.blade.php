<div id="kt_header" style="" class="header align-items-stretch">
    <!--begin::Brand-->
    <div class="header-brand">
        <!--begin::Logo-->
        <a href="/">
            <img alt="Logo" src="{{ asset('public/assets/media/logos/logowebsite.jpg') }}" class="h-25px h-lg-25px" />
        </a>
        <!--end::Logo-->

    </div>
    <!--end::Brand-->
    <div class="toolbar">
        <!--begin::Toolbar-->
        <div class="container-fluid py-6 py-lg-0 d-flex flex-column flex-lg-row align-items-lg-stretch justify-content-lg-between">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column me-5">
                <!--begin::Title-->
                <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">{{__('panel.Admin Panel') }}</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-200 w-5px h-2px"></span>
                    </li>
                    <li>
                        <a href="{{ request()->segment(1) }}">{{ ucfirst(request()->segment(1)) }}</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <!--begin::Action group-->
            <div class="d-flex align-items-center pt-3 pt-lg-0">
                <div class="d-flex align-items-center">
                    <a href="{{ route('logout') }}" class="menu-link px-5"  onclick="event.preventDefault();
                        document.getElementById('action-logout-form').submit();">
                        <span class="svg-icon svg-icon-1 me-n1 minimize-default">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.3" x="8.5" y="11" width="12" height="2" rx="1" fill="black"></rect>
                                <path d="M10.3687 11.6927L12.1244 10.2297C12.5946 9.83785 12.6268 9.12683 12.194 8.69401C11.8043 8.3043 11.1784 8.28591 10.7664 8.65206L7.84084 11.2526C7.39332 11.6504 7.39332 12.3496 7.84084 12.7474L10.7664 15.3479C11.1784 15.7141 11.8043 15.6957 12.194 15.306C12.6268 14.8732 12.5946 14.1621 12.1244 13.7703L10.3687 12.3073C10.1768 12.1474 10.1768 11.8526 10.3687 11.6927Z" fill="black"></path>
                                <path opacity="0.5" d="M16 5V6C16 6.55228 15.5523 7 15 7C14.4477 7 14 6.55228 14 6C14 5.44772 13.5523 5 13 5H6C5.44771 5 5 5.44772 5 6V18C5 18.5523 5.44771 19 6 19H13C13.5523 19 14 18.5523 14 18C14 17.4477 14.4477 17 15 17C15.5523 17 16 17.4477 16 18V19C16 20.1046 15.1046 21 14 21H5C3.89543 21 3 20.1046 3 19V5C3 3.89543 3.89543 3 5 3H14C15.1046 3 16 3.89543 16 5Z" fill="black"></path>
                            </svg>
                        </span>
                            {{__('auth.Logout') }}
                    </a>

                    <form id="action-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>

                <a href="#" class="btn btn-icon btn-sm btn-active-color-primary mt-n2 pt-2 ms-4" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-overflow="true">
                    <span class="flag-icon flag-icon-{{Config::get('languages')[App::getLocale()]['flag-icon']}}"></span>  <img src="{{ asset('public/assets/media/') }}/{{ Config::get('languages')[App::getLocale()]['display'] }}.png" style="  max-width: 25px;    margin-right: 10px;"> {{ Config::get('languages')[App::getLocale()]['display'] }}
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
            <!--end::Action group-->
        </div>
        <!--end::Toolbar-->
    </div>
</div>