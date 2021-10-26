@extends("layouts.app")

@section("content")
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Card-->
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <input type="text" data-kt-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="{{__('form.Search tickets') }}" />
                    </div>
                    <!--end::Search-->
                </div>
            </div>
            <!--begin::Card body-->
            <div class="card-body">
                <!--begin::Layout-->
                <div class="d-flex flex-xl-row" data-select2-id="select2-data-94-ui9n">
                    <div class="w-100">
                        <table class="table align-middle table-row-dashed gy-5" id="ticket_table">
                            <thead>
                                <th></th>
                                <th></th>
                            </thead>
                            <tbody class="fs-6 fw-bold text-gray-600">
                                @foreach ($tickets as $ticket)
                                <tr>
                                    <td class="mw-250px">
                                        <div class="d-flex align-items-center f">
                                            <!--begin::Author-->
                                            <div class="symbol symbol-50px me-5">
                                                <div class="symbol-label fs-1 fw-bolder bg-white text-primary border">{{ substr($ticket->user->name, 0, 1) }}</div>    
                                            </div>
                                            <!--end::Author-->
                                            <!--begin::Info-->
                                            <div class="d-flex flex-column fw-bold fs-5 text-gray-600 text-dark">
                                                <!--begin::Text-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Username-->
                                                    <a href="{{ url("admin/users/view/".$ticket->user->id."") }}" class="text-gray-800 fw-bolder text-hover-primary fs-5 me-3">{{ $ticket->user->name }}</a>
                                                    <!--end::Username-->
                                                    <span class="m-0"></span>
                                                </div>
                                                <!--end::Text-->
                                                <!--begin::Date-->
                                                <span class="text-muted fw-bold fs-6">{{ $ticket->created_at->format("d M Y, g:i A") }}</span>
                                                <!--end::Date-->
                                            </div>
                                            <!--end::Info-->
                                        </div>
                                        <p class="fw-normal fs-5 text-gray-700 m-0 overflow-hidden mh-sm-45px text-truncate mt-5 px-10">{{ $ticket->description }}</p>
                                    </td>
                                    <td class="vertical-align-end text-end" style="vertical-align: baseline">
                                        <div>
                                            <a href="{{ url("admin/ticket/view/".$ticket->id."") }}" class="btn btn-color-gray-400 btn-active-color-primary p-0 fw-bolder">{{__('form.Reply') }}</a>|
                                            <a href="{{ url("admin/ticket/delete/".$ticket->id."") }}" class="btn btn-color-gray-400 btn-active-color-primary p-0 fw-bolder">{{__('form.Delete') }}</a>
                                        </div>
                                        <div class="badge badge-light-danger mt-10" style="top: -1rem; left: 1rem;">{{ $ticket->ticket_status->option }}</div>
                                        <div>
                                            <sub style="top: 1rem">{{ $ticket->number }}</sub>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--end::Layout-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
@endsection

@section('after_script')
<script>
    console.log($("#ticket_table"))
    var datatable = $("#ticket_table").DataTable({
        "info": false,
        'order': [],
        'pageLength': 5,
    });

    const filterSearch = document.querySelector('[data-kt-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();
    });

</script>
@endsection

