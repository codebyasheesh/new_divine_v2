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
                        <img src="{{ asset('frontend_assets/images/service/divine-logo.png') }}" class="img-fluid" alt="image" title="" />
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
                    <!-- <div class="sidebar-widget-social-list mt-5">
                        <ul class="list-inline m-0 p-0 d-flex align-items-center gap-3 flex-wrap">
                            <li>
                                <a href="https://www.facebook.com/" class="facebook-icon">
                                    <i class="fab fa-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://x.com/" class="twitter-icon">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.youtube.com/" class="youtube-icon">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/" class="linkedin-icon">
                                    <i class="fab fa-linkedin"></i>
                                </a>
                            </li>
                        </ul>
                    </div> -->
                </div>
            </div>
            <div class="col-lg-8 mt-lg-0 mt-5">
                <div class="about-service">
                    <div class="position-relative">
                        <img src="{{ asset('frontend_assets/images/service/massage-therapy-banner.webp') }}" class="img-fluid"
                            alt="Massage Therapy" title="Massage Therapy" />
                        <!-- <div class="iq-popup-video">
                            <div class="iq-video-icon position-absolute">
                                <div
                                    class="iq-video bg-white position-absolute text-center d-inline-block iq-fslightbox-img">
                                    <a class="d-block" data-fslightbox="html5-video"
                                        href="https://www.youtube.com/watch?v&#x3D;VeDdpy4CdeM"
                                        data-video-poster='&lt;i aria-hidden="true" class="fas fa-play text-primary"&gt;&lt;/i&gt;'>
                                        <i aria-hidden="true" class="fas fa-play text-primary"></i>
                                    </a>
                                </div>
                                <div class="iq-waves">
                                    <div class="waves position-absolute rounded-0 wave-1"></div>
                                    <div class="waves position-absolute rounded-0 wave-2"></div>
                                    <div class="waves position-absolute rounded-0 wave-3"></div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div class="iq-title-box mt-5 mb-0">
                        <span class="iq-subtitle text-uppercase">Service</span>
                        <h3 class="iq-title iq-heading-title mb-2">
                            <span class="right-text text-capitalize fw-500">Massage Therapy</span>
                            <span class="left-text text-capitalize fw-light">Treatment</span>
                        </h3>
                        <p class="iq-title-desc text-body">
                            Massage therapy can be one of the powerful tools in your healthcare regimen. This not only
                            alleviates pain and tension but improves the flexibility and blood circulation. It is for a
                            variety of reasons i.e. reduce stress and anxiety, relax muscles, rehabilitate injuries,
                            reduce pain, and promote overall health and wellness. So step out and experience a sumptuous
                            care of your body.
                        </p>
                        <p class="iq-title-desc text-body">Massage Therapy is provided by the experienced Registered
                            Massage Therapist and Clinic Director Sonia Chanana</p>
                        <p class="iq-title-desc text-body">We offer convenient and secure Direct Insurance Billing
                            option for our RMT clients with Extended Healthcare Benefits and WSIB coverages. All you
                            have to pay for is your portion of the payment. Additionally, we accept multiple forms of
                            payment including <strong>Cash, Credit, Debit, INTERAC e-transfer</strong></p>
                    </div>
                    <div class="row mt-5 align-items-center">
                        <div class="col-md-6">
                            <ul class="list-inline m-0">
                                <li class="mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-primary"><i class="fas fa-check"></i></span>
                                        <span>Customized massage therapies based on body needs</span>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-primary"><i class="fas fa-check"></i></span>
                                        <span>Suitable for stress relief, pain management & relaxation</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-primary"><i class="fas fa-check"></i></span>
                                        <span>Professional techniques using therapeutic oils</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6 mt-md-0 mt-2">
                            <ul class="list-inline m-0">
                                <li class="mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-primary"><i class="fas fa-check"></i></span>
                                        <span>Relieves muscle tension & improves blood circulation</span>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-primary"><i class="fas fa-check"></i></span>
                                        <span>Reduces fatigue, stiffness & body pain</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-primary"><i class="fas fa-check"></i></span>
                                        <span>Performed by certified and experienced massage therapists</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="mt-5">
    <div class="container">
        <div style="text-align:center; margin-bottom:40px;">
            <h2 style="
                font-size:32px;
                font-weight:600;
                color:#222;
                margin-bottom:10px;
            ">
                Find The Massage Technique That Works Best For You
            </h2>
            <span style="
                display:inline-block;
                width:80px;
                height:3px;
                background:#000;
                border-radius:5px;
            "></span>
        </div>
        <div class="row row-cols-1 row-cols-md-2">
            <!-- BLOG BOX 1 -->
            <div class="col">
                <div class="iq-blog blog-standard position-relative">
                    <a href="javascript:;" class="blog-image d-block overflow-hidden">
                        <img src="{{ asset('frontend_assets/images/service/swedish-massage.webp') }}" alt="Swedish Massage"
                            title="Swedish Massage" class="img-fluid w-100" loading="lazy" />
                    </a>
                    <div class="iq-post-details bg-white p-4">
                        <div class="iq-blog-cat bg-primary text-white d-inline">
                            <a href="javascript:void(0);" class="text-white">
                                Swedish Massage
                            </a>
                        </div>
                        <div class="blog-title mb-2">
                            <p class="text-capitalize fw-25 mt-5" style="font-size:14px;">
                                This most common massage promotes relaxation, eases muscle tension and improves
                                circulation as well as flexibility. Swedish Relaxation massage involves long, fluid
                                strokes of muscles and tissues with pressure that varies from light to medium to firm -
                                adjusted according to your sensitivity and preference.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- BLOG BOX 2 -->
            <div class="col mb-5">
                <div class="iq-blog blog-standard position-relative">
                    <a href="javascript:;" class="blog-image d-block overflow-hidden">
                        <img src="{{ asset('frontend_assets/images/service/deep-tissue-massage.webp') }}"
                            alt="Deep Tissue Massage" class="img-fluid w-100" title="Deep Tissue Massage" loading="lazy" />
                    </a>
                    <div class="iq-post-details bg-white p-4">
                        <div class="iq-blog-cat bg-primary text-white d-inline">
                            <a href="javascript:;" class="text-white">
                                Deep Tissue
                            </a>
                        </div>
                        <div class="blog-title mb-2">
                            <p class="text-capitalize fw-25 mt-5" style="font-size:14px;">
                                This is an intense massage which targets knots and releases chronic muscle tension. It
                                focuses on the deepest layers of the muscle and fascia tissues through deep guided
                                strokes and firm pressure. Deep Tissue Massage is often recommended for individuals who
                                experience consistent muscle pain and soreness.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- BLOG BOX 3 -->
            <div class="col mb-5">
                <div class="iq-blog blog-standard position-relative">
                    <a href="javascript:;" class="blog-image d-block overflow-hidden">
                        <img src="{{ asset('frontend_assets/images/service/trigger-point-massage.webp') }}"
                            alt="Trigger Point Massage" class="img-fluid w-100" title="Trigger Point Massage" loading="lazy" />
                    </a>
                    <div class="iq-post-details bg-white p-4">
                        <div class="iq-blog-cat bg-primary text-white d-inline">
                            <a href="javascript:;" class="text-white">
                                Trigger Point Massage
                            </a>
                        </div>
                        <div class="blog-title mb-2">
                            <p class="text-capitalize fw-25 mt-5" style="font-size:14px;">
                                This technique is specifically designed to alleviate the source of the pain through
                                cycles of isolated and concentrated finger pressure and release on trigger points, also
                                known as knots. This type of therapy often shows significant improvement after just one
                                session. Treatments in regular intervals help manage chronic pains.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- BLOG BOX 4 -->
            <div class="col mb-5">
                <div class="iq-blog blog-standard position-relative">
                    <a href="javascript:;" class="blog-image d-block overflow-hidden">
                        <img src="{{ asset('frontend_assets/images/service/paregnent-lady-massage.webp') }}"
                            alt="Paregnent Lady Massage" class="img-fluid w-100" title="Paregnent Lady Massage" loading="lazy" />
                    </a>
                    <div class="iq-post-details bg-white p-4">
                        <div class="iq-blog-cat bg-primary text-white d-inline">
                            <a href="javascript:;" class="text-white">
                                Prenatal Massage
                            </a>
                        </div>
                        <div class="blog-title mb-2">
                            <p class="text-capitalize fw-25 mt-5" style="font-size:14px;">
                                Prenatal Massage is a nurturing massage that focuses on the special needs during
                                pregnancy. Mother and baby share in the benefits as stress and tension melt away,
                                leaving you feeling balanced and energized. Please consult with your doctor to see if
                                Prenatal Massage is right for you.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- BLOG BOX 5 -->
            <div class="col mb-5">
                <div class="iq-blog blog-standard position-relative">
                    <a href="javascript:;" class="blog-image d-block overflow-hidden">
                        <img src="{{ asset('frontend_assets/images/service/hot-stone-massage.webp') }}"
                            alt="Hot Stone Massage Therapy" class="img-fluid w-100" title="Hot Stone Massage Therapy" loading="lazy" />
                    </a>
                    <div class="iq-post-details bg-white p-4">
                        <div class="iq-blog-cat bg-primary text-white d-inline">
                            <a href="javascript:;" class="text-white">
                                Hot Stone
                            </a>
                        </div>
                        <div class="blog-title mb-2">
                            <p class="text-capitalize fw-25 mt-5" style="font-size:14px;">
                                Hot Stone is another Add On option designed to relieve stress and stiffness with heated
                                basalt stones. The penetrating effects of the heated stones melts tension and leads to
                                deep relaxation and peace.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection