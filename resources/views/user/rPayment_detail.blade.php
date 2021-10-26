@extends("layouts.user")

@section("content")
    	<!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl">
                <!--begin::Hero card-->
                <div class="card mb-12 px-10">
                    <!--begin::Hero body-->
                    <div class="card-body flex-column p-5">
                        <div class="d-flex flex-column align-items-start justify-content-center flex-equal me-5">
                            <div class="d-flex justify-content-between align-items-center w-100">
                                <!--begin::Title-->
                                <h1 class="fw-bolder fs-4 fs-lg-1 text-gray-800">{{__('ticket.Support Center') }}</h1>
                                <!--end::Title-->

                                <a href="{{ url("/") }}" class="btn btn-light-primary">{{__('form.Back') }}</a>
                            </div>
                            <!--begin::Input group-->
                            <div class="position-relative w-100 p-10 justify-content-between">
                               <div>
                                    <h3>{{ __('form.Payment Request') }}</h3>
                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_admins_table">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-125px">{{__('form.Date') }}</th>
                                                <th class="min-w-125px">{{__('form.Description') }}</th>
                                                <th class="min-w-125px">{{__('form.Amount') }}</th>
                                                <th class="text-end min-w-70px">{{__('form.Actions') }}</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600">
                                            @foreach ($rPayment->request as $p)
                                                <tr>
                                                    <td>{{ $p->created_at->format("d M Y, g:i A")}}</td>
                                                    <td>{{ $p->description }}</td>
                                                    <td>
                                                    <span class="fs-5 fw-bolder d-flex justify-content-center">$
                                                        {{ $p->amount }}
                                                    </span>
                                                    </td>
                                                    <td class="text-end">
                                                        @if($p->status == 0)
                                                            <a  data-bs-toggle="modal" data-id="{{ $p->id }}" data-bs-target="#kt_payment_modal"  data-kt-table-filter="pay_modal_button" class="btn btn-sm btn-light-primary">{{__('form.Pay') }}</a>
                                                        @else 
                                                            <span class="badge badge-light-success">Paid</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <!--end::Hero body-->
                </div>
                <!--end::Hero card-->
              
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
        <div class="modal fade" id="kt_payment_modal" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Form-->
                    <form role="form" action="{{ route('stripe.payment') }}" method="post" class="validation" data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
                        <!--begin::Modal header-->
                        <div class="modal-header" id="kt_payment_modal_header">
                            <!--begin::Modal title-->
                            <h2 class="fw-bolder">{{__('form.Payment Details') }}</h2>
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
                              
                                    <div class='form-row row'>
                                        <div class='col-xs-12 form-group required fv-row'>
                                            <label class='control-label'>Name on Card</label> 
                                            <input class='form-control' name="card_name" size='4' type='text'>
                                        </div>
                                    </div>
            
                                    <div class='form-row row'>
                                        <div class='col-xs-12 form-group card required fv-row'>
                                            <label class='control-label'>Card Number</label> 
                                            <input autocomplete='off' name="card_number" class='form-control card-num' size='20' type='text'>
                                        </div>
                                    </div>
            
                                    <div class='form-row row'>
                                        <div class='col-xs-12 col-md-4 form-group cvc required fv-row'>
                                            <label class='control-label'>CVC</label> 
                                            <input autocomplete='off' name="card_cvc" class='form-control card-cvc' placeholder='e.g 415' size='4' type='text'>
                                        </div>
                                        <div class='col-xs-12 col-md-4 form-group expiration required fv-row'>
                                            <label class='control-label'>Expiration Month</label> <input name="card-expiry-month" class='form-control card-expiry-month' placeholder='MM' size='2' type='text'>
                                        </div>
                                        <div class='col-xs-12 col-md-4 form-group expiration required fv-row'>
                                            <label class='control-label'>Expiration Year</label> <input
                                                class='form-control card-expiry-year' name="card-expiry-year" placeholder='YYYY' size='4'
                                                type='text'>
                                        </div>
                                    </div>
                          
                                <!--end::Input group-->
                            </div>
                            <!--end::Scroll-->
                        </div>
                        <!--end::Modal body-->
                        <!--begin::Modal footer-->
                        <div class="modal-footer flex-center">
                            <!--begin::Button-->
                            <button type="reset" data-action="cancel" class="btn btn-light me-3">{{__('form.Discard') }}</button>
                            <!--end::Button-->
                            <button type="submit" data-action="submit" class="btn btn-warning btn-lg btn-block" type="submit">
                               
                                <span class="indicator-label"> {{__('form.Pay Now') }} (<span id="amount"></span>)</span>
                                <input type="hidden" name="amount">
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

        <div class="modal fade" id="kt_payment_modal" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Form-->
                    <form role="form" action="{{ route('stripe.payment') }}" method="post" class="validation" data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
                        <!--begin::Modal header-->
                        <div class="modal-header" id="kt_payment_modal_header">
                            <!--begin::Modal title-->
                            <h2 class="fw-bolder">{{__('form.Payment Details') }}</h2>
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
                              
                                    <div class='form-row row'>
                                        <div class='col-xs-12 form-group required fv-row'>
                                            <label class='control-label'>Name on Card</label> 
                                            <input class='form-control' name="card_name" size='4' type='text'>
                                        </div>
                                    </div>
            
                                    <div class='form-row row'>
                                        <div class='col-xs-12 form-group card required fv-row'>
                                            <label class='control-label'>Card Number</label> 
                                            <input autocomplete='off' name="card_number" class='form-control card-num' size='20' type='text'>
                                        </div>
                                    </div>
            
                                    <div class='form-row row'>
                                        <div class='col-xs-12 col-md-4 form-group cvc required fv-row'>
                                            <label class='control-label'>CVC</label> 
                                            <input autocomplete='off' name="card_cvc" class='form-control card-cvc' placeholder='e.g 415' size='4' type='text'>
                                        </div>
                                        <div class='col-xs-12 col-md-4 form-group expiration required fv-row'>
                                            <label class='control-label'>Expiration Month</label> <input name="card-expiry-month" class='form-control card-expiry-month' placeholder='MM' size='2' type='text'>
                                        </div>
                                        <div class='col-xs-12 col-md-4 form-group expiration required fv-row'>
                                            <label class='control-label'>Expiration Year</label> <input
                                                class='form-control card-expiry-year' name="card-expiry-year" placeholder='YYYY' size='4'
                                                type='text'>
                                        </div>
                                    </div>
                          
                                <!--end::Input group-->
                            </div>
                            <!--end::Scroll-->
                        </div>
                        <!--end::Modal body-->
                        <!--begin::Modal footer-->
                        <div class="modal-footer flex-center">
                            <!--begin::Button-->
                            <button type="reset" data-action="cancel" class="btn btn-light me-3">{{__('form.Discard') }}</button>
                            <!--end::Button-->
                            <button type="submit" data-action="submit" class="btn btn-warning btn-lg btn-block" type="submit">
                                <span class="indicator-label"> {{__('form.Pay Now') }} (<span>$</span> <span id="amount"></span>)</span>
                                <input type="hidden" name="amount">
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
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script src="{{ asset('public/assets/js/custom/apps/support-center/tickets/stripe.js') }}"></script>
@endsection