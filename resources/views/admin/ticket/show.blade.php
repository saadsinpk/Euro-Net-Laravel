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
                    <!--begin::Content-->
                    <div class="flex-lg-row-fluid me-xl-15 mb-20 mb-xl-0">
                        <!--begin::Ticket view-->
                        <div class="mb-0">
                            <!--begin::Heading-->
                            <div class="d-flex align-items-center mb-12">
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
                                        {{ $ticket->subject }}
                                        <span class="badge badge-light-danger position-relative" style="top: -1rem; left: 1rem;">{{ $ticket->ticket_status->option }}</span>
                                    </h1>
                                    <!--end::Title-->
                                    <!--begin::Info-->
                                    <div class="">
                                        <!--begin::Label-->
                                        <span class="fw-bold text-muted me-6">{{__('panel.Category') }}:
                                        <a href="#" class="text-muted text-hover-primary">{{ $ticket->category->name }}</a></span>
                                        <!--end::Label-->
                                        <!--begin::Label-->
                                        <span class="fw-bold text-muted me-6">{{__('form.By') }}:
                                        <a href="#" class="text-muted text-hover-primary">{{ $ticket->user->email }}</a></span>
                                        <!--end::Label-->
                                        <!--begin::Label-->
                                        <span class="fw-bold text-muted">{{__('form.Created Date') }}:
                                       {{ $ticket->created_at->format("d M Y, g:i A") }}</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Content-->
                            </div>
                            <sub class="float-end">{{ $ticket->number }}</sub>
                            <!--end::Heading-->
                            <!--begin::Details-->
                            <div>
                                {{ $ticket->numer }}
                                <!--begin::Description-->
                                <div class="mb-5 fs-5 fw-normal text-gray-800 border-bottom border-gray-300 border-bottom-dashed">
                                    <!--begin::Text-->
                                    <div class="mb-5">{{ $ticket->description }}</div>

                                    <div class="mb-10">

                                        @if($ticket->file_name)
                                        <div class="mb-5">
                                            <h4 class="fw-bold text-gray-800 me-6">{{__('form.Attached files') }}</h4>
                                            @foreach (explode(",", $ticket->file_name) as $name)

                                                <div>
                                                    <a href="{{ asset("public/uploads/attached/".$name. "") }}" download="{{ $name }}"><i class="fas fa-paperclip me-2"></i>{{ $name }}</a>
                                                </div>
                                                
                                            @endforeach
                                        </div>
                                        @endif

                                    </div>

                                    <div>
                                        @if($paymentRequest->count() > 0) 
                                            <h3>{{ __('form.Payment Request') }}</h3>
                                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_admins_table">
                                                <!--begin::Table head-->
                                                <thead>
                                                    <!--begin::Table row-->
                                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                        <th class="min-w-125px">{{__('form.Date') }}</th>
                                                        <th class="min-w-125px">{{__('form.Description') }}</th>
                                                        <th class="min-w-125px">{{__('form.status') }}</th>
                                                        <th class="min-w-125px">{{__('form.Amount') }}</th>
                                                    </tr>
                                                    <!--end::Table row-->
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody class="fw-bold text-gray-600">
                                                    @foreach ($paymentRequest as $p)
                                                       <tr>
                                                           <td>{{ $p->created_at->format("d M Y, g:i A")}}</td>
                                                           <td>{{ $p->description }}</td>
                                                           <td></td>
                                                           <td>{{ $p->amount }}</td>
                                                       </tr>
                                                    @endforeach
                                                </tbody>
                                                <!--end::Table body-->
                                            </table>
                                        @endif
                                    </div>

                                    <div class="separator separator-dashed mb-7"></div>

                                    @foreach($ticket->reply as $reply)
                                   
                                        <div class="mb-5">
                                            <div class="overflow-hidden position-relative card-rounded  @if($reply->user->roles->first()->name == "admin") col-md-5 ms-auto @else col-md-8 @endif">
                                                <div class="card card-bordered w-100 @if($reply->user->roles->first()->name == "admin") bg-light-success @else bg-light-primary @endif">
                                                    <div class="card-body">
                                                        {{ $reply->description }}
                                                    </div>
                                                </div>
                                                <!--end::Card-->
                                                <div>
                                                    @foreach (explode(",", $reply->file_name) as $name)
                                                        @if($name)
        
                                                        <div>
                                                            <a href="{{ asset("public/uploads/attached/".$name. "") }}" download="{{ $name }}"><i class="fas fa-paperclip me-2"></i>{{ $name }}</a>
                                                        </div>
                                                        
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="text-gray-400 @if($reply->user->roles->first()->name == "admin") text-end @endif mt-2 fs-8">{{ $reply->created_at->format("d M Y, g:i A") }}</div>
                                        </div>

                                    @endforeach 

                                </div>
                                <!--end::Description-->


                                <!--begin::Input group-->
                                    <div class="mb-0 fv-row">
                                        <form action="{{ url("admin/ticket/send-answer") }}" id="ticket_reply_form">
                                            <div class="mb-3 w-25 d-flex justify-content-end ms-auto">
                                                <select class="form-select form-select-solid fw-bolder" name="status" data-kt-select2="true" data-placeholder="Select status">
                                                    <option></option>
                                                    @foreach($ticket_status as $status)

                                                    @php $selected = ""; @endphp
                                                    @if($status->id == $ticket->ticket_status->id)
                                                        @php echo $selected = "selected"; @endphp
                                                    @endif

                                                    <option @php echo $selected; @endphp value="{{ $status->id }}">{{ $status->option }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
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

                                            <textarea class="form-control form-control-solid placeholder-gray-600 fw-bolder fs-4 ps-9 pt-7" rows="6" name="description" placeholder="Send Message"></textarea>
                                            <!--begin::Submit-->
                                            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                                            <div class="d-flex gap-5 align-items-center justify-content-end">
                                                <div class="mt-3 text-end">
                                                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_payment_modal">
                                                        <span class="indicator-label">Send Amount</span>
                                                        <span class="indicator-progress">Please wait...
                                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </a> 
                                                </div>
    
                                                <div class="mt-3 text-end">
                                                    <button data-action="submit" type="submit" class="btn btn-primary">
                                                        <span class="indicator-label">Send</span>
                                                        <span class="indicator-progress">Please wait...
                                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button> 
                                                </div>
                                            </div>
                                        </form>
                                        <!--end::Submit-->
                                    </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Details-->
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

    <div class="modal fade" id="kt_payment_modal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Form-->
                <form class="form" action="{{ url('/admin/send-paymentRequest') }}" >
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
                                    <input type="text" disabled value="$" class="form-control mw-40px bg-light-primary form-control-solid">
                                    <input type="number" class="form-control form-control-solid" placeholder="" name="amount" value="" />
                                    <input type="text" disabled value="USD" class="form-control mw-60px text-white bg-primary form-control-solid">
                                </div>
                                
                                <!--end::Input-->
                            </div>

                            <div class="fv-row mb-7">
                                <textarea name="description"  rows="4" class="form-control form-control-solid" placeholder="description"></textarea>
                            </div>
                            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                            <input type="hidden" name="user_id" value="{{ $ticket->user->id }}">
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

</div>
@endsection

@section('after_script')
    <script src="{{ asset('public/assets/js/custom/apps/support-center/tickets/send_answer.js') }}"></script>
    <script src="{{ asset('public/assets/js/custom/apps/support-center/tickets/payment.js') }}"></script>
@endsection