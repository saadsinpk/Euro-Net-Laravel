@extends("layouts.app")
@section("content")
<!--begin::Post-->
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
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
                        <input type="text" data-kt-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="{{__('form.Search') }}..." />
                    </div>
                    <!--end::Search-->
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="invoiceTable">
                    <!--begin::Table head-->
                    <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                            <th class="min-w-125px">{{__('form.ticket number') }}</th>
                            <th class="min-w-125px">{{__('form.status') }}</th>
                            <th class="min-w-125px">{{__('form.customer') }}</th>
                            <th class="min-w-125px">{{__('form.Date') }}</th>
                            <th class="text-end min-w-70px">{{__('form.Amount') }}</th>
                        </tr>
                        <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="fw-bold text-gray-600">
                        @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->repairPayment->number }}</td>
                                <td>
                                    @if($invoice->status == 0)
                                        <span class="badge badge-light-danger">Unpaid</span>
                                    @else
                                        <span class="badge badge-light-success">Paid</span>
                                    @endif
                                </td>
                                <td>{{ $invoice->user->name }}</td>
                                <td>{{ $invoice->created_at->format("d M Y, g:i A"); }}</td>
                                <td class="text-end"><span>$</span>{{ $invoice->amount }} <span>USD</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
    </div>
    <!--end::Container-->
</div>
<!--end::Post-->
@endsection

@section("after_script")
    <script>
        console.log($("#invoiceTable"))
        var datatable = $("#invoiceTable").DataTable({
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