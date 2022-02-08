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
                        <input type="text" data-kt-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="{{__('form.Search') }}..." />
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
                                @foreach ($payments as $payment)
                                    @if(isset($payment->user->name))
                                        <tr style="@if($payment->ischecked == 0) background: #ebebeb8c; border-color: #009ef7; @endif">
                                            <td class="mw-250px px-5">
                                                <div class="d-flex align-items-center f">
                                                    <!--begin::Author-->
                                                    <div class="symbol symbol-50px me-5">
                                                        <div class="symbol-label fs-1 fw-bolder bg-white text-primary border">{{ substr($payment->user->name, 0, 1) }}</div>    
                                                    </div>
                                                    <!--end::Author-->
                                                    <!--begin::Info-->
                                                    <div>
                                                        <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                                                            <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                            <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                                            <span class="svg-icon svg-icon-4 me-1">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                    <path opacity="0.3" d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM12 7C10.3 7 9 8.3 9 10C9 11.7 10.3 13 12 13C13.7 13 15 11.7 15 10C15 8.3 13.7 7 12 7Z" fill="black"></path>
                                                                    <path d="M12 22C14.6 22 17 21 18.7 19.4C17.9 16.9 15.2 15 12 15C8.8 15 6.09999 16.9 5.29999 19.4C6.99999 21 9.4 22 12 22Z" fill="black"></path>
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->{{ $payment->user->name }}</a>
                                                            <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                            <!--begin::Svg Icon | path: icons/duotune/general/gen018.svg-->
                                                            <span class="svg-icon svg-icon-4 me-1">
                                                                <i class="fas fa-phone-alt"></i>
                                                            </span>
                                                            <!--end::Svg Icon-->{{ $payment->user->phone }}</a>
                                                            <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                                            <!--begin::Svg Icon | path: icons/duotune/communication/com011.svg-->
                                                            <span class="svg-icon svg-icon-4 me-1">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                    <path d="M13 5.91517C15.8 6.41517 18 8.81519 18 11.8152C18 12.5152 17.9 13.2152 17.6 13.9152L20.1 15.3152C20.6 15.6152 21.4 15.4152 21.6 14.8152C21.9 13.9152 22.1 12.9152 22.1 11.8152C22.1 7.01519 18.8 3.11521 14.3 2.01521C13.7 1.91521 13.1 2.31521 13.1 3.01521V5.91517H13Z" fill="black"></path>
                                                                    <path opacity="0.3" d="M19.1 17.0152C19.7 17.3152 19.8 18.1152 19.3 18.5152C17.5 20.5152 14.9 21.7152 12 21.7152C9.1 21.7152 6.50001 20.5152 4.70001 18.5152C4.30001 18.0152 4.39999 17.3152 4.89999 17.0152L7.39999 15.6152C8.49999 16.9152 10.2 17.8152 12 17.8152C13.8 17.8152 15.5 17.0152 16.6 15.6152L19.1 17.0152ZM6.39999 13.9151C6.19999 13.2151 6 12.5152 6 11.8152C6 8.81517 8.2 6.41515 11 5.91515V3.01519C11 2.41519 10.4 1.91519 9.79999 2.01519C5.29999 3.01519 2 7.01517 2 11.8152C2 12.8152 2.2 13.8152 2.5 14.8152C2.7 15.4152 3.4 15.7152 4 15.3152L6.39999 13.9151Z" fill="black"></path>
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->{{ $payment->serial_num }}</a>
                                                        </div>
                                                        <div class="text-muted fw-bold fs-6">{{ $payment->created_at->format("d M Y, g:i A") }}</div>
                                                        <div class="text-muted fs-7">Address : 
                                                        @if($payment->address != '' AND $payment->street == '')
                                                            {{ $payment->address }}
                                                        @else
                                                            {{ $payment->street }}<br>{{ $payment->city }}<br>{{ $payment->country }}<br>{{ $payment->postalcode }}
                                                        @endif</div>
                                                    </div>
                                                </div>
                                                <p class="fw-normal fs-5 text-gray-700 m-0 overflow-hidden mh-sm-45px mt-5 px-10">{{ $payment->problem }}</p>
                                            </td>
                                            <td class="vertical-align-end text-end px-5" style="vertical-align: baseline">
                                                <div>
                                                    <a href="{{ url("admin/repair/view/".$payment->id."") }}" class="btn btn-color-gray-400 btn-active-color-primary p-0 fw-bolder">{{__('form.Reply') }}</a>|
                                                    @if(isset($admin_access['delete_repair']))
                                                        <a href="{{ url("admin/repair/delete/".$payment->id."") }}" class="btn btn-color-gray-400 btn-active-color-primary p-0 fw-bolder delete_this">{{__('form.Delete') }}</a>|
                                                    @endif
                                                    @if(isset($admin_access['edit_repair']))
                                                        <a href="{{ url("admin/repair/edit/".$payment->id."") }}" class="btn btn-color-gray-400 btn-active-color-primary p-0 fw-bolder">{{__('form.Edit') }}</a>
                                                    @endif
                                                </div>

                                                <div class="mb-3 w-25 d-flex justify-content-end ms-auto mt-3">
                                                    <select data-id="{{ $payment->id }}" class="form-select form-select-sm form-select-solid fw-bolder min-w-150px" name="status" data-placeholder="Select status">
                                                        @foreach($repair_status as $status)

                                                        @php $selected = ""; @endphp
                                                        @if($status->id == $payment->status)
                                                            @php echo $selected = "selected"; @endphp
                                                        @endif

                                                        <option @php echo $selected; @endphp value="{{ $status->id }}" data-color="{{$status->color}}">{{ $status->option }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="d-flex gap-5 justify-content-end mt-3">
                                                    @if(isset($admin_access['send_repair_payment']))
                                                        <div class="">
                                                            <a class="btn btn-light-primary btn-sm" data-action='send_payment' data-id="{{ $payment->id }}" data-user-id="{{ $payment->user_id }}" data-bs-toggle="modal" data-bs-target="#kt_payment_modal">
                                                                <span class="indicator-label">Send Amount</span>
                                                                <span class="indicator-progress">Please wait...
                                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                            </a> 
                                                        </div>
                                                    @endif

                                                    @if(isset($admin_access['view_invoice']))
                                                        @if($payment->request->count() >= 1)
                                                            <div>
                                                                <a href="{{ url('admin/invoice') }}" class="btn btn-light btn-sm">View invoice</a>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>

                                                <div class="badge mt-3" style="background:{{ $payment->repairStatus->color }}; top: -1rem; left: 1rem;">{{ $payment->repairStatus->option }}</div>

                                                <div>
                                                    <sub style="top: 1rem">{{ $payment->number }}</sub>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
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

@if(isset($admin_access['send_repair_payment']))
    <div class="modal fade" id="kt_payment_modal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Form-->
                <form class="form" action="{{ url('/admin/repair/paymentRequest') }}" >
                    <!--begin::Modal header-->
                    <div class="modal-header" id="kt_payment_modal_header">
                        <!--begin::Modal title-->
                        <h2 class="fw-bolder">{{__('form.Send payment request') }}</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div data-action="close" class="btn btn-icon btn-sm btn-active-icon-primary">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body py-10 px-lg-17">
                        <!--begin::Scroll-->
                        <div class="scroll-y me-n7 pe-7" id="kt_payment_modal_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_payment_modal" data-kt-scroll-wrappers="#kt_payment_modal_scroll" data-kt-scroll-offset="300px">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-bold mb-2">{{__('form.Amount') }}</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="input-group">
                                    <input type="number" class="form-control form-control-solid" placeholder="" name="amount" value="" />
                                    <div class="min-w-50px">
                                        <select  class="form-select form-select-solid" name="currency" data-kt-select2="true" data-placeholder="Select currency">
                                            <option value="eur" class="text-white">EUR</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!--end::Input-->
                            </div>

                            <div class="fv-row mb-7">
                                <textarea name="description"  rows="4" class="form-control form-control-solid" placeholder="description"></textarea>
                            </div>
                        </div>
                        <!--end::Scroll-->
                    </div>
                    <!--end::Modal body-->
                    <!--begin::Modal footer-->
                    <div class="modal-footer flex-center">
                        <!--begin::Button-->
                        <button type="reset" data-action="cancel" class="btn btn-light me-3">{{__('form.Discard') }}</button>
                        <!--end::Button-->
                        <!--begin::Button-->
                        <button data-action="submit" type="submit" class="btn btn-primary">
                            <span class="indicator-label">{{__('form.Send') }}</span>
                            <span class="indicator-progress">{{__('form.Please wait...') }}
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <!--end::Button-->
                    </div>
                    <!--end::Modal footer-->
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
@endif

@endsection

@section('after_script')
<script>
    var datatable = $("table").DataTable({
        "info": false,
        'order': [],
        'pageLength': 5,
    });

    const filterSearch = document.querySelector('[data-kt-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
        datatable.search(e.target.value).draw();
    });

</script>
<script src="{{ asset('public/assets/js/custom/apps/support-center/tickets/payment.js') }}"></script>
@endsection

