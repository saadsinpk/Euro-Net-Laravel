@extends("layouts.guest")
@section("content")
        <!--begin::Main-->
        <div class="d-flex flex-column flex-root">
            <!--begin::Authentication - Sign-in -->
            <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url({{ asset('public/assets/media/illustrations/sketchy-1/backgroun-login.jpg') }})">
                <!--begin::Content-->
                <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                    <!--begin::Logo-->
                    <a href="{{url('/')}}" class="mb-12">
                        <img alt="Logo" src="{{ asset('public/assets/media/logos/logowebsite.jpg') }}" class="h-40px" style="max-width: 480px;    height: auto !important;    width: 100%;"/>
                    </a>
                    <!--end::Logo-->
                    <!--begin::Wrapper-->
                    <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                        <!--begin::Form-->
                        <form action="{{ route('reset') }}" class="form w-100" novalidate="novalidate" id="kt_sign_in_form">
                            <!--begin::Heading-->
                            <div class="text-center mb-10">
                                <!--begin::Title-->
                                <h1 class="text-dark mb-3">{{__('auth.Reset your password') }}</h1>
                                @if(isset($message_to_display))
                                    @if($message_to_display == 'pass')
                                        <p style="    font-size: 20px;    font-weight: bold;">{{__('auth.Check your inbox') }}</p>
                                    @elseif($message_to_display == 'fail')
                                        <p style="    font-size: 20px;    font-weight: bold;">{{__('auth.There is no data for given email address') }}</p>
                                    @endif
                                @endif
                                <!--end::Title-->
                            </div>
                            <!--begin::Heading-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="form-label fs-6 fw-bolder text-dark">{{__('form.Email') }}</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input class="form-control form-control-lg form-control-solid" value="{{ old('email') }}" type="text" name="email" autocomplete="off" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <!--end::Input group-->
                            <!--begin::Actions-->
                            <div class="text-center">
                                <!--begin::Submit button-->
                                <button type="button" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5" name="submit_form">
                                    <span class="indicator-label">{{__('form.Continue') }}</span>
                                    <span class="indicator-progress">{{__('form.Please wait...') }}
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                                <!--end::Submit button-->
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Authentication - Sign-in-->
        </div>

        @section("after_script")
            <!--begin::Page Custom Javascript(used by this page)-->
            <script src="{{ asset('public/assets/js/custom/authentication/sign-in/general-verification.js') }}"></script>
            <!--end::Page Custom Javascript-->
        @endsection
@endsection
