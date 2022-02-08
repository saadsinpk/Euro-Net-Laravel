@extends("layouts.app")

@section("content")
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card body-->
            <div class="card-body">
                <div class="d-flex flex-column flex-xl-row p-7">
                    <!--begin::Content-->                    <div class="flex-lg-row-fluid me-xl-15 mb-20 mb-xl-0">
                        <!--begin::Ticket view-->
                        <div class="mb-0">
                            <!--begin::Heading-->
                            <div class="d-flex align-items-center mb-3">
                                <!--begin::Icon-->
                                <!--begin::Svg Icon | path: icons/duotune/files/fil008.svg-->
                                <span class="svg-icon svg-icon-4qx svg-icon-success ms-n2 me-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM11.7 17.7L16.7 12.7C17.1 12.3 17.1 11.7 16.7 11.3C16.3 10.9 15.7 10.9 15.3 11.3L11 15.6L8.70001 13.3C8.30001 12.9 7.69999 12.9 7.29999 13.3C6.89999 13.7 6.89999 14.3 7.29999 14.7L10.3 17.7C10.5 17.9 10.8 18 11 18C11.2 18 11.5 17.9 11.7 17.7Z" fill="black"></path>
                                        <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black"></path>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <!--end::Icon-->
                                <!--begin::Content-->
                                <div class="d-flex flex-column">
                                    <!--begin::Title-->
                                    <h1 class="text-gray-800 fw-bold position-relative">
                                        {{ $repair_payment->serial_num }}
                                    </h1>
                                    <!--end::Title-->
                                    <!--begin::Info-->
                                    <div class="">
                                        <!--begin::Label-->
                                        <span class="fw-bold text-muted me-6">{{__('panel.Username') }}:
                                        <a href="#" class="text-muted text-hover-primary">{{ $repair_payment->user->name }}</a></span>
                                        <!--end::Label-->
                                        <!--begin::Label-->
                                        <span class="fw-bold text-muted me-6">{{__('panel.Bitmain') }}:
                                        <a href="#" class="text-muted text-hover-primary">{{ $repair_payment->bitmain->name }}</a></span>
                                        <!--end::Label-->
                                        <!--begin::Label-->
                                        <span class="fw-bold text-muted me-6">{{__('form.By') }}:
                                        <a href="#" class="text-muted text-hover-primary">{{ $repair_payment->user->email }}</a></span>
                                        <!--end::Label-->

                                         <span class="fw-bold text-muted me-6">{{__('form.Phone number') }}:
                                        <a href="#" class="text-muted text-hover-primary">{{ $repair_payment->user->phone }}</a></span>
                                        <!--end::Label-->

                                        <!--begin::Label-->
                                      

                                        <div class="fw-bold text-muted">
                                            <span class="me-6">{{__('form.Address') }}: 
                                                @if($repair_payment->address != '' AND $repair_payment->street == '')
                                                    {{ $repair_payment->address }}
                                                @else
                                                    {{ $repair_payment->street }}, {{ $repair_payment->city }}, {{ $repair_payment->country }}, {{ $repair_payment->postalcode }}
                                                @endif</span>
                                            <span class="me-6">{{__('form.Payment method') }}: {{ $repair_payment->payment_method }}</span>
                                            <span class="fw-bold text-muted">{{__('form.Created Date') }}:
                                                {{ $repair_payment->created_at->format("d M Y, g:i A") }}
                                            </span>
                                        </div>
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <div class="badge mt-10" style="background:{{ $repair_payment->repairStatus->color }}; position:absolute; top: 3rem; right: 3rem;">{{ $repair_payment->repairStatus->option }}</div>
                                <!--end::Content-->
                            </div>

                             <div class="mb-5">
                                {{-- {{ $repair_payment->user->address }} --}}
                            </div>

                            <sub class="float-end">{{ $repair_payment->number }}</sub>
                            <!--end::Heading-->
                            <!--begin::Details-->
                            <div>
                                <!--begin::Description-->
                                <div class="mb-5 fs-5 fw-normal text-gray-800 border-bottom border-gray-300 border-bottom-dashed">

                                    <!--begin::Text-->
                                    <div class="mb-5">{{ $repair_payment->problem }}</div>


                                </div>
                            </div>

                           <form id="repair_payment_form" method="post" class="form" action="{{ url('/admin/repair/edit') }}/{{$repair_payment->id}}">
                                <input type="hidden" name="repair_id" value="{{$repair_payment->id}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <!--begin::Heading-->
                                <div class="mb-13 text-center">
                                    <!--begin::Title-->
                                    <h1 class="mb-3">{{__('form.Edit Repair Request') }}</h1>
                                    <!--end::Title-->
                                </div>
                                
                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold mb-2">
                                            <span class="required">{{__('form.Street') }}</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" placeholder="" name="street"  value="{{ $repair_payment->street }}" />
                                        <!--end::Input-->
                                    </div>

                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold mb-2">
                                            <span class="required">{{__('form.City') }}</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" placeholder="" name="city"  value="{{ $repair_payment->city }}" />
                                        <!--end::Input-->
                                    </div>

                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold mb-2">
                                            <span class="required">{{__('form.Country') }}</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" placeholder="" name="country"  value="{{ $repair_payment->country }}" />
                                        <!--end::Input-->
                                    </div>

                                    <div class="fv-row mb-7">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-bold mb-2">
                                            <span class="required">{{__('form.Postalcode') }}</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" placeholder="" name="postalcode"  value="{{ $repair_payment->postalcode }}" />
                                        <!--end::Input-->
                                    </div>

                                 <div class="d-flex flex-column mb-8 fv-row">
                                    <label class="required fs-6 fw-bold mb-2">{{__('form.Payment method') }}</label>
                                    <select class="form-select form-select-solid" data-hide-search="true" data-placeholder="form.Select a method" name="payment_method">
                                        <option value="card" @if($repair_payment->payment_method == 'card') selected @endif>{{__('form.Card') }}</option>
                                        <option value="bank" @if($repair_payment->payment_method == 'bank') selected @endif>{{__('form.Bank') }}</option>
                                    </select>
                                </div>

                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold mb-2">
                                        <span class="required">{{__('form.Serial number') }}</span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control form-control-solid" placeholder="" name="serial_num" value="{{ $repair_payment->serial_num }}" />
                                    <!--end::Input-->
                                </div>

                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <label class="required fs-6 fw-bold mb-2">{{__('form.Bitmain') }}</label>
                                    <select class="form-select form-select-solid" data-hide-search="true" data-placeholder="Select a bitmain" name="bitmain_id" multiple>
                                            @foreach($bitmain->sortBy('name') as $bit)
                                                <option value="{{ $bit->id }}" @if($repair_payment->bitmain_id == $bit->id) selected @endif>{{ $bit->name }}</option>
                                            @endforeach
                                </select>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <label class="fs-6 fw-bold mb-2">{{__('form.problem') }}</label>
                                    <textarea class="form-control form-control-solid" rows="4" name="problem" placeholder="Type your problem">{{$repair_payment->problem}}</textarea>
                                </div>
                                <!--end::Input group-->
                                <input type="hidden" name="user_id" value="68 ">
                                <!--begin::Actions-->
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">
                                            <span class="indicator-label">{{__('form.Update') }}</span>
                                        </button>
                                </div>
                                <!--end::Actions-->
                            </form>                            
                        </div>
                        <!--end::Ticket view-->
                    </div>
                    <!--end::Content-->
                </div>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->

</div>

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

@endsection

@section('after_script')
    <script src="{{ asset('public/assets/js/custom/apps/support-center/tickets/repair_detail.js') }}"></script>
    <script src="{{ asset('public/assets/js/custom/apps/support-center/tickets/payment.js') }}"></script>
@endsection