<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Euronet Support Center') }}</title>

	    <link rel="shortcut icon" href="{{ asset('public/assets/media/logos/logo-icon.png') }}" type="image/png">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('public/css/app.css') }}">

        <!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
    </head>
    <body id="kt_body" class="header-tablet-and-mobile-fixed aside-enabled">
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">
				<!--begin::Wrapper-->
                <!--begin::Aside-->
                @include("pages.sidebar")
                <!--end::Aside-->
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                    <!--begin::Aside search-->
                        @include("pages.header")
                    <!--end::Aside search-->
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						@yield('content')
					</div>
					<!--end::Content-->
					<!--begin::Footer-->
					<div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
                        @include("pages.footer")
					</div>
					<!--end::Footer-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Root-->
		
        @include("pages.scrollTop")
        
		<!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="{{ asset('public/assets/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('public/assets/js/scripts.bundle.js') }}"></script>
		<!--end::Global Javascript Bundle-->
		
		<!--begin::Page Vendors Javascript(used by this page)-->
		<script src="{{ asset('public/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
		<!--end::Page Vendors Javascript-->
		
		@yield("after_script")
	</body>

</html>
