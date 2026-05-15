@extends('frontend.layouts.app')

@section('content')
<div class="section-padding service-details">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="bg-primary-subtle p-3 p-md-4">
                    <div class="service-menu">
                        <ul class="list-inline m-0">
                            <li class="mb-3">
                                <a href="{{ route('massage_therapy') }}" class="d-block py-3 px-4">
                                    <span class="d-flex align-items-center justify-content-between">
                                        <span>Massage Therapy</span>
                                        {{-- <span class="icon"><i class="fas fa-plus"></i></span> --}}
                                    </span>
                                </a>
                            </li>
                            <li class="mb-3">
                                <a href="{{ route('laser_hair_removal') }}" class="d-block py-3 px-4">
                                    <span class="d-flex align-items-center justify-content-between">
                                        <span>Laser Hair Removal</span>
                                        {{-- <span class="icon"><i class="fas fa-plus"></i></span> --}}
                                    </span>
                                </a>
                            </li>
                            <li class="mb-3">
                                <a href="{{ route('skincare') }}" class="d-block py-3 px-4">
                                    <span class="d-flex align-items-center justify-content-between">
                                        <span>Skin Care</span>
                                        {{-- <span class="icon"><i class="fas fa-plus"></i></span> --}}
                                    </span>
                                </a>
                            </li>
                            <li class="mb-3">
                                <a href="{{ route('twist_microneedling') }}" class="d-block py-3 px-4">
                                    <span class="d-flex align-items-center justify-content-between">
                                        <span>Twist Microneedling</span>
                                        {{-- <span class="icon"><i class="fas fa-plus"></i></span> --}}
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="mt-5 sidebar-widget-working-hour bg-secondary-subtle text-body p-3 p-md-5">
                    <div class="icon mb-4">
                        <i class="far fa-clock"></i>
                    </div>
                    <h4 class="mb-3 fw-500">Working Hours</h4>
                    <p class="mb-4 small">
                        Services are provided strictly by prior appointment to ensure personalized care and complete
                        attention.
                    </p>
                    <ul class="list-inline m-0">
                        <li class="mb-2 pb-2 border-bottom d-flex align-items-center justify-content-between">
                            <span>Monday - Friday</span>
                            <span>By Appointment</span>
                        </li>
                        <li class="mb-2 pb-2 border-bottom d-flex align-items-center justify-content-between">
                            <span>Saturday</span>
                            <span>By Appointment</span>
                        </li>
                        <li class="d-flex align-items-center justify-content-between">
                            <span>Sunday</span>
                            <span>Closed</span>
                        </li>
                    </ul>
                    <div class="mt-4">
                        <a href="{{ route('book_appointment') }}" class="btn btn-dark w-100">
                            Book Appointment
                        </a>
                    </div>
                </div>
                <div class="mt-5 sidebar-widget-services bg-primary-subtle text-body p-3 p-md-5">
                    <div class="mb-5">
                        <img src="{{ asset('frontend_assets/images/service/divine-logo.png') }}" class="img-fluid" alt="image" />
                    </div>
                    <h4 class="mb-3">Divine Touch Therapy</h4>
                    <ul class="list-inline m-0">
                        <li class="mb-2">
                            <span><b>Call : </b></span>
                            <span>+1 905-996-2700</span>
                        </li>
                        <li class="mb-2">
                            <span><b>Mail : </b></span>
                            <span><a href="mailto:info@divinetouchtherapy.com">info@divinetouchtherapy.com</a></span>
                        </li>
                        <li>
                            <span><b>Address : </b></span>
                            <span>70 Twistleton St,<br>Caledon, ON L7C 4B5</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-8 mt-lg-0 mt-5">
                <div class="about-service">
                    <div class="position-relative">
                        <img src="{{ asset('frontend_assets/images/service/about-aesthetics.webp') }}" class="img-fluid"
                            alt="image" title="" />
                    </div>
                    <div class="iq-title-box mt-5 mb-0">
                        <span class="iq-subtitle text-uppercase">Service</span>
                        <h3 class="iq-title iq-heading-title mb-2">
                            <span class="right-text text-capitalize fw-500">Skin Care</span>
                            <span class="left-text text-capitalize fw-light">Treatment</span>
                        </h3>
                        <p class="iq-title-desc text-body">
                            Restore, Rebalance, and Rejuvenate your skin with the latest treatments in skincare to
                            achieve lasting benefits that bring out your best features. Esthetics is the application of
                            various treatments to the skin's epidermal layer. It includes facial steaming, wrapping,
                            exfoliation, pore cleansing, extraction, and chemical peels.
                        </p>
                    </div>
                    <div class="row mt-5 align-items-center">
                        <div class="col-md-6">
                            <ul class="list-inline m-0">
                                <li class="mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-primary"><i class="fas fa-check"></i></span>
                                        <span>Customized skin care treatments</span>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-primary"><i class="fas fa-check"></i></span>
                                        <span>Suitable for all skin types</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-primary"><i class="fas fa-check"></i></span>
                                        <span>Professional-grade products & techniques</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6 mt-md-0 mt-2">
                            <ul class="list-inline m-0">
                                <li class="mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-primary"><i class="fas fa-check"></i></span>
                                        <span>Improves skin texture & hydration</span>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-primary"><i class="fas fa-check"></i></span>
                                        <span>Targets acne, pigmentation & dullness</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-primary"><i class="fas fa-check"></i></span>
                                        <span>Performed by trained skin care professionals</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="pt-5">
                        <div class="row mt-5 align-items-center">
                            <!-- COUNTER BOX -->
                            <div class="col-md-5">
                                <div class="iq-counter iq-counter-no-icon bg-primary-subtle p-3">
                                    <div class="counter-content">
                                        <h3 class="counter mt-0 mb-3 text-primary fw-500">
                                            1500+
                                        </h3>
                                        <h4 class="counter-title mb-2 fw-normal">
                                            Skin Care Treatments Done
                                        </h4>
                                        <p class="counter-text m-0 text-body">
                                            Successfully delivered customized skin care treatments for healthier,
                                            clearer, and glowing skin.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- PROGRESS BARS -->
                            <div class="col-md-7 mt-md-0 mt-5">
                                <div>
                                    <div class="wrapper-progress">
                                        <div class="percentage-progress d-flex justify-content-between">
                                            <h6 class="mb-2 text-body">Skin Improvement Results</h6>
                                            <div><span>93%</span></div>
                                        </div>
                                    </div>
                                    <div class="progress" style="height: 10px">
                                        <div class="progress-bar bg-primary" role="progressbar"
                                            style="width: 93%; height: 10px" aria-valuenow="93" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="mt-5">
                                    <div class="wrapper-progress">
                                        <div class="percentage-progress d-flex justify-content-between">
                                            <h6 class="mb-2 text-body">Client Satisfaction</h6>
                                            <div><span>91%</span></div>
                                        </div>
                                    </div>
                                    <div class="progress" style="height: 10px">
                                        <div class="progress-bar bg-primary" role="progressbar"
                                            style="width: 91%; height: 10px" aria-valuenow="91" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="mt-5">
                                    <div class="wrapper-progress">
                                        <div class="percentage-progress d-flex justify-content-between">
                                            <h6 class="mb-2 text-body">
                                                Treatment Safety & Comfort
                                            </h6>
                                            <div><span>96%</span></div>
                                        </div>
                                    </div>
                                    <div class="progress" style="height: 10px">
                                        <div class="progress-bar bg-primary" role="progressbar"
                                            style="width: 96%; height: 10px" aria-valuenow="96" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="mt-5">
    <div class="container">
        <div class="row row-cols-1 row-cols-md-2">
            <!-- BLOG BOX 1 -->
            <div class="col">
                <div class="iq-blog blog-standard position-relative">
                    <a href="javascript:;" class="blog-image d-block overflow-hidden">
                        <img src="{{ asset('frontend_assets/images/service/treatment-1.webp') }}" alt="Treatment 1"
                            title="Skin Care Treatment" class="img-fluid w-100" loading="lazy" />
                    </a>
                    <div class="iq-post-details bg-white p-4">
                        <div class="iq-blog-cat bg-primary text-white d-inline">
                            <a href="javascript:void(0);" class="text-white">
                                Facial
                            </a>
                        </div>
                        <div class="blog-title mb-2">
                            <p class="text-capitalize fw-25 mt-5" style="font-size:15px;">
                                OxyGeneo™ 3-in-1 Super Facial is a skin treatment that combines all the benefits of
                                microdermabrasion, chemical peels, and oxygenating facials. Immediate benefits are
                                softer, smoother, and brighter skin. An OxyGeneo™ treatment feels like a massage for the
                                face. Your skin will feel rejuvenated after just one treatment.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- BLOG BOX 2 -->
            <div class="col mb-5">
                <div class="iq-blog blog-standard position-relative">
                    <a href="javascript:;" class="blog-image d-block overflow-hidden">
                        <img src="{{ asset('frontend_assets/images/service/treatment-2.webp') }}" alt="Skin Care Treatment 2"
                            class="img-fluid w-100" title="Skin Care Treatment 2" loading="lazy" />
                    </a>
                    <div class="iq-post-details bg-white p-4">
                        <div class="iq-blog-cat bg-primary text-white d-inline">
                            <a href="javascript:;" class="text-white">
                                Skin Tightening
                            </a>
                        </div>
                        <div class="blog-title mb-2">
                            <p class="text-capitalize fw-25 mt-5" style="font-size:15px;">
                                OxyGeneo™ Tripollar RF Skin Tightening treatment is an effective, painless and
                                non-invasive skin treatment with immense benefits. TriPollar RF treatments give the skin
                                a fresh, tight, rejuvenated appearance. Combine OxyGeneo Skin Tightening with OxyGeneo
                                3-in-1 Super Facial for incredible results, that must be seen to be believed.
                            </p>
                        </div>
                        <!-- <div class="blog-button mt-3">
                            <a class="iq-button iq-btn-link text-capitalize" href="javascript:;">
                                Read More
                            </a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="section-padding">
    <div class="container position-relative">
        <div class="scrolling-text position-absolute">
            <div class="iq-title text-uppercase">Therapy</div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="position-relative">
                    <div class="iq-title-box">
                        <span class="iq-subtitle text-uppercase">Oxygen Therapy</span>
                        <h2 class="iq-title iq-heading-title">
                            <span class="right-text text-capitalize fw-500" style="font-size:25px;">3-in-1 Therapy.
                                Better Results.</span>
                            <!-- <span class="left-text text-capitalize fw-light">treatment</span> -->
                        </h2>
                        <p class="iq-title-desc text-body mt-3 mb-0">
                            What makes OxyGeneo™ the new super-facial? Get the exfoliation benefits of microdermabrasion
                            plus deep facial rejuvenation with the infusion of essential revitalizing nutrients and
                            healing skin oxygenation from within. OxyGeneo™ treatments are suitable for all skin types -
                            any ethnicity and pigmentation, sensitive skin, and even for those who keloid (scar) and
                            couldn't otherwise have abrasion treatments.
                        </p>
                        <h2 class="iq-title iq-heading-title mt-3">
                            <!-- <span class="right-text text-capitalize fw-500">Exfoliate. Infuse. Oxygenate.</span> -->
                            <span class="left-text text-capitalize fw-light" style="font-size:25px;">Exfoliate. Infuse.
                                Oxygenate.</span>
                        </h2>
                        <p class="iq-title-desc text-body mt-3 mb-0">
                            Breakthrough OxyGeneo™ Technology provides superior anti-aging results by treating the skin
                            at a deeper level. Exfoliate, Infuse, and Oxygenate your way to youthful skin. Learn more
                            about HOW IT WORKS below.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mt-lg-0 mt-5 position-relative">
                <!-- YouTube Video Embed -->
                <div class="ratio ratio-16x9">
                    <iframe src="https://www.youtube.com/embed/sxpcEZ3djtg" title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
        <div class="row align-items-center mt-5">
            <div class="col-lg-6 mt-lg-0 mt-5 position-relative">
                <img src="{{ asset('frontend_assets/images/service/oxygeno.webp') }}" alt="Oxygeno" title="Oxygeno"
                    class="img-fluid w-100">
            </div>
            <div class="col-lg-6">
                <div class="position-relative">
                    <div class="iq-title-box">
                        <!-- <span class="iq-subtitle text-uppercase">Oxygen Therapy</span> -->
                        <h2 class="iq-title iq-heading-title">
                            <span class="right-text text-capitalize fw-500" style="font-size:35px;">Better than
                                Microdermabrasion</span>
                            <!-- <span class="left-text text-capitalize fw-light">treatment</span> -->
                        </h2>
                        <p class="iq-title-desc text-body mt-3 mb-0">
                            Find out why professionals are calling the OxyGeneo™ Facial "better than microdermabrasion".
                        </p>
                    </div>
                    <ul class="iq-list-with-icon list-inline m-0">
                        <li class="d-flex align-items-center gap-2 mb-3">
                            <span class="text-secondary">
                                <svg width="15" height="14" viewBox="0 0 15 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M2.59695 0.0379703C1.96118 0.143694 1.43245 0.425953 0.931049 0.927357C0.417642 1.44076 0.148371 1.95322 0.0397285 2.62375C-0.0132428 2.95081 -0.0132428 11.0523 0.0397285 11.3794C0.148371 12.0499 0.417642 12.5623 0.931049 13.0758C1.45007 13.5948 1.96808 13.8644 2.64799 13.9694C2.82029 13.996 4.26339 14.0049 7.16941 13.9975L11.4378 13.9865L11.7003 13.9055C12.2771 13.7275 12.7083 13.4735 13.0885 13.088C13.4916 12.6792 13.737 12.2647 13.9056 11.7077C13.987 11.4385 13.9886 11.3982 14.0009 9.23766C14.0091 7.79777 14.0004 6.99291 13.9756 6.9009C13.9548 6.82371 13.88 6.69296 13.8092 6.61033C13.4661 6.20947 12.8337 6.27331 12.5616 6.73626L12.4593 6.91035L12.441 9.09925L12.4228 11.2882L12.3066 11.5334C12.1451 11.8743 11.9069 12.117 11.5706 12.2832L11.2956 12.4191H7.00714H2.71865L2.47338 12.3029C2.1325 12.1414 1.88982 11.9032 1.72365 11.5669L1.58772 11.2919V7.00345V2.71496L1.70391 2.46969C1.86534 2.12888 2.10361 1.88613 2.43975 1.71996L2.71471 1.58403L4.9603 1.56579L7.2059 1.54755L7.36846 1.45634C7.61281 1.31924 7.74644 1.10557 7.76443 0.823275C7.78096 0.563781 7.71124 0.382248 7.52847 0.208777C7.30031 -0.00774129 7.35492 -0.00332719 4.97256 0.00134246C3.77304 0.00367729 2.70402 0.0201672 2.59695 0.0379703ZM13.7726 0.807514C13.6449 0.839691 13.2121 1.25828 10.3161 4.1504L7.00543 7.45644L5.64641 6.10225C4.18011 4.64115 4.18047 4.64141 3.8313 4.67497C3.58297 4.69883 3.39371 4.80886 3.25883 5.00772C3.12075 5.21133 3.07945 5.43211 3.13786 5.65432C3.17602 5.79956 3.35091 5.98715 4.86479 7.50704C5.99438 8.64115 6.59731 9.2207 6.69515 9.26648C6.87318 9.34981 7.10765 9.35532 7.28915 9.28042C7.45817 9.21067 14.5982 2.092 14.7053 1.88646C14.7958 1.71281 14.7965 1.41406 14.7068 1.21662C14.6213 1.02837 14.4111 0.854029 14.208 0.802881C14.0253 0.756878 13.9712 0.757425 13.7726 0.807514Z"
                                        fill="currentColor"></path>
                                </svg>
                            </span>
                            <p class="m-0">Skin Plumping & Hydrating</p>
                        </li>
                        <li class="d-flex align-items-center gap-2 mb-3">
                            <span class="text-secondary">
                                <svg width="15" height="14" viewBox="0 0 15 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M2.59695 0.0379703C1.96118 0.143694 1.43245 0.425953 0.931049 0.927357C0.417642 1.44076 0.148371 1.95322 0.0397285 2.62375C-0.0132428 2.95081 -0.0132428 11.0523 0.0397285 11.3794C0.148371 12.0499 0.417642 12.5623 0.931049 13.0758C1.45007 13.5948 1.96808 13.8644 2.64799 13.9694C2.82029 13.996 4.26339 14.0049 7.16941 13.9975L11.4378 13.9865L11.7003 13.9055C12.2771 13.7275 12.7083 13.4735 13.0885 13.088C13.4916 12.6792 13.737 12.2647 13.9056 11.7077C13.987 11.4385 13.9886 11.3982 14.0009 9.23766C14.0091 7.79777 14.0004 6.99291 13.9756 6.9009C13.9548 6.82371 13.88 6.69296 13.8092 6.61033C13.4661 6.20947 12.8337 6.27331 12.5616 6.73626L12.4593 6.91035L12.441 9.09925L12.4228 11.2882L12.3066 11.5334C12.1451 11.8743 11.9069 12.117 11.5706 12.2832L11.2956 12.4191H7.00714H2.71865L2.47338 12.3029C2.1325 12.1414 1.88982 11.9032 1.72365 11.5669L1.58772 11.2919V7.00345V2.71496L1.70391 2.46969C1.86534 2.12888 2.10361 1.88613 2.43975 1.71996L2.71471 1.58403L4.9603 1.56579L7.2059 1.54755L7.36846 1.45634C7.61281 1.31924 7.74644 1.10557 7.76443 0.823275C7.78096 0.563781 7.71124 0.382248 7.52847 0.208777C7.30031 -0.00774129 7.35492 -0.00332719 4.97256 0.00134246C3.77304 0.00367729 2.70402 0.0201672 2.59695 0.0379703ZM13.7726 0.807514C13.6449 0.839691 13.2121 1.25828 10.3161 4.1504L7.00543 7.45644L5.64641 6.10225C4.18011 4.64115 4.18047 4.64141 3.8313 4.67497C3.58297 4.69883 3.39371 4.80886 3.25883 5.00772C3.12075 5.21133 3.07945 5.43211 3.13786 5.65432C3.17602 5.79956 3.35091 5.98715 4.86479 7.50704C5.99438 8.64115 6.59731 9.2207 6.69515 9.26648C6.87318 9.34981 7.10765 9.35532 7.28915 9.28042C7.45817 9.21067 14.5982 2.092 14.7053 1.88646C14.7958 1.71281 14.7965 1.41406 14.7068 1.21662C14.6213 1.02837 14.4111 0.854029 14.208 0.802881C14.0253 0.756878 13.9712 0.757425 13.7726 0.807514Z"
                                        fill="currentColor"></path>
                                </svg>
                            </span>
                            <p class="m-0">Restored Skin Volume</p>
                        </li>
                        <li class="d-flex align-items-center gap-2 mb-3">
                            <span class="text-secondary">
                                <svg width="15" height="14" viewBox="0 0 15 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M2.59695 0.0379703C1.96118 0.143694 1.43245 0.425953 0.931049 0.927357C0.417642 1.44076 0.148371 1.95322 0.0397285 2.62375C-0.0132428 2.95081 -0.0132428 11.0523 0.0397285 11.3794C0.148371 12.0499 0.417642 12.5623 0.931049 13.0758C1.45007 13.5948 1.96808 13.8644 2.64799 13.9694C2.82029 13.996 4.26339 14.0049 7.16941 13.9975L11.4378 13.9865L11.7003 13.9055C12.2771 13.7275 12.7083 13.4735 13.0885 13.088C13.4916 12.6792 13.737 12.2647 13.9056 11.7077C13.987 11.4385 13.9886 11.3982 14.0009 9.23766C14.0091 7.79777 14.0004 6.99291 13.9756 6.9009C13.9548 6.82371 13.88 6.69296 13.8092 6.61033C13.4661 6.20947 12.8337 6.27331 12.5616 6.73626L12.4593 6.91035L12.441 9.09925L12.4228 11.2882L12.3066 11.5334C12.1451 11.8743 11.9069 12.117 11.5706 12.2832L11.2956 12.4191H7.00714H2.71865L2.47338 12.3029C2.1325 12.1414 1.88982 11.9032 1.72365 11.5669L1.58772 11.2919V7.00345V2.71496L1.70391 2.46969C1.86534 2.12888 2.10361 1.88613 2.43975 1.71996L2.71471 1.58403L4.9603 1.56579L7.2059 1.54755L7.36846 1.45634C7.61281 1.31924 7.74644 1.10557 7.76443 0.823275C7.78096 0.563781 7.71124 0.382248 7.52847 0.208777C7.30031 -0.00774129 7.35492 -0.00332719 4.97256 0.00134246C3.77304 0.00367729 2.70402 0.0201672 2.59695 0.0379703ZM13.7726 0.807514C13.6449 0.839691 13.2121 1.25828 10.3161 4.1504L7.00543 7.45644L5.64641 6.10225C4.18011 4.64115 4.18047 4.64141 3.8313 4.67497C3.58297 4.69883 3.39371 4.80886 3.25883 5.00772C3.12075 5.21133 3.07945 5.43211 3.13786 5.65432C3.17602 5.79956 3.35091 5.98715 4.86479 7.50704C5.99438 8.64115 6.59731 9.2207 6.69515 9.26648C6.87318 9.34981 7.10765 9.35532 7.28915 9.28042C7.45817 9.21067 14.5982 2.092 14.7053 1.88646C14.7958 1.71281 14.7965 1.41406 14.7068 1.21662C14.6213 1.02837 14.4111 0.854029 14.208 0.802881C14.0253 0.756878 13.9712 0.757425 13.7726 0.807514Z"
                                        fill="currentColor"></path>
                                </svg>
                            </span>
                            <p class="m-0 ">Renewed Youthful Glow</p>
                        </li>
                        <li class="d-flex align-items-center gap-2 mb-3">
                            <span class="text-secondary">
                                <svg width="15" height="14" viewBox="0 0 15 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M2.59695 0.0379703C1.96118 0.143694 1.43245 0.425953 0.931049 0.927357C0.417642 1.44076 0.148371 1.95322 0.0397285 2.62375C-0.0132428 2.95081 -0.0132428 11.0523 0.0397285 11.3794C0.148371 12.0499 0.417642 12.5623 0.931049 13.0758C1.45007 13.5948 1.96808 13.8644 2.64799 13.9694C2.82029 13.996 4.26339 14.0049 7.16941 13.9975L11.4378 13.9865L11.7003 13.9055C12.2771 13.7275 12.7083 13.4735 13.0885 13.088C13.4916 12.6792 13.737 12.2647 13.9056 11.7077C13.987 11.4385 13.9886 11.3982 14.0009 9.23766C14.0091 7.79777 14.0004 6.99291 13.9756 6.9009C13.9548 6.82371 13.88 6.69296 13.8092 6.61033C13.4661 6.20947 12.8337 6.27331 12.5616 6.73626L12.4593 6.91035L12.441 9.09925L12.4228 11.2882L12.3066 11.5334C12.1451 11.8743 11.9069 12.117 11.5706 12.2832L11.2956 12.4191H7.00714H2.71865L2.47338 12.3029C2.1325 12.1414 1.88982 11.9032 1.72365 11.5669L1.58772 11.2919V7.00345V2.71496L1.70391 2.46969C1.86534 2.12888 2.10361 1.88613 2.43975 1.71996L2.71471 1.58403L4.9603 1.56579L7.2059 1.54755L7.36846 1.45634C7.61281 1.31924 7.74644 1.10557 7.76443 0.823275C7.78096 0.563781 7.71124 0.382248 7.52847 0.208777C7.30031 -0.00774129 7.35492 -0.00332719 4.97256 0.00134246C3.77304 0.00367729 2.70402 0.0201672 2.59695 0.0379703ZM13.7726 0.807514C13.6449 0.839691 13.2121 1.25828 10.3161 4.1504L7.00543 7.45644L5.64641 6.10225C4.18011 4.64115 4.18047 4.64141 3.8313 4.67497C3.58297 4.69883 3.39371 4.80886 3.25883 5.00772C3.12075 5.21133 3.07945 5.43211 3.13786 5.65432C3.17602 5.79956 3.35091 5.98715 4.86479 7.50704C5.99438 8.64115 6.59731 9.2207 6.69515 9.26648C6.87318 9.34981 7.10765 9.35532 7.28915 9.28042C7.45817 9.21067 14.5982 2.092 14.7053 1.88646C14.7958 1.71281 14.7965 1.41406 14.7068 1.21662C14.6213 1.02837 14.4111 0.854029 14.208 0.802881C14.0253 0.756878 13.9712 0.757425 13.7726 0.807514Z"
                                        fill="currentColor"></path>
                                </svg>
                            </span>
                            <p class="m-0 ">Increased Collagen</p>
                        </li>
                        <li class="d-flex align-items-center gap-2 mb-3">
                            <span class="text-secondary">
                                <svg width="15" height="14" viewBox="0 0 15 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M2.59695 0.0379703C1.96118 0.143694 1.43245 0.425953 0.931049 0.927357C0.417642 1.44076 0.148371 1.95322 0.0397285 2.62375C-0.0132428 2.95081 -0.0132428 11.0523 0.0397285 11.3794C0.148371 12.0499 0.417642 12.5623 0.931049 13.0758C1.45007 13.5948 1.96808 13.8644 2.64799 13.9694C2.82029 13.996 4.26339 14.0049 7.16941 13.9975L11.4378 13.9865L11.7003 13.9055C12.2771 13.7275 12.7083 13.4735 13.0885 13.088C13.4916 12.6792 13.737 12.2647 13.9056 11.7077C13.987 11.4385 13.9886 11.3982 14.0009 9.23766C14.0091 7.79777 14.0004 6.99291 13.9756 6.9009C13.9548 6.82371 13.88 6.69296 13.8092 6.61033C13.4661 6.20947 12.8337 6.27331 12.5616 6.73626L12.4593 6.91035L12.441 9.09925L12.4228 11.2882L12.3066 11.5334C12.1451 11.8743 11.9069 12.117 11.5706 12.2832L11.2956 12.4191H7.00714H2.71865L2.47338 12.3029C2.1325 12.1414 1.88982 11.9032 1.72365 11.5669L1.58772 11.2919V7.00345V2.71496L1.70391 2.46969C1.86534 2.12888 2.10361 1.88613 2.43975 1.71996L2.71471 1.58403L4.9603 1.56579L7.2059 1.54755L7.36846 1.45634C7.61281 1.31924 7.74644 1.10557 7.76443 0.823275C7.78096 0.563781 7.71124 0.382248 7.52847 0.208777C7.30031 -0.00774129 7.35492 -0.00332719 4.97256 0.00134246C3.77304 0.00367729 2.70402 0.0201672 2.59695 0.0379703ZM13.7726 0.807514C13.6449 0.839691 13.2121 1.25828 10.3161 4.1504L7.00543 7.45644L5.64641 6.10225C4.18011 4.64115 4.18047 4.64141 3.8313 4.67497C3.58297 4.69883 3.39371 4.80886 3.25883 5.00772C3.12075 5.21133 3.07945 5.43211 3.13786 5.65432C3.17602 5.79956 3.35091 5.98715 4.86479 7.50704C5.99438 8.64115 6.59731 9.2207 6.69515 9.26648C6.87318 9.34981 7.10765 9.35532 7.28915 9.28042C7.45817 9.21067 14.5982 2.092 14.7053 1.88646C14.7958 1.71281 14.7965 1.41406 14.7068 1.21662C14.6213 1.02837 14.4111 0.854029 14.208 0.802881C14.0253 0.756878 13.9712 0.757425 13.7726 0.807514Z"
                                        fill="currentColor"></path>
                                </svg>
                            </span>
                            <p class="m-0 ">Reduced hyper-pigmentation</p>
                        </li>
                        <li class="d-flex align-items-center gap-2 mb-3">
                            <span class="text-secondary">
                                <svg width="15" height="14" viewBox="0 0 15 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M2.59695 0.0379703C1.96118 0.143694 1.43245 0.425953 0.931049 0.927357C0.417642 1.44076 0.148371 1.95322 0.0397285 2.62375C-0.0132428 2.95081 -0.0132428 11.0523 0.0397285 11.3794C0.148371 12.0499 0.417642 12.5623 0.931049 13.0758C1.45007 13.5948 1.96808 13.8644 2.64799 13.9694C2.82029 13.996 4.26339 14.0049 7.16941 13.9975L11.4378 13.9865L11.7003 13.9055C12.2771 13.7275 12.7083 13.4735 13.0885 13.088C13.4916 12.6792 13.737 12.2647 13.9056 11.7077C13.987 11.4385 13.9886 11.3982 14.0009 9.23766C14.0091 7.79777 14.0004 6.99291 13.9756 6.9009C13.9548 6.82371 13.88 6.69296 13.8092 6.61033C13.4661 6.20947 12.8337 6.27331 12.5616 6.73626L12.4593 6.91035L12.441 9.09925L12.4228 11.2882L12.3066 11.5334C12.1451 11.8743 11.9069 12.117 11.5706 12.2832L11.2956 12.4191H7.00714H2.71865L2.47338 12.3029C2.1325 12.1414 1.88982 11.9032 1.72365 11.5669L1.58772 11.2919V7.00345V2.71496L1.70391 2.46969C1.86534 2.12888 2.10361 1.88613 2.43975 1.71996L2.71471 1.58403L4.9603 1.56579L7.2059 1.54755L7.36846 1.45634C7.61281 1.31924 7.74644 1.10557 7.76443 0.823275C7.78096 0.563781 7.71124 0.382248 7.52847 0.208777C7.30031 -0.00774129 7.35492 -0.00332719 4.97256 0.00134246C3.77304 0.00367729 2.70402 0.0201672 2.59695 0.0379703ZM13.7726 0.807514C13.6449 0.839691 13.2121 1.25828 10.3161 4.1504L7.00543 7.45644L5.64641 6.10225C4.18011 4.64115 4.18047 4.64141 3.8313 4.67497C3.58297 4.69883 3.39371 4.80886 3.25883 5.00772C3.12075 5.21133 3.07945 5.43211 3.13786 5.65432C3.17602 5.79956 3.35091 5.98715 4.86479 7.50704C5.99438 8.64115 6.59731 9.2207 6.69515 9.26648C6.87318 9.34981 7.10765 9.35532 7.28915 9.28042C7.45817 9.21067 14.5982 2.092 14.7053 1.88646C14.7958 1.71281 14.7965 1.41406 14.7068 1.21662C14.6213 1.02837 14.4111 0.854029 14.208 0.802881C14.0253 0.756878 13.9712 0.757425 13.7726 0.807514Z"
                                        fill="currentColor"></path>
                                </svg>
                            </span>
                            <p class="m-0 ">Improved Skin Cell Production</p>
                        </li>
                        <li class="d-flex align-items-center gap-2 mb-3">
                            <span class="text-secondary">
                                <svg width="15" height="14" viewBox="0 0 15 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M2.59695 0.0379703C1.96118 0.143694 1.43245 0.425953 0.931049 0.927357C0.417642 1.44076 0.148371 1.95322 0.0397285 2.62375C-0.0132428 2.95081 -0.0132428 11.0523 0.0397285 11.3794C0.148371 12.0499 0.417642 12.5623 0.931049 13.0758C1.45007 13.5948 1.96808 13.8644 2.64799 13.9694C2.82029 13.996 4.26339 14.0049 7.16941 13.9975L11.4378 13.9865L11.7003 13.9055C12.2771 13.7275 12.7083 13.4735 13.0885 13.088C13.4916 12.6792 13.737 12.2647 13.9056 11.7077C13.987 11.4385 13.9886 11.3982 14.0009 9.23766C14.0091 7.79777 14.0004 6.99291 13.9756 6.9009C13.9548 6.82371 13.88 6.69296 13.8092 6.61033C13.4661 6.20947 12.8337 6.27331 12.5616 6.73626L12.4593 6.91035L12.441 9.09925L12.4228 11.2882L12.3066 11.5334C12.1451 11.8743 11.9069 12.117 11.5706 12.2832L11.2956 12.4191H7.00714H2.71865L2.47338 12.3029C2.1325 12.1414 1.88982 11.9032 1.72365 11.5669L1.58772 11.2919V7.00345V2.71496L1.70391 2.46969C1.86534 2.12888 2.10361 1.88613 2.43975 1.71996L2.71471 1.58403L4.9603 1.56579L7.2059 1.54755L7.36846 1.45634C7.61281 1.31924 7.74644 1.10557 7.76443 0.823275C7.78096 0.563781 7.71124 0.382248 7.52847 0.208777C7.30031 -0.00774129 7.35492 -0.00332719 4.97256 0.00134246C3.77304 0.00367729 2.70402 0.0201672 2.59695 0.0379703ZM13.7726 0.807514C13.6449 0.839691 13.2121 1.25828 10.3161 4.1504L7.00543 7.45644L5.64641 6.10225C4.18011 4.64115 4.18047 4.64141 3.8313 4.67497C3.58297 4.69883 3.39371 4.80886 3.25883 5.00772C3.12075 5.21133 3.07945 5.43211 3.13786 5.65432C3.17602 5.79956 3.35091 5.98715 4.86479 7.50704C5.99438 8.64115 6.59731 9.2207 6.69515 9.26648C6.87318 9.34981 7.10765 9.35532 7.28915 9.28042C7.45817 9.21067 14.5982 2.092 14.7053 1.88646C14.7958 1.71281 14.7965 1.41406 14.7068 1.21662C14.6213 1.02837 14.4111 0.854029 14.208 0.802881C14.0253 0.756878 13.9712 0.757425 13.7726 0.807514Z"
                                        fill="currentColor"></path>
                                </svg>
                            </span>
                            <p class="m-0 ">Reduce Appearance of Wrinkles</p>
                        </li>
                        <li class="d-flex align-items-center gap-2 mb-3">
                            <span class="text-secondary">
                                <svg width="15" height="14" viewBox="0 0 15 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M2.59695 0.0379703C1.96118 0.143694 1.43245 0.425953 0.931049 0.927357C0.417642 1.44076 0.148371 1.95322 0.0397285 2.62375C-0.0132428 2.95081 -0.0132428 11.0523 0.0397285 11.3794C0.148371 12.0499 0.417642 12.5623 0.931049 13.0758C1.45007 13.5948 1.96808 13.8644 2.64799 13.9694C2.82029 13.996 4.26339 14.0049 7.16941 13.9975L11.4378 13.9865L11.7003 13.9055C12.2771 13.7275 12.7083 13.4735 13.0885 13.088C13.4916 12.6792 13.737 12.2647 13.9056 11.7077C13.987 11.4385 13.9886 11.3982 14.0009 9.23766C14.0091 7.79777 14.0004 6.99291 13.9756 6.9009C13.9548 6.82371 13.88 6.69296 13.8092 6.61033C13.4661 6.20947 12.8337 6.27331 12.5616 6.73626L12.4593 6.91035L12.441 9.09925L12.4228 11.2882L12.3066 11.5334C12.1451 11.8743 11.9069 12.117 11.5706 12.2832L11.2956 12.4191H7.00714H2.71865L2.47338 12.3029C2.1325 12.1414 1.88982 11.9032 1.72365 11.5669L1.58772 11.2919V7.00345V2.71496L1.70391 2.46969C1.86534 2.12888 2.10361 1.88613 2.43975 1.71996L2.71471 1.58403L4.9603 1.56579L7.2059 1.54755L7.36846 1.45634C7.61281 1.31924 7.74644 1.10557 7.76443 0.823275C7.78096 0.563781 7.71124 0.382248 7.52847 0.208777C7.30031 -0.00774129 7.35492 -0.00332719 4.97256 0.00134246C3.77304 0.00367729 2.70402 0.0201672 2.59695 0.0379703ZM13.7726 0.807514C13.6449 0.839691 13.2121 1.25828 10.3161 4.1504L7.00543 7.45644L5.64641 6.10225C4.18011 4.64115 4.18047 4.64141 3.8313 4.67497C3.58297 4.69883 3.39371 4.80886 3.25883 5.00772C3.12075 5.21133 3.07945 5.43211 3.13786 5.65432C3.17602 5.79956 3.35091 5.98715 4.86479 7.50704C5.99438 8.64115 6.59731 9.2207 6.69515 9.26648C6.87318 9.34981 7.10765 9.35532 7.28915 9.28042C7.45817 9.21067 14.5982 2.092 14.7053 1.88646C14.7958 1.71281 14.7965 1.41406 14.7068 1.21662C14.6213 1.02837 14.4111 0.854029 14.208 0.802881C14.0253 0.756878 13.9712 0.757425 13.7726 0.807514Z"
                                        fill="currentColor"></path>
                                </svg>
                            </span>
                            <p class="m-0 ">Safe for ANY skin type!</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Youtube video Section -->
<section class="video-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <!-- Video -->
                <div class="ratio ratio-16x9 rounded overflow-hidden shadow">
                    <iframe src="https://www.youtube.com/embed/HrPgcGrDPZQ" title="YouTube video" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection