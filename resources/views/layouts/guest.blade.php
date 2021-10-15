<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Euronet Support Center') }}</title>

        <link rel="shortcut icon" href="{{ asset('public/assets/media/logos/logo-icon.png') }}" type="image/png">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('public/css/app.css') }}">

        <!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->

        <!-- Scripts -->
     <script src="{{ asset('public/js/app.js') }}" defer></script>
    </head>
    
    <body id="kt_body" class="bg-body">

        <div class="align-items-lg-stretch container-fluid text-end mt-5">
            <a href="#" class="btn btn-icon btn-sm btn-active-color-primary mt-n2" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-overflow="true">
                <span class="flag-icon flag-icon-{{Config::get('languages')[App::getLocale()]['flag-icon']}}"></span><img src="{{ asset('public/assets/media/') }}/{{ Config::get('languages')[App::getLocale()]['display'] }}.png" style="  max-width: 25px;    margin-right: 10px;"> {{ Config::get('languages')[App::getLocale()]['display'] }}
            </a>
            <!--begin::Menu-->
            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-150px" data-kt-menu="true">
                @foreach (Config::get('languages') as $lang => $language)
                    @if ($lang != App::getLocale())
                    <div class="menu-item px-3">
                        <a class="menu-link px-5" href="{{ route('lang.switch', $lang) }}"> <span class="flag-icon flag-icon-{{$language['flag-icon']}}"></span><img src="{{ asset('public/assets/media/') }}/{{$language['display']}}.png" style="  max-width: 25px;    margin-right: 10px;"> {{$language['display']}}</a>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>

       @yield("content")
       <!--begin::Global Javascript Bundle(used by all pages)-->
        <script src="{{ asset('public/assets/js/scripts.bundle.js') }}"></script>
        <!--end::Global Javascript Bundle-->
       @yield("after_script")
    </body>

</html>
