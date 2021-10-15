@extends("layouts.app")

@section("content")
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

            <div class="row justify-content-lg-between g-xl-8">
                <div class="col-xl-3">
                    <!--begin::Statistics Widget 5-->
                    <a href="{{ url("admin/users") }}" class="card bg-body-white hoverable card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm002.svg-->
                            <span class="svg-icon svg-icon-primary svg-icon-3x ms-n1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3" d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM12 7C10.3 7 9 8.3 9 10C9 11.7 10.3 13 12 13C13.7 13 15 11.7 15 10C15 8.3 13.7 7 12 7Z" fill="black"></path>
                                    <path d="M12 22C14.6 22 17 21 18.7 19.4C17.9 16.9 15.2 15 12 15C8.8 15 6.09999 16.9 5.29999 19.4C6.99999 21 9.4 22 12 22Z" fill="black"></path>
                                </svg>
                            </span>
                            <span class="fw-bold text-gray-400">{{__('panel.Customers') }}</span>

                            <!--end::Svg Icon-->
                            <div class="text-gray-900 fw-bolder fs-1 mb-2 mt-5">{{ $users->count() }}</div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>
                <div class="col-xl-3">
                    <!--begin::Statistics Widget 5-->
                    <a href="{{ url("admin/ticketnew") }}" class="card bg-primary hoverable card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen008.svg-->
                            <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M3 2H10C10.6 2 11 2.4 11 3V10C11 10.6 10.6 11 10 11H3C2.4 11 2 10.6 2 10V3C2 2.4 2.4 2 3 2Z" fill="black"></path>
                                    <path opacity="0.3" d="M14 2H21C21.6 2 22 2.4 22 3V10C22 10.6 21.6 11 21 11H14C13.4 11 13 10.6 13 10V3C13 2.4 13.4 2 14 2Z" fill="black"></path>
                                    <path opacity="0.3" d="M3 13H10C10.6 13 11 13.4 11 14V21C11 21.6 10.6 22 10 22H3C2.4 22 2 21.6 2 21V14C2 13.4 2.4 13 3 13Z" fill="black"></path>
                                    <path opacity="0.3" d="M14 13H21C21.6 13 22 13.4 22 14V21C22 21.6 21.6 22 21 22H14C13.4 22 13 21.6 13 21V14C13 13.4 13.4 13 14 13Z" fill="black"></path>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <span class="fw-bold text-white">{{__('panel.New Tickets') }}</span>

                            <div class="fw-bold text-white fs-1 mb-2 mt-5">{{ $tickets_new }}</div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>
                <div class="col-xl-3">
                    <!--begin::Statistics Widget 5-->
                    <a href="{{ url("admin/ticketopen") }}" class="card bg-dark hoverable card-xl-stretch mb-5 mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr070.svg-->
                            <span class="svg-icon svg-icon-gray-100 svg-icon-3x ms-n1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect x="8" y="9" width="3" height="10" rx="1.5" fill="black"></rect>
                                    <rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5" fill="black"></rect>
                                    <rect x="18" y="11" width="3" height="8" rx="1.5" fill="black"></rect>
                                    <rect x="3" y="13" width="3" height="6" rx="1.5" fill="black"></rect>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <span class="fw-bold text-gray-100">{{__('panel.Open Tickets') }}</span>
                            <div class="fw-bold text-gray-100 fs-1 mt-5">{{ $tickets_opening }}</div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>
                <div class="col-xl-3">
                    <!--begin::Statistics Widget 5-->
                    <a href="{{ url("admin/ticketprocessing") }}" class="card bg-dark hoverable card-xl-stretch mb-5 mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr070.svg-->
                            <span class="svg-icon svg-icon-gray-100 svg-icon-3x ms-n1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect x="8" y="9" width="3" height="10" rx="1.5" fill="black"></rect>
                                    <rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5" fill="black"></rect>
                                    <rect x="18" y="11" width="3" height="8" rx="1.5" fill="black"></rect>
                                    <rect x="3" y="13" width="3" height="6" rx="1.5" fill="black"></rect>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <span class="fw-bold text-gray-100">{{__('panel.Processing Tickets') }}</span>
                            <div class="fw-bold text-gray-100 fs-1 mt-5">{{ $tickets_processing }}</div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>

                <div class="col-xl-3">
                    <!--begin::Statistics Widget 5-->
                    <a href="{{ url("admin/ticketpending") }}" class="card bg-info hoverable card-xl-stretch mb-5 mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr070.svg-->
                            <span class="svg-icon svg-icon-gray-100 svg-icon-3x ms-n1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect x="8" y="9" width="3" height="10" rx="1.5" fill="black"></rect>
                                    <rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5" fill="black"></rect>
                                    <rect x="18" y="11" width="3" height="8" rx="1.5" fill="black"></rect>
                                    <rect x="3" y="13" width="3" height="6" rx="1.5" fill="black"></rect>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <span class="fw-bold text-gray-100">{{__('panel.Pending Tickets') }}</span>
                            <div class="fw-bold text-gray-100 fs-1 mt-5">{{ $tickets_pending }}</div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>
                <div class="col-xl-3">
                    <!--begin::Statistics Widget 5-->
                    <a href="{{ url("admin/ticketcomplete") }}" class="card bg-info hoverable card-xl-stretch mb-5 mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr070.svg-->
                            <span class="svg-icon svg-icon-gray-100 svg-icon-3x ms-n1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect x="8" y="9" width="3" height="10" rx="1.5" fill="black"></rect>
                                    <rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5" fill="black"></rect>
                                    <rect x="18" y="11" width="3" height="8" rx="1.5" fill="black"></rect>
                                    <rect x="3" y="13" width="3" height="6" rx="1.5" fill="black"></rect>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <span class="fw-bold text-gray-100">{{__('panel.Complete Tickets') }}</span>
                            <div class="fw-bold text-gray-100 fs-1 mt-5">{{ $tickets_complete }}</div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>
                <div class="col-xl-3">
                    <!--begin::Statistics Widget 5-->
                    <a href="{{ url("admin/ticketreply") }}" class="card bg-info hoverable card-xl-stretch mb-5 mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr070.svg-->
                            <span class="svg-icon svg-icon-gray-100 svg-icon-3x ms-n1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect x="8" y="9" width="3" height="10" rx="1.5" fill="black"></rect>
                                    <rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5" fill="black"></rect>
                                    <rect x="18" y="11" width="3" height="8" rx="1.5" fill="black"></rect>
                                    <rect x="3" y="13" width="3" height="6" rx="1.5" fill="black"></rect>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <span class="fw-bold text-gray-100">{{__('panel.Reply Tickets') }}</span>
                            <div class="fw-bold text-gray-100 fs-1 mt-5">{{ $tickets_reply }}</div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>
            </div>

        </div>
    </div>
@endsection

{{-- @section() --}}