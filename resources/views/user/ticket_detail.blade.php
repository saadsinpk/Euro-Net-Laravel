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
                                    <div class="col-md-6">
                                        <h3>{{__('ticket.Ticket Subject') }}</h3>
                                        <div class="text-gray-800 fs-6">{{ $ticket->subject }}</div>
                                    </div>

                                    <div class="col-md-6">
                                        <h3>{{__("ticket.number") }}</h3>
                                        <div class="text-gray-800 fs-6">{{ $ticket->number }}</div>
                                    </div>
                                </div>
                                <div class="separator separator-dashed mb-7"></div>
                                <div class="row mb-5">
                                    <div class="col-md-4">
                                        <h3>{{__("ticket.Category") }}</h3>
                                        <div class="text-gray-800 fs-6">{{ $ticket->category->name }}</div>
                                    </div>

                                    <div class="col-md-4">
                                        <div>
                                            <h3>{{__('ticket.Status') }}</h3>
                                            <div class="text-gray-800 fs-6">{{ $ticket->ticket_status->option }}</div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div>
                                            <h3>{{__('ticket.Date') }}</h3>
                                            <div class="text-gray-800 fs-6">{{ $ticket->created_at->format("d M Y, g:i A") }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator separator-dashed mb-7"></div>

                                <div>
                                    <h3>{{__('form.Description') }}</h3>
                                    <div class="text-gray-800 fs-6">{{ $ticket->description }}</div>
                                </div>
                                <div class="separator separator-dashed mb-7"></div>
                                
                                <div>
                                    <h3>{{__('form.Description') }}</h3>
                                    <div class="text-gray-800 fs-6">{{ $ticket->description }}</div>
                                </div>
                                
                                <div class="separator separator-dashed mb-7"></div>
                                
                                <div class="mb-5">
                                    <h3>{{ __('form.Attached files') }}</h3>
                                    @if($ticket->file_name) 
                                        <div class="mb-5">
                                            <h3>{{ __('form.Attached files') }}</h3>
                                            @foreach (explode(",", $ticket->file_name) as $name)

                                                <div>
                                                    <a href="{{ asset("public/uploads/attached/".$name. "") }}" download="{{ $name }}"><i class="fas fa-paperclip me-2"></i>{{ $name }}</a>
                                                </div>
                                                
                                                @endforeach
                                            <div class="separator separator-dashed mb-7"></div>
                                            
                                        </div>
                                    @endif 
                                </div> 
                            </div> 
                                
                            <div class="w-100 px-17">
                                <h1 class="text-center mb-4">{{__('ticket.Ticket Reply From support') }}</h1>

                                @foreach($ticket->reply as $reply)
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
                                                {{ $reply->description }}
                                            </div>
                                            <!--end::Body-->
                                        </div>
                                        <!--end::Card-->
                                    </div>
                                    @foreach (explode(",", $reply->file_name) as $name)
                                        @if($name)

                                        <div>
                                            <a href="{{ asset("public/uploads/attached/".$name. "") }}" download="{{ $name }}"><i class="fas fa-paperclip me-2"></i>{{ $name }}</a>
                                        </div>
                                        
                                        @endif
                                    @endforeach
                                    
                                    <div class="text-gray-400 @if($reply->user->roles->first()->name == "admin") text-end @endif mt-2 fs-8">{{ $reply->created_at->format("d M Y, g:i A") }}</div>
                                </div>
                                @endforeach

                                <div class="mb-0">
                                    <form action="{{ url("user/ticket/send-answer") }}" id="ticket_reply_form">
                                        <div class="fv-row">
                                            <textarea class="form-control form-control-solid placeholder-gray-600 fw-bolder fs-4 ps-9 pt-7" rows="6" name="description" placeholder="Send Message"></textarea>
                                            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">  
                                        </div>
                                        
                                        <div class="fv-row mb-8">
                                            <label class="fs-6 fw-bold mb-2">Attachments</label>
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
                            <!--end::Input group-->
                        </div>
                    </div>
                    <!--end::Hero body-->
                </div>
                <!--end::Hero card-->
              
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
@endsection

@section('after_script')
    <script src="{{ asset('public/assets/js/custom/apps/support-center/tickets/send_answer.js') }}"></script>
@endsection