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
                        <img src="{{ asset('frontend_assets/images/service/twist-banner.webp') }}"
                            class="img-fluid" alt="image" title="Twisting Microneedling" />
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
                            <span class="right-text text-capitalize fw-500">Twist Microneedling</span>
                            <span class="left-text text-capitalize fw-light">Treatment</span>
                        </h3>
                        <p class="iq-title-desc text-body">
                            At Divine Touch Therapy, we are excited to offer the ultimate MicroNeedling experience
                            utilizing cutting-edge German-engineered technology from DermaSpark: TWIST.
                        </p>
                    </div>
                    <div class="row mt-5 align-items-center">
                        <div class="col-md-6">
                            <ul class="list-inline m-0">
                                <li class="mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-primary"><i class="fas fa-check"></i></span>
                                        <span>Advanced twist microneedling technology for deeper skin
                                            rejuvenation</span>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-primary"><i class="fas fa-check"></i></span>
                                        <span>Stimulates natural collagen & elastin production</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-primary"><i class="fas fa-check"></i></span>
                                        <span>Custom depth control for precise and safe treatment</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6 mt-md-0 mt-2">
                            <ul class="list-inline m-0">
                                <li class="mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-primary"><i class="fas fa-check"></i></span>
                                        <span>Reduces acne scars, fine lines & uneven skin tone</span>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-primary"><i class="fas fa-check"></i></span>
                                        <span>Enhances absorption of serums & active ingredients</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-primary"><i class="fas fa-check"></i></span>
                                        <span>Performed under strict hygiene by certified skin experts</span>
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
                                            300+
                                        </h3>
                                        <h4 class="counter-title mb-2 fw-normal">
                                            Twist Microneedling Sessions Completed
                                        </h4>
                                        <p class="counter-text m-0 text-body">
                                            Successfully performed advanced twist microneedling treatments to improve
                                            skin texture, tone, and overall radiance.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- PROGRESS BARS -->
                            <div class="col-md-7 mt-md-0 mt-5">
                                <div>
                                    <div class="wrapper-progress">
                                        <div class="percentage-progress d-flex justify-content-between">
                                            <h6 class="mb-2 text-body">Visible Skin Rejuvenation Results</h6>
                                            <div><span>94%</span></div>
                                        </div>
                                    </div>
                                    <div class="progress" style="height: 10px">
                                        <div class="progress-bar bg-primary" role="progressbar"
                                            style="width: 94%; height: 10px" aria-valuenow="94" aria-valuemin="0"
                                            aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-5">
                                    <div class="wrapper-progress">
                                        <div class="percentage-progress d-flex justify-content-between">
                                            <h6 class="mb-2 text-body">Patient Satisfaction Rate</h6>
                                            <div><span>92%</span></div>
                                        </div>
                                    </div>
                                    <div class="progress" style="height: 10px">
                                        <div class="progress-bar bg-primary" role="progressbar"
                                            style="width: 92%; height: 10px" aria-valuenow="92" aria-valuemin="0"
                                            aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-5">
                                    <div class="wrapper-progress">
                                        <div class="percentage-progress d-flex justify-content-between">
                                            <h6 class="mb-2 text-body">
                                                Treatment Safety, Precision & Comfort
                                            </h6>
                                            <div><span>97%</span></div>
                                        </div>
                                    </div>
                                    <div class="progress" style="height: 10px">
                                        <div class="progress-bar bg-primary" role="progressbar"
                                            style="width: 97%; height: 10px" aria-valuenow="97" aria-valuemin="0"
                                            aria-valuemax="100">
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
</div>
<!-- Treatment Section -->
<div class="team-detail">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="team-member-info">
                    <div class="iq-team-block team-overdetail position-relative p-2">
                        <div class="iq-team-img">
                            <img src="{{ asset('frontend_assets/images/service/skin-rejuvenation.webp') }}" alt="Skin Rejuvenation" title="Skin Rejuvenation"
                                class="img-fluid w-100" loading="lazy">
                        </div>
                        <!-- <div class="share iq-team-social position-absolute">
                            <ul class="list-inline list-unstyled p-0 m-0">
                                <li class="mb-2">
                                    <a class="position-relative bg-primary text-white d-flex justify-content-center align-items-center"
                                        href="https://www.facebook.com/">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a class="position-relative bg-primary text-white d-flex justify-content-center align-items-center"
                                        href="https://x.com/">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a class="position-relative bg-primary text-white d-flex justify-content-center align-items-center"
                                        href="https://www.google.com/">
                                        <i class="fab fa-google"></i>
                                    </a>
                                </li>
                            </ul>
                        </div> -->
                        <!-- <div class="iq-team-info position-absolute d-block w-100">
                            <div class="iq-team-main-detail bg-white">
                                <a href="doctor-details.html">
                                    <h5>Gunner Peha</h5>
                                </a>
                                <p class="mb-0 text-uppercase fw-bolder text-primary fw-500">Cardiologist</p>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="col-lg-8 mt-lg-0 mt-5">
                <div class="iq-title-box">
                    <h3 class="iq-title iq-heading-title mb-3">
                        <span class="right-text text-capitalize">Skin</span>
                        <span class="left-text text-capitalize fw-light">Rejuvenation</span>
                    </h3>
                    <p class="iq-title-desc text-body">
                        Renowned for its groundbreaking design and exceptional results, DermaSpark's TWIST MicroNeedling
                        is a top choice for skin rejuvenation. Its innovative spiral needle configuration allows for
                        precise, controlled treatments that create microchannels in the skin, stimulating collagen
                        production and enhancing overall skin health. This advanced technology ensures impressive
                        results with minimal discomfort and downtime.
                    </p>
                    <p class="iq-title-desc text-body">
                        One of the most compelling features of TWIST MicroNeedling is its adaptability. With adjustable
                        needle lengths, we customize each treatment to target your unique skin concerns. Whether
                        addressing acne scars, fine lines, wrinkles, hyperpigmentation, or uneven texture, TWIST
                        harnesses your skin's natural healing process, leading to a radiant and rejuvenated complexion.
                    </p>
                </div>
            </div>
            <div class="col-lg-8 mt-lg-0 mt-5 pt-5">
                <div class="iq-title-box">
                    <h3 class="iq-title iq-heading-title mb-3">
                        <span class="right-text text-capitalize">Hair</span>
                        <span class="left-text text-capitalize fw-light">Loss</span>
                    </h3>
                    <p class="iq-title-desc text-body">
                        Renowned for its groundbreaking design and exceptional results, DermaSpark's TWIST MicroNeedling
                        is a top choice for skin rejuvenation. Its innovative spiral needle configuration allows for
                        precise, controlled treatments that create microchannels in the skin, stimulating collagen
                        production and enhancing overall skin health. This advanced technology ensures impressive
                        results with minimal discomfort and downtime.
                    </p>
                    <p class="iq-title-desc text-body">
                        One of the most compelling features of TWIST MicroNeedling is its adaptability. With adjustable
                        needle lengths, we customize each treatment to target your unique skin concerns. Whether
                        addressing acne scars, fine lines, wrinkles, hyperpigmentation, or uneven texture, TWIST
                        harnesses your skin's natural healing process, leading to a radiant and rejuvenated complexion.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 mt-5 pt-5">
                <div class="team-member-info">
                    <div class="iq-team-block team-overdetail position-relative p-2">
                        <div class="iq-team-img">
                            <img src="{{ asset('frontend_assets/images/service/hair-loss.webp') }}" alt="Hair Loss" title="Hair Loss"
                                class="img-fluid w-100" loading="lazy">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Video Gallery -->
<section style="padding:40px 0;" class="bg-light">
    <div class="container py-5">
        <!-- CENTER HEADING -->
        <div style="text-align:center; margin-bottom:40px;">
            <h2 style="font-size:32px; font-weight:600; color:#222; margin-bottom:10px;">
                Video Gallery
            </h2>
            <span style="
                display:inline-block;
                width:80px;
                height:3px;
                background:#000;
                border-radius:5px;
            "></span>
        </div>
        <!-- VIDEOS -->
        <div class="row g-4">
            <div class="col-lg-6 col-md-6">
                <div class="ratio ratio-16x9"
                    style="border-radius:12px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.12);">
                    <iframe src="https://www.youtube.com/embed/YlzHTIUtTEI" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="ratio ratio-16x9"
                    style="border-radius:12px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.12);">
                    <iframe src="https://www.youtube.com/embed/2tc3vsY8lkQ" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="ratio ratio-16x9"
                    style="border-radius:12px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.12);">
                    <iframe src="https://www.youtube.com/embed/tNylTFghQkU" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="ratio ratio-16x9"
                    style="border-radius:12px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.12);">
                    <iframe src="https://www.youtube.com/embed/-cEG601_Sfg" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
            </div>
            <p>
                Safety and effectiveness are paramount with TWIST. The spiral needle design minimizes the risk of skin
                tearing, ensuring a comfortable and safe experience. Precise control over needle depth further reduces
                the chances of infection or complications. In essence, DermaSpark's TWIST MicroNeedling offers a highly
                effective and personalized solution for achieving youthful, vibrant skin.
            </p>
        </div>
    </div>
</section>
<section class="mt-5">
    <div class="container py-5">
        <div style="text-align:center; margin-bottom:40px;">
            <h2 style="
                font-size:32px;
                font-weight:600;
                color:#222;
                margin-bottom:10px;
            ">
                Gallery
            </h2>
            <span style="
                display:inline-block;
                width:80px;
                height:3px;
                background:#000;
                border-radius:5px;
            "></span>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <div id="imageSlider" class="carousel slide mx-auto" data-bs-ride="carousel" style="max-width:500px;">
                    <div class="carousel-inner">
                        <!-- Slide 1 -->
                        <div class="carousel-item active">
                            <div style="
                            width:500px;
                            height:500px;
                            margin:auto;
                            overflow:hidden;
                            border-radius:12px;
                        ">
                                <img src="{{ asset('frontend_assets/images/service/twist-3.webp') }}"
                                    style="width:100%; height:100%; object-fit:cover;"
                                    alt="Twist Microneedling Image 1">
                            </div>
                        </div>
                        <!-- Slide 2 -->
                        <div class="carousel-item">
                            <div style="
                            width:500px;
                            height:500px;
                            margin:auto;
                            overflow:hidden;
                            border-radius:12px;
                        ">
                                <img src="{{ asset('frontend_assets/images/service/twist-4.webp') }}"
                                    style="width:100%; height:100%; object-fit:cover;"
                                    alt="Twist Microneedling Image 2">
                            </div>
                        </div>
                        <!-- Slide 3 -->
                        <div class="carousel-item">
                            <div style="
                            width:500px;
                            height:500px;
                            margin:auto;
                            overflow:hidden;
                            border-radius:12px;
                        ">
                                <img src="{{ asset('frontend_assets/images/service/twist-5.webp') }}"
                                    style="width:100%; height:100%; object-fit:cover;"
                                    alt="Twist Microneedling Image 3">
                            </div>
                        </div>
                        <!-- Slide 4 -->
                        <div class="carousel-item">
                            <div style="
                            width:500px;
                            height:500px;
                            margin:auto;
                            overflow:hidden;
                            border-radius:12px;
                        ">
                                <img src="{{ asset('frontend_assets/images/service/twist-6.webp') }}"
                                    style="width:100%; height:100%; object-fit:cover;"
                                    alt="Twist Microneedling Image 4">
                            </div>
                        </div>
                        <!-- Slide 5 -->
                        <div class="carousel-item">
                            <div style="
                            width:500px;
                            height:500px;
                            margin:auto;
                            overflow:hidden;
                            border-radius:12px;
                        ">
                                <img src="{{ asset('frontend_assets/images/service/twist-7.webp') }}"
                                    style="width:100%; height:100%; object-fit:cover;"
                                    alt="Twist Microneedling Image 5">
                            </div>
                        </div>
                    </div>
                    <!-- Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#imageSlider"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#imageSlider"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row row-cols-1 row-cols-md-2">
            <!-- BLOG BOX 1 -->
            <div class="col">
                <div class="iq-blog blog-standard position-relative">
                    <a href="javascript:;" class="blog-image d-block overflow-hidden">
                        <img src="{{ asset('frontend_assets/images/service/twist-1.webp') }}" alt="blog-image" title=""
                            class="img-fluid w-100" loading="lazy" />
                    </a>
                </div>
            </div>
            <!-- BLOG BOX 2 -->
            <div class="col mb-5">
                <div class="iq-blog blog-standard position-relative">
                    <a href="javascript:;" class="blog-image d-block overflow-hidden">
                        <img src="{{ asset('frontend_assets/images/service/twist-2.webp') }}" alt="twist 2"
                            class="img-fluid w-100" title="twist 2" loading="lazy" />
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection