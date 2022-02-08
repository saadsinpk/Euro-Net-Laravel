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
                                <div class="row mb-5">
                                
                                    <div class="col-md-3">
                                        <h3>{{__('form.number') }}</h3>
                                        <div class="text-gray-800 fs-6">{{ $rPayment->number }}</div>
                                    </div>

                                    <div class="col-md-3">
                                        <h3>{{__("form.Serial number") }}</h3>
                                        <div class="text-gray-800 fs-6">{{ $rPayment->serial_num }}</div>
                                    </div>

                                     <div class="col-md-3">
                                        <h3>{{__('form.Bitmain') }}</h3>
                                        <div class="text-gray-800 fs-6">{{ $rPayment->bitmain->name }}</div>
                                    </div>
                                     <div class="col-md-3">
                                        <h3>{{__('form.Status') }}</h3>

                                        <div class="text-gray-800 fs-6"><span class="badge text-white" style="background: {{$rPayment->repairStatus->color}};">{{ $rPayment->repairStatus->option }}</span></div>
                                    </div>
                                </div>

                                <div class="row mb-5">
                                
                                    <div class="col-md-6">
                                        <h3>{{__('form.Address') }}</h3>
                                        @if($rPayment->address == '' || $rPayment->street != '')
                                            <div class="text-gray-800 fs-6">{{ $rPayment->street }}<br>{{ $rPayment->city }}<br>{{ $rPayment->country }}<br>{{ $rPayment->postalcode }}</div>
                                        @else
                                            <div class="text-gray-800 fs-6">{{ $rPayment->address }}</div>
                                        @endif
                                    </div>

                                    <div class="col-md-6">
                                        <h3>{{__("form.Payment method") }}</h3>
                                        <div class="text-gray-800 fs-6">{{ $rPayment->payment_method }}</div>
                                    </div>
                                </div>


                                <div class="separator separator-dashed mb-7"></div>

                                <div>
                                    <h3>{{__('form.Problem') }}</h3>
                                    <div class="text-gray-800 fs-6">{{ $rPayment->problem }}</div>
                                </div>
                                <div class="separator separator-dashed mb-7"></div>

                            </div> 

                            @if ($message = Session::get('success'))
                                <div class="success">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif
                             
                             
                            @if ($message = Session::get('error'))
                                <div class="error">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif

                            <div class="position-relative w-100 p-10 justify-content-between">
                               <div>
                                    @if($rPayment->status == '2' || $rPayment->status == '7')
                                        <h3>{{ __('form.Shipping Information') }}</h3>
                                    @endif
                                    @if($rPayment->status == '7')
                                        <b>{{ __('form.Shipping From') }}</b>
                                        <div class="separator separator-dashed mb-7"></div>
                                        @if($rPayment->return_shipping_from != '')
                                            <p>{{$rPayment->return_shipping_from}}</p>
                                        @else
                                            <p>{{ __('form.Waiting for Shipping To Information') }}</p>
                                        @endif
                                        <b>{{ __('form.Shipping To') }}</b>
                                        <div class="separator separator-dashed mb-7"></div>
                                        @if($rPayment->return_shipping_to != '')
                                            <p>{{$rPayment->return_shipping_to}}</p>
                                        @else
                                            <p>{{ __('form.Waiting for Shipping To Information') }}</p>
                                        @endif
                                    @endif
                                    @if($rPayment->status == '2')
                                        <form action="" method="post" id="ship_form">
                                            @csrf
                                            <label>Shipping Company</label>
                                            <input type="text" name="shipping_company" class="form-control form-control-solid placeholder-gray-600" value="{{$rPayment->shipping_company}}">

                                            <div class="separator separator-dashed mb-7"></div>

                                            <label>Shipping Tracking</label>
                                            <input type="text" name="tracking_number" class="form-control form-control-solid placeholder-gray-600" value="{{$rPayment->tracking_number}}">

                                            <div class="separator separator-dashed mb-7"></div>
                                            <a href="{{ asset("storage/attached/".$rPayment->ship_attach. "") }}" download="{{ $rPayment->ship_attach }}"><i class="fas fa-paperclip me-2"></i>{{ $rPayment->ship_attach }}</a>

                                            <div class="separator separator-dashed mb-7"></div>
                                            <!--begin::Dropzone-->
                                            <div class="dropzone" id="shipping_attachments">
                                                <!--begin::Message-->   
                                                <div class="dz-message needsclick align-items-center">
                                                    <!--begin::Icon-->
                                                    <!--begin::Svg Icon | path: icons/duotune/files/fil010.svg-->
                                                    <span class="svg-icon svg-icon-3hx svg-icon-primary">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM16 12.6L12.7 9.3C12.3 8.9 11.7 8.9 11.3 9.3L8 12.6H11V18C11 18.6 11.4 19 12 19C12.6 19 13 18.6 13 18V12.6H16Z" fill="black" />
                                                                <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black" />
                                                            </svg>
                                                        </span>
                                                    <!--end::Svg Icon-->
                                                    <!--end::Icon-->
                                                    <!--begin::Info-->
                                                    <div class="ms-4">
                                                        <h3 class="fs-5 fw-bolder text-gray-900 mb-1">Drop files here or click to upload.</h3>
                                                        <span class="fw-bold fs-7 text-gray-400">1 file</span>
                                                    </div>
                                                    <!--end::Info-->
                                                </div>
                                            </div>
                                            <!--end::Dropzone-->

                                            <div class="mt-3 text-end">
                                                <button data-action="update_shipping" type="submit" class="btn btn-primary" name="update_shipping">
                                                    <span class="indicator-label">Send</span>
                                                </button>
                                            </div>
                                        </form>
                                    @endif
                                    @if($rPayment->status == '2' || $rPayment->status == '7')
                                        <a href="{{url('label/download/'.$repair_payment->id)}}" class="btn btn-primary"  target="_blank">Download LABEL</a>
                                        <div class="separator separator-dashed mb-7"></div>
                                    @endif

                                    <h3>{{ __('form.Payment Request') }}</h3>
                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_admins_table">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-125px">{{__('form.Date') }}</th>
                                                <th class="min-w-125px">{{__('form.Description') }}</th>
                                                <th class="min-w-125px">{{__('form.Amount') }}</th>
                                                <th>{{__('form.status') }}</th>
                                                @if($rPayment->payment_method == "card")
                                                    <th class="text-end min-w-70px">{{__('form.Actions') }}</th>
                                                @endif
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
                                                        <span class="me-1">{{ $p->amount }}</span>
                                                        <span class="text-uppercase"> {{ $p->currency }}</span>
                                                    </td>

                                                     <td>
                                                        @if($p->status > 0)
                                                            <span class="badge badge-light-success">Paid</span>
                                                        @else
                                                            <span class="badge badge-light-danger">Unpaid</span>
                                                        @endif
                                                    </td>

                                                    @if($rPayment->payment_method == "card" AND $p->status != 1)
                                                        <td class="text-end">
                                                            <a href="/user/repair_payment/view/{{$rPayment->id}}/pay/{{ $p->id }}" >{{__('form.Pay') }}</a>
                                                        </td>
                                                    @else
                                                        <td class="text-end">
                                                            <span class="badge badge-light-success">Paid</span>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                </div>
                            </div>


                            <div class="w-100 px-17">
                                <h1 class="text-center mb-4">{{__('form.Repair Reply From support') }}</h1>
                                @foreach($rPayment->reply as $reply)
                                <div class="mb-5">
                                    <div class="overflow-hidden position-relative card-rounded">
                                        <!--begin::Ribbon-->
                                        @if($reply->user->roles->first()->name == "admin")
                                            <div class="ribbon ribbon-triangle ribbon-top-start border-success">
                                                <!--begin::Ribbon icon-->
                                                <div class="ribbon-icon mt-n5 ms-n6">
                                                    <i class="bi bi-check2 fs-2 text-white"></i>
                                                </div>
                                                <!--end::Ribbon icon-->
                                            </div>
                                        @endif
                                        <!--end::Ribbon-->
                                        <!--begin::Card-->
                                        <div class="card card-bordered w-100">
                                            <!--begin::Body-->
                                            <div class="card-body">
                                                {!! nl2br($reply->description) !!} 
                                            </div>
                                            <!--end::Body-->
                                        </div>
                                        <!--end::Card-->
                                    </div>
                                    @foreach (explode(",", $reply->file_name) as $name)
                                        @if($name)

                                        <div>
                                            <a href="{{ asset("storage/attached/".$name. "") }}" download="{{ $name }}"><i class="fas fa-paperclip me-2"></i>{{ $name }}</a>
                                        </div>
                                        
                                        @endif
                                    @endforeach
                                    
                                    <div class="text-gray-400 @if($reply->user->roles->first()->name == "admin") text-end @endif mt-2 fs-8">{{ $reply->created_at->format("d M Y, g:i A") }}</div>
                                </div>
                                @endforeach

                                <form action="{{ url("user/repair_payment/reply") }}" id="repair_form">
                                    <div class="fv-row mb-8">
                                        <textarea class="form-control form-control-solid placeholder-gray-600 fw-bolder fs-4 ps-9 pt-7" rows="6" name="description" placeholder="Send Message"></textarea>
                                        <input type="hidden" name="repair_id" value="{{ $rPayment->id }}">
                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">  
                                    </div>
                                    
                                    <div class="fv-row mb-8">
                                        <label class="fs-6 fw-bold mb-2">Attachments</label>
                                        <!--begin::Dropzone-->
                                        <div class="dropzone" id="attachments">
                                            <!--begin::Message-->
                                            <div class="dz-message needsclick align-items-center">
                                                <!--begin::Icon-->
                                                <!--begin::Svg Icon | path: icons/duotune/files/fil010.svg-->
                                                <span class="svg-icon svg-icon-3hx svg-icon-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM16 12.6L12.7 9.3C12.3 8.9 11.7 8.9 11.3 9.3L8 12.6H11V18C11 18.6 11.4 19 12 19C12.6 19 13 18.6 13 18V12.6H16Z" fill="black" />
                                                            <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black" />
                                                        </svg>
                                                    </span>
                                                <!--end::Svg Icon-->
                                                <!--end::Icon-->
                                                <!--begin::Info-->
                                                <div class="ms-4">
                                                    <h3 class="fs-5 fw-bolder text-gray-900 mb-1">Drop files here or click to upload.</h3>
                                                    <span class="fw-bold fs-7 text-gray-400">Upload up to 10 files</span>
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                        </div>
                                        <!--end::Dropzone-->
                                    </div>
                                    
                                    <div class="text-end mt-3">
                                        <button data-action="submit" type="submit" class="btn btn-primary">
                                            <span class="indicator-label">{{__('form.Send') }}</span>
                                            <span class="indicator-progress">{{__("form.Please wait...") }}
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>
                                    </div>
                                </form>
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
                                <input type="hidden" name="ticketid" value="{{ $rPayment->number }}">
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
    <script type="text/javascript">var publishable_key = '{{ env('STRIPE_PUBLISHABLE_KEY') }}';</script>
    <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
    <script src="{{ asset('public/assets/js/custom/apps/support-center/tickets/repair_detail.js') }}"></script>
@endsection