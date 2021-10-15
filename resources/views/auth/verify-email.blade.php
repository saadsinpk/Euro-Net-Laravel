@extends('layouts.guest')
@section('content')
<div class="d-flex flex-column flex-root">
    <!--begin::Authentication - Signup Verify Email -->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Content-->
        <div class="d-flex flex-column flex-column-fluid text-center p-10 py-lg-15">
            <!--begin::Logo-->
            <a href="index.html" class="mb-10 pt-lg-10">
                <img alt="Logo" src="{{ asset('public/assets/media/logos/logo-1.svg') }}" class="h-40px mb-5" />
            </a>
            <!--end::Logo-->
            <!--begin::Wrapper-->
            <div class="pt-lg-10 mb-10">
                <!--begin::Logo-->
                <h1 class="fw-bolder fs-2qx text-gray-800 mb-7">Verify Your Email</h1>
                <!--end::Logo-->
                <!--begin::Message-->
                <div class="fs-3 fw-bold text-muted mb-10">We have sent an email to
                <a href="#" class="link-primary fw-bolder">{{ auth()->user()->email }}</a>
                <br />pelase follow a link to verify your email.</div>
                <!--end::Message-->
                <!--begin::Action-->
                <div class="text-center mb-10">
                    <a href="/" class="btn btn-lg btn-primary fw-bolder">Skip for now</a>
                </div>
                <!--end::Action-->
                <!--begin::Action-->
                <div class="fs-5">
                    <span class="fw-bold text-gray-700">Did’t receive an email?</span>

                    <a role="button" class="link-primary fw-bolder ms-1"  onclick="event.preventDefault();
                    document.getElementById('resend-verification-form').submit();" > {{ __('Resend') }} </a>

                    <form id="resend-verification-form" method="POST" id="" action="{{ route('verification.send') }}">
                        @csrf
                    </form>
                    
                </div>
                <!--end::Action-->
            </div>
            <!--end::Wrapper-->
            <!--begin::Illustration-->
            <div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px" style="background-image: url(assets/media/illustrations/sketchy-1/17.png"></div>
            <!--end::Illustration-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Authentication - Signup Verify Email-->
</div>
@endsection