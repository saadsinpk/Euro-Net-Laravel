@extends("layouts.app")
@section("content")
<!--begin::Post-->
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Card-->
        <div class="card">
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black"></rect>
                                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black"></path>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <input type="text" data-kt-admin-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="{{__('form.Search') }}...">
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-admin-table-toolbar="base">
                        @if(isset($admin_access['add_bitmain']))
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add">{{__('form.Add a Bitmain') }}</button>
                        @endif
                    </div>
                    <!--end::Toolbar-->
                    <!--begin::Group actions-->
                    @if(isset($admin_access['delete_bitmain']))
                        <div class="d-flex justify-content-end align-items-center d-none" data-kt-admin-table-toolbar="selected">
                            <div class="fw-bolder me-5">
                            <span class="me-2" data-kt-admin-table-select="selected_count"></span>{{__('form.Selected') }}</div>
                            <button type="button" class="btn btn-danger" data-kt-admin-table-select="delete_selected">{{__('form.Delete Selected') }}</button>
                        </div>
                    @else
                        <div class="d-flex justify-content-end align-items-center d-none" data-kt-admin-table-toolbar="selected">
                            <div class="fw-bolder me-5">
                            <span class="me-2" data-kt-admin-table-select="selected_count"></span>{{__('form.Selected') }}</div>
                            <button type="button" class="btn btn-danger" data-kt-admin-table-select="delete_selected">{{__('form.You are not allow to Delete Selected') }}</button>
                        </div>
                    @endif
                    <!--end::Group actions-->
                </div>
                <!--end::Card toolbar-->
            </div>

            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="category_table">
                    <!--begin::Table head-->
                    <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                            <th class="w-10px pe-2">
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#category_table .form-check-input" value="1" />
                                </div>
                            </th>
                            <th>{{__('form.Name') }}</th>
                            <th class="min-w-125px text-end">{{__('form.Actions') }}</th>
                        </tr>
                        <!--end::Table row-->
                    </thead>
                    <tbody class="fw-bold text-gray-600">
                    </tbody>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="fw-bold text-gray-600">
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Card body-->

            <div class="modal fade" id="kt_modal_add" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-650px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Form-->
                        <form class="form" action="{{ url('/admin/bitmain/create') }}">
                            <!--begin::Modal header-->
                            <div class="modal-header" id="kt_modal_add">
                                <!--begin::Modal title-->
                                <h2 class="fw-bolder">{{__('form.Add a bitmain') }}</h2>
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
                                <div class="scroll-y me-n7 pe-7" id="kt_modal_add_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add" data-kt-scroll-wrappers="#kt_modal_add_scroll" data-kt-scroll-offset="300px">
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
                                    <span class="indicator-label">{{__('form.Submit') }}</span>
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
        
    </div>
    <!--end::Container-->
</div>
<!--end::Post-->
@endsection

@section('after_script')
    <script src="{{ asset('public/assets/js/custom/apps/support-center/tickets/bitmain.js') }}"></script>
@endsection
