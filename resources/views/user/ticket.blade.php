@extends("layouts.user")

@section("content")
    	<!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl">
                <!--begin::Hero card-->
                <div class="card mb-5">

                    <div class="card-rounded bg-white d-flex flex-stack flex-wrap p-2">
                        <!--begin::Nav-->
                        <ul class="nav flex-wrap border-transparent fw-bolder">
                            <!--begin::Nav item-->

                            <li class="nav-item my-1">
                                <a class="btn btn-color-gray-600 btn-active-white btn-active-color-primary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase active" data-bs-toggle="tab" href="#ticket_home">{{__('ticket.Support center Home') }}</a>
                            </li>

                            <li class="nav-item my-1">
                                <a class="btn btn-color-gray-600 btn-active-white btn-active-color-primary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase" data-bs-toggle="tab" href="#ticket">{{__('ticket.New Ticket') }}</a>
                            </li>

                            <li class="nav-item my-1">
                                <a class="btn btn-color-gray-600 btn-active-white btn-active-color-primary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase" data-bs-toggle="tab" href="#ticket_history">{{__('ticket.My ticket history') }}</a>
                            </li>
                            @if(auth()->user())
                            <li class="nav-item my-1">
                                <a class="btn btn-color-gray-600 btn-active-white btn-active-color-primary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase" data-bs-toggle="tab" href="#ticket_history">{{__('ticket.invoice') }}</a>
                            </li>
                            @endif
                            <!--end::Nav item-->
                        </ul>
                        <!--end::Nav-->
                    </div>
                    
                </div>
                <!--end::Hero card-->
                <!--begin::Row-->
                <div class="tab-content">

                    <div class="tab-pane fade active show" id="ticket_home">
                        <div class="card">
                            <div class="card-body">
                               <!--begin::Wrapper-->
                            <div class="d-flex flex-column align-items-start justift-content-center flex-equal me-5">
                                <input type="hidden" id="user_id" value="{{ auth()->user()}}">
                                <!--begin::Title-->
                                <h1 class="fw-bolder fs-4 fs-lg-1 text-gray-800 mb-5 mb-lg-10">
                                    {{__('ticket.Welcome to the Euronet Support Center.')}}
                                </h1>
                                <p class="fs-5">
                                    {{__('ticket.In order to streamline support requests and better serve you, we utilize a support ticket system. Every support request is assigned a unique ticket number which you can use to track the progress and responses online. For your reference we provide complete archives and history of all your support requests. A valid email address is required to submit a ticket.') }}
                                </p>

                                <p class="fs-5">
                                    {{__('ticket.For refund requests or RMA Refunds please submit always a valid payment receipt and order number so we can localize your purchase.') }}
                                </p>

                                <p class="fs-5">
                                    {{__('ticket.For Website or Server related Issues, please contact our Web-development department.') }}
                                </p>

                                <p class="fs-5">
                                    {{__('ticket.For Repair request of NEW repairs, please do NOT use this ticket system.')}} 
                                    {{__('ticket.This support ticket system is only for pending repairs, or allready received repairs.')}}
                                </p>

                            </div>
                            <!--end::Wrapper-->
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane fade" id="ticket">
                        <div class="card">
                            <div class="card-body">
                                <form id="kt_modal_new_ticket_form" class="form" action="{{ url('user/create-ticket') }}">
                                    <!--begin::Heading-->
                                    <div class="mb-13 text-center">
                                        <!--begin::Title-->
                                        <h1 class="mb-3">{{__('ticket.Create New Ticket') }}</h1>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Heading-->
                                    @if(!auth()->user())
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label class="required fs-6 fw-bold mb-2">{{__('form.Name') }}</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" class="form-control form-control-solid" placeholder="" name="name" value="" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold mb-2">
                                                <span class="required">{{__('form.Email') }}</span>
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Email address must be active"></i>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="email" class="form-control form-control-solid" placeholder="" name="email" value="" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->
                        
                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7" data-kt-password-meter="true">
                                            <!--begin::Wrapper-->
                                            <div class="mb-1">
                                                <!--begin::Label-->
                                                <label class="form-label fw-bolder text-dark fs-6">{{__('form.Password') }}</label>
                                                <!--end::Label-->
                                                <!--begin::Input wrapper-->
                                                <div class="position-relative mb-3">
                                                    <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="password" autocomplete="off" />
                                                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                                        <i class="bi bi-eye-slash fs-2"></i>
                                                        <i class="bi bi-eye fs-2 d-none"></i>
                                                    </span>
                                                </div>
                                                <!--end::Input wrapper-->
                                                <!--begin::Meter-->
                                                <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                                </div>
                                                <!--end::Meter-->
                                            </div>
                                            <!--end::Wrapper-->
                                            <!--begin::Hint-->
                                            <div class="text-muted">{{__('form.Use 8 or more characters with a mix of letters, numbers') }} &amp; symbols.</div>
                                            <!--end::Hint-->
                                        </div>
                                         <!--begin::Input group-->
                                         <div class="fv-row mb-7">
                                            <label class="form-label fw-bolder text-dark fs-6">{{__('form.Confirm Password') }}</label>
                                            <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="confirm-password" autocomplete="off" />
                                        </div>
                                        <!--end::Input group-->
                                    @endif
        
                                    <div class="separator separator-dashed my-3"></div>
        
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <!--begin::Label-->
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                            <span class="required">{{__('form.Subject') }}</span>
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify a subject for your issue"></i>
                                        </label>
                                        <!--end::Label-->
                                        <input type="text" class="form-control form-control-solid" placeholder="{{__('form.Enter your ticket subject') }}" name="subject" />
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <label class="required fs-6 fw-bold mb-2">{{__('form.Categories') }}</label>
                                        <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="{{__('form.Select a category') }}" name="category_id">
                                                <option value=""></option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column mb-8 fv-row">
                                        <label class="fs-6 fw-bold mb-2">{{__('form.Description') }}</label>
                                        <textarea class="form-control form-control-solid" rows="4" name="description" placeholder="{{__('form.Type your ticket description') }}"></textarea>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-8">
                                        <label class="fs-6 fw-bold mb-2">{{__('form.Attachments') }}</label>
                                        <!--begin::Dropzone-->
                                        <div class="dropzone" id="kt_modal_create_ticket_attachments">
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
                                    <!--end::Input group-->
                                    <!--begin::Actions-->
                                    <div class="text-center">
                                        <button type="reset" id="kt_modal_new_ticket_cancel" class="btn btn-light me-3">{{__('form.Cancel') }}</button>
                                        <button type="submit" id="kt_modal_new_ticket_submit" class="btn btn-primary">
                                                <span class="indicator-label">{{__('form.Submit') }}</span>
                                                <span class="indicator-progress">{{__('form.Please wait...') }}
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                    </div>
                                    <!--end::Actions-->
                                </form>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane fade" id="ticket_history">

                        @if(auth()->user())
                        <div class="card">
                            <div class="card-body">
                                <table class="table align-middle table-row-dashed gy-5" id="ticket_history_table">
                                    <!--begin::Table body-->
                                    <tbody class="fs-6 fw-bold text-gray-600">
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                            </div>
                        </div>
                        @else
                            <h3 class="text-gray-400 text-center mt-12">{{__('form.There is no any tickets that you sent') }}</h3>
                        @endif

                    </div>
                </div>
              
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
@endsection

@section('after_script')
    <script src="{{ asset('public/assets/js/custom/apps/support-center/tickets/ticket.js') }}"></script>
@endsection