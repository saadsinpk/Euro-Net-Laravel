@extends("layouts.app")

@section("content")
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <form id="searchForm" action="{{ url('search-tickets') }}">
            <div class="d-flex align-items-center position-relative mb-5">
                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                <span class="svg-icon svg-icon-1 position-absolute ms-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
                    </svg>
                </span>
                <!--end::Svg Icon-->
                <input type="text" name="searchVal" class="form-control form-control-solid w-250px ps-15 bg-white" placeholder="{{__('form.Search tickets') }}" />
                <button data-action="submit" type="submit" class="btn btn-light-primary btn-hover-primary ms-5 btn-sm">
                    <span class="indicator-label">{{__('form.Submit') }}</span>
                    <span class="indicator-progress">{{__("form.Please wait...") }}
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </form>
        <div class="bg-white rounded-3">
            <table class="table align-middle table-row-dashed gy-5" id="ticket_table">
                <tbody class="fs-6 fw-bold text-gray-600">
                 
                </tbody>
            </table>
        </div>

        <div class="row justify-content-lg-between mt-5 g-xl-8">
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

@section("after_script")
    <script>
        var form = document.querySelector("#searchForm");
        var submitButton = form.querySelector("[type='submit']");
        var url = $(form).attr("action");

        submitButton.addEventListener('click', function(e) {
            e.preventDefault();
            var formdata = $(form).serialize();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: url,
                method: "POST",
                data: formdata,
                dataType: "JSON",
                success: function(res) {
                    submitButton.setAttribute('data-kt-indicator', 'on');
                    // Disable submit button whilst loading
                    submitButton.disabled = true;
                    setTimeout(function() {
                        submitButton.removeAttribute('data-kt-indicator');
                        submitButton.disabled = false;
                        
                        if(res.length > 0) {
                            var tr = "";

                            res.forEach(ticket => {
                                tr +=
                                `<tr>
                                    <td class="mw-250px px-5">
                                        <div class="d-flex align-items-center f">
                                            <div class="symbol symbol-50px me-5">
                                                <div class="symbol-label fs-1 fw-bolder bg-white text-primary border">${(ticket.user.name.substr(0, 1))}</div>    
                                            </div>
                                            <div class="d-flex flex-column fw-bold fs-5 text-gray-600 text-dark">
                                                <div class="d-flex align-items-center">
                                                    <a href="/admin/users/view/${ticket.user.id }" class="text-gray-800 fw-bolder text-hover-primary fs-5 me-3">${ticket.user.name}</a>
                                                    <span class="m-0"></span>
                                                </div>
                                                <span class="text-muted fw-bold fs-6">${ticket.created_at}</span>
                                            </div>
                                        </div>
                                        <p class="fw-normal fs-5 text-gray-700 m-0 overflow-hidden mh-sm-45px text-truncate mt-5 px-10">${ticket.description}</p>
                                    </td>
                                    <td class="vertical-align-end text-end px-5" style="vertical-align: baseline">
                                        <div>
                                            <a href="/admin/ticket/view/${ticket.id}" class="btn btn-color-gray-400 btn-active-color-primary p-0 fw-bolder">{{__('form.Reply') }}</a>
                                        </div>
                                        <div class="badge badge-light-danger mt-10" style="top: -1rem; left: 1rem;">${ticket.ticket_status.option}</div>
                                        <div>
                                            <sub style="top: 1rem">${ticket.number}</sub>
                                        </div>
                                    </td>
                                </tr>`
                            });
                        
                        
                            $("tbody").html(tr)
                            
                        }else {
                            $("tbody").html("<tr><td class='text-center'>No data found</td></tr>")
                        }
                    }, 2000);

                }
            })
        });

        $(form.querySelector("[name='searchVal']")).keyup(function() {
            if(this.value == "") {
                $("tbody").html("");
            }
        });
    </script>
@endsection