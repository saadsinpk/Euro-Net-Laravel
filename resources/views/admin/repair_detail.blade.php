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
                                            <span class="me-6">{{__('form.Address') }}: {{ $repair_payment->address }}</span>
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


                                    <div class="separator separator-dashed mb-7"></div>

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
                                                @if($repair_payment->payment_method == "card")
                                                    <th class="text-end min-w-70px">{{__('form.Actions') }}</th>
                                                @endif
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600">
                                            @foreach ($repair_payment->request as $p)
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

                                                    @if($repair_payment->payment_method == "card" AND $p->status != 1)
                                                        <td class="text-end">
                                                            <a  data-bs-toggle="modal" data-id="{{ $p->id }}" data-bs-target="#kt_payment_modal"  data-kt-table-filter="pay_modal_button" class="btn btn-sm btn-light-primary">{{__('form.Pay') }}</a>
                                                        </td>
                                                    @else
                                                        <td class="text-end">
                                                            @if($p->status > 0)
                                                                <a href='{{ url("admin/repair/unpaid/".$p->id."") }}' class="badge badge-light-success">UnPaid</a>
                                                            @else
                                                                <a href='{{ url("admin/repair/paid/".$p->id."") }}' class="badge badge-light-success">Paid</a>
                                                            @endif
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>

                                    <div class="separator separator-dashed mb-7"></div>

                                    @foreach($repair_payment->reply as $reply)
                                   
                                        <div class="mb-5">
                                            <div class="overflow-hidden position-relative card-rounded  @if($reply->user->roles->first()->name == "admin") col-md-5 ms-auto @else col-md-8 @endif">
                                                <div class="card card-bordered w-100 @if($reply->user->roles->first()->name == "admin") bg-light-success @else bg-light-primary @endif">
                                                    <div class="card-body">
                                                        {!! nl2br($reply->description) !!} 
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

                                            <div class="text-gray-400 @if($reply->user->roles->first()->name == "admin") text-end @endif mt-2 fs-8">{{ $reply->created_at->format("d M Y, g:i A") }} @if($reply->user->roles->first()->name == "admin") <a href="/admin/repair/view/{{$repair_payment->id}}/delete/{{$reply->id}}">Delete</a> | <a href="/admin/repair/view/{{$repair_payment->id}}/edit/{{$reply->id}}">Edit</a> @endif</div>
                                        </div>

                                    @endforeach 

                                </div>
                                <!--end::Description-->


                                <!--begin::Input group-->
                                <div class="mb-0 fv-row">
                                    @if(isset($ticket_edit))
                                        <form action="{{ url("admin/repair_payment/update_reply") }}" id="repair_form">
                                            <input type="hidden" name="id" value="{{$ticket_edit->id}}">
                                    @else
                                        <form action="{{ url("admin/repair_payment/reply") }}" id="repair_form">
                                    @endif
                                        <div class="fv-row mb-8">
                                            <label class="fs-6 fw-bold mb-2">{{__('form.Attachments') }}</label>
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

                                        @if(isset($ticket_edit))
                                            <textarea class="form-control form-control-solid placeholder-gray-600 fw-bolder fs-4 ps-9 pt-7" rows="6" name="description" placeholder="Send Message">{{$ticket_edit->description}}</textarea>
                                        @else
                                            <textarea class="form-control form-control-solid placeholder-gray-600 fw-bolder fs-4 ps-9 pt-7" rows="6" name="description" placeholder="Send Message"></textarea>
                                        @endif
                                        <!--begin::Submit-->
                                        <input type="hidden" name="repair_id" value="{{ $repair_payment->id }}">
                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                                        <div class="d-flex gap-5 align-items-center justify-content-end">
                                            
                                            <div class="mt-3">
                                                <a class="btn btn-light-warning" data-action='send_payment' data-id="{{ $repair_payment->id }}" data-user-id="{{ $repair_payment->user_id }}" data-bs-toggle="modal" data-bs-target="#kt_payment_modal">
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

@endsection

@section('after_script')
    <script src="{{ asset('public/assets/js/custom/apps/support-center/tickets/repair_detail.js') }}"></script>
    <script src="{{ asset('public/assets/js/custom/apps/support-center/tickets/payment.js') }}"></script>
@endsection