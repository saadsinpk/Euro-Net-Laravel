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
                                                    <a href="{{ asset("storage/attached/".$name. "") }}" download="{{ $name }}"><i class="fas fa-paperclip me-2"></i>{{ $name }}</a>
                                                </div>
                                                
                                            @endforeach
                                        </div>
                                        @endif

                                    </div>

                                    <div class="separator separator-dashed mb-7"></div>

                                    @foreach($ticket->reply as $reply)
                                   
                                        <div class="mb-5">
                                            <div class="overflow-hidden position-relative card-rounded @if(isset($reply->user->roles)) @if($reply->user->roles->first()->name == "admin") col-md-5 ms-auto @else col-md-8 @endif @endif">
                                                <div class="card card-bordered w-100 @if(isset($reply->user->roles)) @if($reply->user->roles->first()->name == "admin") bg-light-success @else bg-light-primary @endif @endif">
                                                    <div class="card-body">
                                                        {!! nl2br($reply->description) !!} 
                                                    </div>
                                                </div>
                                                <!--end::Card-->
                                                <div>
                                                    @foreach (explode(",", $reply->file_name) as $name)
                                                        @if($name)
        
                                                        <div>
                                                            <a href="{{ asset("storage/attached/".$name. "") }}" download="{{ $name }}"><i class="fas fa-paperclip me-2"></i>{{ $name }}</a>
                                                        </div>
                                                        
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="text-gray-400 @if(isset($reply->user->roles)) @if($reply->user->roles->first()->name == "admin") text-end @endif  @endif mt-2 fs-8">{{ $reply->created_at->format("d M Y, g:i A") }} @if(isset($reply->user->roles)) @if($reply->user->roles->first()->name == "admin")
                                            @if(isset($admin_access['reply_delete_ticket']))
                                                <a href="/admin/ticket/view/{{$ticket->id}}/delete/{{$reply->id}}">Delete</a>
                                            @endif
                                            | 
                                            @if(isset($admin_access['reply_edit_ticket']))
                                                <a href="/admin/ticket/view/{{$ticket->id}}/edit/{{$reply->id}}">Edit</a> 
                                            @endif
                                            @endif  @endif</div>
                                        </div>

                                    @endforeach 

                                </div>
                                <!--end::Description-->


                                <!--begin::Input group-->
                                    <div class="mb-0 fv-row">
                                        @if(isset($ticket_edit))
                                            @if(isset($admin_access['reply_edit_ticket']))
                                                <form action="{{ url("admin/ticket/update-answer") }}" id="ticket_reply_form">
                                                    <input type="hidden" name="id" value="{{$ticket_edit->id}}">
                                            @endif
                                        @else
                                            @if(isset($admin_access['send_reply_features']))
                                                <form action="{{ url("admin/ticket/send-answer") }}" id="ticket_reply_form">
                                            @endif
                                        @endif
                                            @if(isset($admin_access['update_status_ticket']))
                                            @if(!isset($admin_access['send_reply_features']) AND !isset($ticket_edit))
                                                <form action="{{ url("admin/ticket/send-answer") }}" id="ticket_reply_form">
                                            @endif
                                            @if(!isset($admin_access['reply_edit_ticket']) AND isset($ticket_edit))
                                                <form action="{{ url("admin/ticket/update-answer") }}" id="ticket_reply_form">
                                            @endif
                                                <div class="mb-3 w-25 d-flex justify-content-end ms-auto">
                                                    <select class="form-select form-select-solid fw-bolder" name="status" data-kt-select2="true" data-placeholder="Select status" data-id="{{ $ticket->id }}">
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
                                            @if(!isset($admin_access['reply_edit_ticket']) AND isset($ticket_edit))
                                                </form>
                                            @endif
                                            @if(!isset($admin_access['send_reply_features']) AND !isset($ticket_edit))
                                                </form>
                                            @endif
                                            @else
                                                <input type="hidden" name="status" value="{{$ticket->ticket_status->id}}">
                                            @endif
                                            @if(isset($admin_access['send_reply_features']) AND !isset($ticket_edit))
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
                                                        <button data-action="submit" type="submit" class="btn btn-primary">
                                                            <span class="indicator-label">Send</span>
                                                            <span class="indicator-progress">Please wait...
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                        </button> 
                                                    </div>
                                                </div>
                                        </form>
                                        @endif
                                        @if(isset($admin_access['reply_edit_ticket']) AND isset($ticket_edit))
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
                                                <textarea class="form-control form-control-solid placeholder-gray-600 fw-bolder fs-4 ps-9 pt-7" rows="6" name="description" placeholder="Send Message">{{$ticket_edit->description}}</textarea>

                                                <!--begin::Submit-->
                                                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                                                <div class="d-flex gap-5 align-items-center justify-content-end">
                                                    <div class="mt-3 text-end">
                                                        <button data-action="submit" type="submit" class="btn btn-primary">
                                                            <span class="indicator-label">Send</span>
                                                            <span class="indicator-progress">Please wait...
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                        </button> 
                                                    </div>
                                                </div>
                                        </form>
                                        @endif
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
@endsection

@section('after_script')
    <script src="{{ asset('public/assets/js/custom/apps/support-center/tickets/send_answer.js') }}"></script>
@endsection