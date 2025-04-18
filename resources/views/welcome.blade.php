<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head><base href="">
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
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" data-bs-spy="scroll" data-bs-target="#kt_landing_menu" data-bs-offset="200" class="bg-white position-relative">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Header Section-->
			<div class="mb-0" id="home">
				<!--begin::Wrapper-->
				<div class="bgi-no-repeat bgi-size-contain bgi-position-x-center bgi-position-y-bottom landing-dark-bg">
					<!--begin::Header-->
					<div class="landing-header" data-kt-sticky="true" data-kt-sticky-name="landing-header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
						<!--begin::Container-->
						<div class="container">
							<!--begin::Wrapper-->
							<div class="d-flex align-items-center justify-content-between">
								<!--begin::Logo-->
								<div class="d-flex align-items-center flex-equal">
									<!--begin::Mobile menu toggle-->
									<button class="btn btn-icon btn-active-color-primary me-3 d-flex d-lg-none" id="kt_landing_menu_toggle">
										<!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
										<span class="svg-icon svg-icon-2hx">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="black" />
												<path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="black" />
											</svg>
										</span>
										<!--end::Svg Icon-->
									</button>
									<!--end::Mobile menu toggle-->
									<!--begin::Logo image-->
									<a href="{{url('/')}}">
										<img alt="Logo" src="{{ asset('public/assets/media/logos/logowebsite.jpg') }}" class="logo-default h-25px h-lg-30px" />
									</a>
									<!--end::Logo image-->
								</div>
								<!--end::Logo-->
								<!--begin::Menu wrapper-->
								<div class="d-lg-block" id="kt_header_nav_wrapper">
									<div class="d-lg-block p-5 p-lg-0" data-kt-drawer="true" data-kt-drawer-name="landing-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="200px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_landing_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav_wrapper'}">
										<!--begin::Menu-->
										<div class="menu menu-column flex-nowrap menu-rounded menu-lg-row menu-title-gray-500 menu-state-title-primary nav nav-flush fs-5 fw-bold" id="kt_landing_menu">
											<!--begin::Menu item-->
											<div class="menu-item">
												<!--begin::Menu link-->
												<a class="menu-link nav-link active py-3 px-4 px-xxl-6" href="#kt_body" data-kt-scroll-toggle="true" data-kt-drawer-dismiss="true">Home</a>
												<!--end::Menu link-->
											</div>
											<!--end::Menu item-->
											<!--begin::Menu item-->
											<div class="menu-item">
												<!--begin::Menu link-->
												<a class="menu-link nav-link py-3 px-4 px-xxl-6" href="{{ url('ticket') }}" data-kt-scroll-toggle="true" data-kt-drawer-dismiss="true">Contact Us</a>
												<!--end::Menu link-->
											</div>
											<!--end::Menu item-->
										</div>
										<!--end::Menu-->
									</div>
								</div>
								<!--end::Menu wrapper-->
								<!--begin::Toolbar-->
								<div class="flex-equal text-end ms-1">
                                    @if(auth()->user()) 
                                        <div class="toolbar">
                                            <!--begin::Toolbar-->
                                            <div class="container-fluid py-6 py-lg-0 d-flex flex-column flex-lg-row align-items-lg-stretch justify-content-lg-end">
                                                <!--begin::Action group-->
                                                <div class="d-flex align-items-center overflow-auto pt-3 pt-lg-0">
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
                                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-200px" data-kt-menu="true">
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
                                                                    </div>
                                                                    <!--end::Username-->
                                                                </div>
                                                            </div>
                                                            <!--end::Menu item-->
                                                            <!--begin::Menu separator-->
                                                            <a href="#" class="fw-bold text-muted text-hover-primary fs-7 text-center">{{ auth()->user()->email }}</a>

                                                            <div class="separator my-2"></div>
                                                            <!--end::Menu separator-->
                                                           
                                                            <!--begin::Menu item-->
                                                            <div class="menu-item px-5" data-kt-menu-placement="right-start">
                                                                <a href="{{ url('ticket') }}" class="menu-link px-5">
                                                                    <span class="menu-title">Support</span>
                                                                </a>
                                                            </div>
                                                            <!--end::Menu item-->
                                                            <div class="menu-item px-5">
                                                                <a href="{{ route('logout') }}" class="menu-link px-5"  onclick="event.preventDefault();
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
                                                </div>
                                                <!--end::Action group-->
                                            </div>
                                            <!--end::Toolbar-->
                                        </div>
                                    @else
									    <a href="{{ route('login') }}" class="btn btn-success">Sign In</a>
                                    @endif
								</div>
								<!--end::Toolbar-->
							</div>
							<!--end::Wrapper-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Header-->
					<!--begin::Landing hero-->
					<div class="d-flex flex-column flex-center w-100 min-h-350px min-h-lg-500px px-9">
						<!--begin::Heading-->
						<div class="text-center mb-5 mb-lg-10 py-10 py-lg-20">
							<!--begin::Title-->
							<h1 class="text-white lh-base fw-bolder fs-2x fs-lg-3x mb-15">Build An Outstanding Solutions
							<br />with
							<span style="background: linear-gradient(to right, #12CE5D 0%, #FFD80C 100%);-webkit-background-clip: text;-webkit-text-fill-color: transparent;">
								<span id="kt_landing_hero_text">The Best Theme Ever</span>
							</span></h1>
							<!--end::Title-->
						</div>
						<!--end::Heading-->
						
					</div>
					<!--end::Landing hero-->
				</div>
				<!--end::Wrapper-->
				<!--begin::Curve bottom-->
				<div class="landing-curve landing-dark-color mb-10 mb-lg-20">
					<svg viewBox="15 12 1470 48" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M0 11C3.93573 11.3356 7.85984 11.6689 11.7725 12H1488.16C1492.1 11.6689 1496.04 11.3356 1500 11V12H1488.16C913.668 60.3476 586.282 60.6117 11.7725 12H0V11Z" fill="currentColor"></path>
					</svg>
				</div>
				<!--end::Curve bottom-->
			</div>
		</div>

        @include("pages.scrollTop")
        
		<!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="{{ asset('public/assets/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('public/assets/js/scripts.bundle.js') }}"></script>
		<!--end::Global Javascript Bundle-->

	</body>
	<!--end::Body-->
</html>