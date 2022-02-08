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

                                    <div class="separator separator-dashed mb-7"></div>

                                    @if($repair_payment->status == '2' || $repair_payment->status == '7')
                                        <h3>{{ __('form.Shipping Information') }}</h3>
                                    @endif
                                    @if($repair_payment->status == '2')
                                        {{ __('form.Tracking Number') }}:<b>{{$repair_payment->tracking_number}}</b><br>
                                        {{ __('form.Shipping company') }}:<b>{{$repair_payment->shipping_company}}</b><br>
                                        {{ __('form.Attached') }}:<a href="{{ asset("storage/attached/".$repair_payment->ship_attach. "") }}" download="{{ $repair_payment->ship_attach }}"><i class="fas fa-paperclip me-2"></i>{{ $repair_payment->ship_attach }}</a>
                                    @endif
                                    @if($repair_payment->status == '7')
                                        <form action="" method="post">
                                            @csrf
                                            <label>Shipping Company</label>
                                            <input type="text" name="return_shipping_company" class="form-control form-control-solid placeholder-gray-600" value="{{$repair_payment->return_shipping_company}}">

                                            <div class="separator separator-dashed mb-7"></div>

                                            <label>Shipping Tracking</label>
                                            <input type="text" name="return_tracking_number" class="form-control form-control-solid placeholder-gray-600" value="{{$repair_payment->return_tracking_number}}">

                                            <div class="mt-3 text-end">
                                                <button data-action="update_shipping" type="submit" class="btn btn-primary" name="update_shipping">
                                                    <span class="indicator-label">Send</span>
                                                </button> 
                                            </div>
                                        </form>
                                    @endif
                                    @if($repair_payment->status == '2' || $repair_payment->status == '7')
                                        <div class="separator separator-dashed mb-7"></div>
                                        <a href="{{url('label/download/'.$repair_payment->number)}}" class="btn btn-primary" target="_blank">Download LABEL</a>
                                        <div class="separator separator-dashed mb-7"></div>
                                    @endif

                                    @if(isset($admin_access['read_repair_notes']))
                                        <h3>{{ __('form.Private Notes') }}</h3>
                                        <div class="separator separator-dashed mb-7"></div>

                                        @foreach($repair_payment->notes as $note)
                                       
                                            <div class="mb-5">
                                                <div class="overflow-hidden position-relative card-rounded  @if($note->user->roles->first()->name == "admin") col-md-12 ms-auto @else col-md-8 @endif">
                                                    <div class="card card-bordered w-100 @if($note->user->roles->first()->name == "admin") bg-light-success @else bg-light-primary @endif"  style="background-color: #de9206 !important; border: 1px solid #000000 !important;">
                                                        <div class="card-body">
                                                            {!! nl2br($note->description) !!} 
                                                        </div>
                                                    </div>
                                                    <!--end::Card-->
                                                    <div>
                                                        @foreach (explode(",", $note->file_name) as $name)
                                                            @if($name)
                                                            <a href="{{ asset("storage/attached/".$name. "") }}"" class="image-link">
                                                                <img src="{{ asset("storage/attached/".$name. "") }}" style="width:100px;border: 2px solid gray;border-radius: 10px;">
                                                            </a>
                                                            
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="text-gray-400 @if($note->user->roles->first()->name == "admin") @endif mt-2 fs-8"> Posted by <b>{{$note->user->name}}</b> at {{ $note->created_at->format("d M Y, g:i A") }} 
                                                @if(isset($admin_access['delete_repair_notes']))
                                                    @if($note->user->roles->first()->name == "admin")
                                                        <a href="/admin/repair/view/{{$repair_payment->id}}/delete_notes/{{$note->id}}">Delete</a>
                                                    @endif
                                                @endif | 
                                                @if(isset($admin_access['edit_repair_notes']))
                                                    @if($note->user->roles->first()->name == "admin")
                                                        <a href="/admin/repair/view/{{$repair_payment->id}}/edit_notes/{{$note->id}}">Edit</a>
                                                    @endif
                                                @endif</div>
                                            </div>

                                        @endforeach 

                                        <!--begin::Input group-->
                                        <div class="mb-0 fv-row">
                                            @if(!isset($notes_ticket_edit) AND isset($admin_access['send_repair_notes']))
                                                <form action="{{ url("admin/repair_payment/notes") }}" id="repair_notes_form">
                                                <div class="fv-row mb-8">
                                                    <label class="fs-6 fw-bold mb-2">{{__('form.Attachments') }}</label>
                                                    <!--begin::Dropzone-->
                                                    <div class="dropzone" id="attachments_notes">
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
                                                <textarea class="form-control form-control-solid placeholder-gray-600 fw-bolder fs-4 ps-9 pt-7" rows="6" name="description" placeholder="Send Notes" style="background:#ffa500 !important;"></textarea>

                                                <!--begin::Submit-->
                                                <input type="hidden" name="repair_id" value="{{ $repair_payment->id }}">
                                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                                                <div class="d-flex gap-5 align-items-center justify-content-end">
                                                        
                                                    <div class="mt-3 text-end">
                                                        <button data-action="submit_notes" type="submit_notes" class="btn btn-primary">
                                                            <span class="indicator-label">Send</span>
                                                            <span class="indicator-progress">Please wait...
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                        </button> 
                                                    </div>
                                                </div>
                                            </form>
                                            @endif

                                            @if(isset($notes_ticket_edit) AND isset($admin_access['edit_repair_notes']))
                                                <form action="{{ url("admin/repair_payment/update_notes") }}" id="repair_notes_form">
                                                <input type="hidden" name="id" value="{{$notes_ticket_edit->id}}">
                                                <div class="fv-row mb-8">
                                                    <label class="fs-6 fw-bold mb-2">{{__('form.Attachments') }}</label>
                                                    <!--begin::Dropzone-->
                                                    <div class="dropzone" id="attachments_notes">
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
                                                <textarea class="form-control form-control-solid placeholder-gray-600 fw-bolder fs-4 ps-9 pt-7" rows="6" name="description" placeholder="Send Notes" style="background:#ffa500 !important;">{{$notes_ticket_edit->description}}</textarea>

                                                <!--begin::Submit-->
                                                <input type="hidden" name="repair_id" value="{{ $repair_payment->id }}">
                                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                                                <div class="d-flex gap-5 align-items-center justify-content-end">
                                                        
                                                    <div class="mt-3 text-end">
                                                        <button data-action="submit_notes" type="submit_notes" class="btn btn-primary">
                                                            <span class="indicator-label">Send</span>
                                                            <span class="indicator-progress">Please wait...
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                        </button> 
                                                    </div>
                                                </div>
                                            </form>
                                            @endif
                                        </div>

                                        <div class="separator separator-dashed mb-7"></div>
                                    @endif

                                    @if(isset($admin_access['read_repair_payment']))
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
                                                    <th>{{__('form.Action') }}</th>
                                                </tr>
                                                <!--end::Table row-->
                                            </thead>
                                            <!--end::Table head-->
                                            <!--begin::Table body-->
                                            <tbody class="fw-bold text-gray-600">
                                                @foreach ($repair_payment->request as $p)
                                                    @if(isset($payment_edit))
                                                        @if($payment_edit == $p->id)
                                                            @if(isset($admin_access['edit_repair_payment']))
                                                                <form method="post">
                                                                    @csrf 

                                                                    <input type="hidden" name="payment_id" value="{{$p->id}}">
                                                                    <tr>
                                                                        <td>{{ $p->created_at->format("d M Y, g:i A")}}</td>
                                                                        <td><input type="text" value="{{ $p->description }}" name="description"></td>
                                                                        <td>
                                                                            <span class="me-1"><input type="text" value="{{ $p->amount }}" name="amount"></span>
                                                                            <span class="text-uppercase"> {{ $p->currency }}</span>
                                                                        </td>

                                                                         <td>
                                                                            <select name="payment_status">
                                                                                <option value="1" @if($p->status > 0) selected @endif>Paid</option>
                                                                                <option value="0" @if($p->status == 0) selected @endif>Unpaid</option>
                                                                            </select> 
                                                                        </td>
                                                                        <td><input type="submit" class="btn" value="update" name="update_payment" style="display: none;"><div id="payment_update_form" class="btn">Update</div></td>
                                                                    </tr>
                                                                </form>
                                                            @endif
                                                        @else
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
                                                                <td>@if(isset($admin_access['edit_repair_payment']))<a href="{{url('/admin/repair/view/'.$repair_payment->id.'/edit_payment/'.$p->id)}}">{{__('form.Edit') }}</a>@endif
                                                                |
                                                                @if(isset($admin_access['delete_repair_payment']))<a href="{{url('/admin/repair/view/'.$repair_payment->id.'/delete_payment/'.$p->id)}}">{{__('form.Delete') }}</a>@endif</td>
                                                            </tr>
                                                        @endif
                                                    @else
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
                                                            <td>@if(isset($admin_access['edit_repair_payment']))<a href="{{url('/admin/repair/view/'.$repair_payment->id.'/edit_payment/'.$p->id)}}">{{__('form.Edit') }}</a>@endif | @if(isset($admin_access['delete_repair_payment']))<a href="{{url('/admin/repair/view/'.$repair_payment->id.'/delete_payment/'.$p->id)}}">{{__('form.Delete') }}</a>@endif</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                            <!--end::Table body-->
                                        </table>

                                        <div class="separator separator-dashed mb-7"></div>
                                    @endif

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
                                                            <a href="{{ asset("storage/attached/".$name. "") }}" download="{{ $name }}"><i class="fas fa-paperclip me-2"></i>{{ $name }}</a>
                                                        </div>
                                                        
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="text-gray-400 @if($reply->user->roles->first()->name == "admin") text-end @endif mt-2 fs-8"> Posted by <b>{{$reply->user->name}}</b> at {{ $reply->created_at->format("d M Y, g:i A") }}
                                            @if($reply->user->roles->first()->name == "admin") 
                                                @if(isset($admin_access['delete_repair_reply'])) 
                                                    <a href="/admin/repair/view/{{$repair_payment->id}}/delete/{{$reply->id}}">Delete</a>
                                                @endif
                                            @endif | 
                                            @if($reply->user->roles->first()->name == "admin") 
                                                @if(isset($admin_access['edit_repair_reply'])) 
                                                    <a href="/admin/repair/view/{{$repair_payment->id}}/edit/{{$reply->id}}">Edit</a>
                                                @endif
                                            @endif
                                            </div>
                                        </div>

                                    @endforeach 

                                </div>
                                <!--end::Description-->


                                <!--begin::Input group-->
                                <div class="mb-0 fv-row">
                                    @if(!isset($ticket_edit) AND isset($admin_access['send_repair_reply']))
                                        <form action="{{ url("admin/repair_payment/reply") }}" id="repair_form">
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

                                            <textarea class="form-control form-control-solid placeholder-gray-600 fw-bolder fs-4 ps-9 pt-7" rows="6" name="description" placeholder="Send Message"></textarea>
                                            <!--begin::Submit-->
                                            <input type="hidden" name="repair_id" value="{{ $repair_payment->id }}">
                                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                                            <div class="d-flex gap-5 align-items-center justify-content-end">
                                                
                                                @if(isset($admin_access['send_repair_payment']))
                                                    <div class="mt-3">
                                                        <a class="btn btn-light-warning" data-action='send_payment' data-id="{{ $repair_payment->id }}" data-user-id="{{ $repair_payment->user_id }}" data-bs-toggle="modal" data-bs-target="#kt_payment_modal">
                                                            <span class="indicator-label">Send Amount</span>
                                                            <span class="indicator-progress">Please wait...
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                        </a> 
                                                    </div>
                                                @endif
                                                    
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

                                    @if(isset($ticket_edit) AND isset($admin_access['edit_repair_reply']))
                                        <form action="{{ url("admin/repair_payment/update_reply") }}" id="repair_form">
                                            <input type="hidden" name="id" value="{{$ticket_edit->id}}">
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

                                            <textarea class="form-control form-control-solid placeholder-gray-600 fw-bolder fs-4 ps-9 pt-7" rows="6" name="description" placeholder="Send Message">{{$ticket_edit->description}}</textarea>
                                            <!--begin::Submit-->
                                            <input type="hidden" name="repair_id" value="{{ $repair_payment->id }}">
                                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                                            <div class="d-flex gap-5 align-items-center justify-content-end">
                                                
                                                @if(isset($admin_access['send_repair_payment']))
                                                    <div class="mt-3">
                                                        <a class="btn btn-light-warning" data-action='send_payment' data-id="{{ $repair_payment->id }}" data-user-id="{{ $repair_payment->user_id }}" data-bs-toggle="modal" data-bs-target="#kt_payment_modal">
                                                            <span class="indicator-label">Send Amount</span>
                                                            <span class="indicator-progress">Please wait...
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                        </a> 
                                                    </div>
                                                @endif
                                                    
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
    <link rel="stylesheet" href="{{ asset('public/assets/magnific-popup.css') }}">
    <script src="{{ asset('public/assets/jquery.magnific-popup.js') }}"></script>
    <script type="text/javascript">
        $('.image-link').magnificPopup({
          type: 'image',
          mainClass: 'mfp-with-zoom', // this class is for CSS animation below

          zoom: {
            enabled: true, // By default it's false, so don't forget to enable it

            duration: 300, // duration of the effect, in milliseconds
            easing: 'ease-in-out', // CSS transition easing function

            // The "opener" function should return the element from which popup will be zoomed in
            // and to which popup will be scaled down
            // By defailt it looks for an image tag:
            opener: function(openerElement) {
              // openerElement is the element on which popup was initialized, in this case its <a> tag
              // you don't need to add "opener" option if this code matches your needs, it's defailt one.
              return openerElement.is('img') ? openerElement : openerElement.find('img');
            }
          }

        });        
    </script>
    <script src="{{ asset('public/assets/js/custom/apps/support-center/tickets/repair_notes.js') }}"></script>
    <script src="{{ asset('public/assets/js/custom/apps/support-center/tickets/repair_detail.js') }}"></script>
    <script src="{{ asset('public/assets/js/custom/apps/support-center/tickets/payment.js') }}"></script>
@endsection