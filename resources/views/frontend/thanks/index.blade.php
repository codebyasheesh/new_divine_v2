@extends('frontend.layouts.app')

@section('content')
<div class="position-relative vh-100 d-flex align-items-center section-padding">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-8 text-center">
                <!-- Success Icon/Image -->
                {{-- <div class="mb-5">
                    <div class="success-icon-container mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-success">
                            <path d="M22 11.08v.5a10.5 10.5 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                </div> --}}

                <!-- Main Title -->
                <div class="iq-title-box mb-5">
                    <h1 class="iq-title iq-heading-title mb-3">
                        <span class="right-text text-capitalize fw-500">Thank You!</span>
                    </h1>
                    <p class="iq-title-desc text-body mt-3 mb-0 font-size-18">
                        Your payment seems to have gone through successfully. You do not need to take any further action.
                    </p>
                    <p class="iq-title-desc text-body mt-3 mb-0 font-size-18">
                        You will receive a confirmation mail as soon as the payment is verified by our Admin.
                    </p>
                    <p class="iq-title-desc text-body mt-3 mb-0 font-size-18">
                        Thank you once again!
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="row justify-content-center gap-3 mb-5">
                    <div class="col-auto">
                        <div class="button-primary">
                            <div class="iq-btn-container">
                                <a class="iq-button text-capitalize" href="{{ route('home') }}" style="background-color: rgb(24, 23, 23);">
                                    <span class="iq-btn-text-holder position-relative">Back to Home</span>
                                    <span class="iq-btn-icon-holder">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 8 8" fill="none">
                                            <path d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z" fill="currentColor"></path>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="button-primary">
                            <div class="iq-btn-container">
                                <a class="iq-button text-capitalize border border-dark text-dark" href="{{ route('book_appointment') }}" style="background-color: transparent;">
                                    <span class="iq-btn-text-holder position-relative">Make Another Booking</span>
                                    <span class="iq-btn-icon-holder">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 8 8" fill="none">
                                            <path d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z" fill="currentColor"></path>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Text -->
                <p class="text-muted font-size-14">
                    If you have any questions, please don't hesitate to reach out to us at <a href="mailto:info@divinetouchtherapy.com" class="text-decoration-none">info@divinetouchtherapy.com</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Decorative Background -->
    <div class="position-absolute top-0 start-0 opacity-25" style="z-index: 0; width: 100%; height: 100%;">
        <svg class="position-absolute" style="top: 0; left: 0; width: 300px; height: 300px; opacity: 0.1;" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <circle cx="50" cy="50" r="30" fill="currentColor" opacity="0.2"/>
        </svg>
    </div>
</div>

<style>
    .success-icon-container {
        display: flex;
        justify-content: center;
        animation: slideDown 0.6s ease-out;
    }

    .success-icon-container svg {
        width: 100px;
        height: 100px;
        color: #28a745;
        filter: drop-shadow(0 2px 8px rgba(40, 167, 69, 0.2));
    }

    .alert-with-icon {
        background: rgba(23, 162, 184, 0.1) !important;
        border: 1px solid rgba(23, 162, 184, 0.2) !important;
        border-radius: 8px;
    }

    .alert-with-icon i {
        color: #17a2b8;
        font-size: 20px;
    }

    .font-size-18 {
        font-size: 18px;
    }

    .font-size-32 {
        font-size: 32px;
    }

    .font-size-14 {
        font-size: 14px;
    }

    .font-weight-semibold {
        font-weight: 600;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .col-lg-8 {
            padding: 20px;
        }

        .iq-title {
            font-size: 28px;
        }

        .card-body {
            padding: 2rem !important;
        }
    }
</style>
@endsection
