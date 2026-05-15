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
                        <img src="{{ asset('frontend_assets/images/service/alma-laser-logo.webp') }}"
                            class="img-fluid" alt="image" title="" />
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
                            <span class="right-text text-capitalize fw-500">Laser Hair Removal</span>
                            <span class="left-text text-capitalize fw-light">Treatment</span>
                        </h3>
                        <p class="iq-title-desc text-body">
                            Laser hair removal is a cosmetic procedure which permanently removes unwanted facial and
                            body hair. We offer this service using world's best-selling laser hair removal technology
                            known as Alma Soprano by Alma Lasers. Over a course of multiple sessions, you will see your
                            hair become progressively lighter and finer as the laser gradually destroys the follicle.
                        </p>
                    </div>
                    <div class="row mt-5 align-items-center">
                        <div class="col-md-6">
                            <ul class="list-inline m-0">
                                <li class="mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-primary"><i class="fas fa-check"></i></span>
                                        <span>Permanent hair reduction solution</span>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-primary"><i class="fas fa-check"></i></span>
                                        <span>Safe for multiple skin types</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-primary"><i class="fas fa-check"></i></span>
                                        <span>Advanced laser technology</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6 mt-md-0 mt-2">
                            <ul class="list-inline m-0">
                                <li class="mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-primary"><i class="fas fa-check"></i></span>
                                        <span>Minimal discomfort & downtime</span>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-primary"><i class="fas fa-check"></i></span>
                                        <span>Suitable for face & body areas</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-primary"><i class="fas fa-check"></i></span>
                                        <span>Performed by trained professionals</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <p class="text-danger text-center fw-bold mt-5">Female and Male laser technicians available
                            for your convenience
                        </p>
                        <p class="text-dark text-center fw-bold mt-3">We offer free consultation - contact us today and
                            take advantage of our Grand opening specials!</p>
                    </div>
                    <div class="pt-5">
                        <div class="row mt-5 align-items-center">
                            <!-- COUNTER BOX -->
                            <div class="col-md-5">
                                <div class="iq-counter iq-counter-no-icon bg-primary-subtle p-3">
                                    <div class="counter-content">
                                        <h3 class="counter mt-0 mb-3 text-primary fw-500">
                                            1200+
                                        </h3>
                                        <h4 class="counter-title mb-2 fw-normal">
                                            Laser Sessions Completed
                                        </h4>
                                        <p class="counter-text m-0 text-body">
                                            Successfully performed laser hair removal treatments with visible and
                                            long-lasting results.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- PROGRESS BARS -->
                            <div class="col-md-7 mt-md-0 mt-5">
                                <div>
                                    <div class="wrapper-progress">
                                        <div class="percentage-progress d-flex justify-content-between">
                                            <h6 class="mb-2 text-body">Hair Reduction Effectiveness</h6>
                                            <div><span>95%</span></div>
                                        </div>
                                    </div>
                                    <div class="progress" style="height: 10px">
                                        <div class="progress-bar bg-primary" role="progressbar"
                                            style="width: 95%; height: 10px" aria-valuenow="95" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="mt-5">
                                    <div class="wrapper-progress">
                                        <div class="percentage-progress d-flex justify-content-between">
                                            <h6 class="mb-2 text-body">Client Satisfaction</h6>
                                            <div><span>99%</span></div>
                                        </div>
                                    </div>
                                    <div class="progress" style="height: 10px">
                                        <div class="progress-bar bg-primary" role="progressbar"
                                            style="width: 99%; height: 10px" aria-valuenow="99" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="mt-5">
                                    <div class="wrapper-progress">
                                        <div class="percentage-progress d-flex justify-content-between">
                                            <h6 class="mb-2 text-body">
                                                Safety & Comfort Level
                                            </h6>
                                            <div><span>98%</span></div>
                                        </div>
                                    </div>
                                    <div class="progress" style="height: 10px">
                                        <div class="progress-bar bg-primary" role="progressbar"
                                            style="width: 98%; height: 10px" aria-valuenow="98" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 mt-lg-0 mt-5">
                <div class="mt-5 pt-md-3 pb-5 border-bottom">
                    <div class="iq-title-box mt-5 mb-0">
                        <span class="iq-subtitle text-uppercase">TIPS & INFO</span>
                        <h4 class="iq-title iq-heading-title mb-2">
                            <!-- <span class="right-text text-capitalize fw-500">KiviCare Tips For Healthy</span>
                            <span class="left-text text-capitalize fw-light">Children And Families</span> -->
                        </h4>
                        <p class="iq-title-desc text-body">
                            At Divine Touch, we use the Soprano Lite, a revolutionary 810 nm diode laser hair removal
                            solution by Alma Lasers, a global innovator of laser, light-based, radiofrequency and
                            ultrasound solutions for the aesthetic and surgical markets. This amazing world's
                            best-selling laser hair removal technology is installed in over 3,500 clinics worldwide. It
                            features the Gold Standard 810 diode wavelength, which is backed by years of clinical proven
                            effectiveness. Combined with Super Hair Removal (SHR™), you get virtually painless hair
                            removal without sacrificing efficacy or comfort.
                        </p>
                        <p class="iq-title-desc text-body">The Soprano Lite's patented SHR technology works by gradually
                            heating the dermis to a temperature that effectively neutralises the hair follicle. This
                            means that hair follicles don't have to be exposed to a single pulse of high energy, which
                            can injure the skin and cause you pain. At the same time, the Soprano Lite protects the
                            surrounding tissue. The combination of 810 diode, SHR and cooling give you the ability to
                            offer a superior laser hair removal experience and achieve greater results</p>
                        <p class="iq-title-desc text-body">*Permanent reduction in hair regrowth defined as a long term,
                            stable reduction in the number of hairs re-growing when measured at 6, 9 and 12 months after
                            the completion of a treatment regime. SO04041601</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mt-lg-0 mt-5">
                <img src="{{ asset('frontend_assets/images/service/laser-hair-removal-2.webp') }}" alt="Laser Hair Removal" title="Laser Hair Removal"
                    class="img-fluid mt-5 pt-5">
            </div>
            <div class="col-lg-12 mt-lg-0 mt-5">
                <div class="iq-title-box mt-5 mb-0">
                    <span class="iq-subtitle text-uppercase">Frequently Asked Question</span>
                </div>
                <div class="mt-5 pt-3">
                    <div class="accordion" id="main-faq">
                        <div class="accordion-item custom-accordion mb-4 bg-white rounded-0">
                            <h5 class="accordion-header rounded-0" id="heading01">
                                <button class="accordion-button fw-500 text-capitalize gap-3" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse01" aria-expanded="true"
                                    aria-controls="collapse01">
                                    What Is Laser Hair Removal?
                                </button>
                            </h5>
                            <div id="collapse01" class="accordion-collapse collapse show" aria-labelledby="heading01"
                                data-bs-parent="#main-faq">
                                <div class="accordion-body">
                                    <p>
                                        Laser hair removal is a procedure by which unwanted body or facial hair is
                                        removed by utilizing long pulse laser.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item custom-accordion mb-4 bg-white rounded-0">
                            <h5 class="accordion-header rounded-0" id="heading02">
                                <button class="accordion-button fw-500 text-capitalize collapsed gap-3" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse02" aria-expanded="true"
                                    aria-controls="collapse02">
                                    How Does Laser Hair Removal Work?
                                </button>
                            </h5>
                            <div id="collapse02" class="accordion-collapse collapse" aria-labelledby="heading02"
                                data-bs-parent="#main-faq">
                                <div class="accordion-body">
                                    <p>
                                        A concentrated beam of laser energy is aimed at hair. The light is absorbed by
                                        the pigment of the hair follicle, which damages the follicle to minimize its
                                        growth.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item custom-accordion mb-4 bg-white rounded-0">
                            <h5 class="accordion-header rounded-0" id="heading03">
                                <button class="accordion-button fw-500 text-capitalize collapsed gap-3" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse03" aria-expanded="true"
                                    aria-controls="collapse03">
                                    Is Laser Hair Removal Safe?
                                </button>
                            </h5>
                            <div id="collapse03" class="accordion-collapse collapse" aria-labelledby="heading03"
                                data-bs-parent="#main-faq">
                                <div class="accordion-body">
                                    <p>
                                        Yes, laser hair removal is very safe when performed by an experienced medical
                                        professional. Divine Touch provides the latest technology in laser hair removal.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item custom-accordion mb-4 bg-white rounded-0">
                            <h5 class="accordion-header rounded-0" id="heading04">
                                <button class="accordion-button fw-500 text-capitalize collapsed gap-3" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse04" aria-expanded="true"
                                    aria-controls="collapse04">
                                    Is There Any Downtime Following Laser Hair Removal?
                                </button>
                            </h5>
                            <div id="collapse04" class="accordion-collapse collapse" aria-labelledby="heading04"
                                data-bs-parent="#main-faq">
                                <div class="accordion-body">
                                    <p>
                                        Laser hair removal has very minimal downtime treatment. The majority of patients
                                        can resume their normal activities shortly following treatment.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item custom-accordion mb-4 bg-white rounded-0">
                            <h5 class="accordion-header rounded-0" id="heading05">
                                <button class="accordion-button fw-500 text-capitalize collapsed gap-3" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse05" aria-expanded="true"
                                    aria-controls="collapse05">
                                    Is Laser Hair Removal Permanent?
                                </button>
                            </h5>
                            <div id="collapse05" class="accordion-collapse collapse" aria-labelledby="heading05"
                                data-bs-parent="#main-faq">
                                <div class="accordion-body">
                                    <p>
                                        A full series of laser hair removal treatments will typically result in a great
                                        reduction in hair; however hormonal conditions can slow progress, or cause new
                                        hair growth.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item custom-accordion mb-4 bg-white rounded-0">
                            <h5 class="accordion-header rounded-0" id="heading06">
                                <button class="accordion-button fw-500 text-capitalize collapsed gap-3" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse06" aria-expanded="true"
                                    aria-controls="collapse06">
                                    Where Can Laser Hair Removal Be Used?
                                </button>
                            </h5>
                            <div id="collapse06" class="accordion-collapse collapse" aria-labelledby="heading06"
                                data-bs-parent="#main-faq">
                                <div class="accordion-body">
                                    <p>
                                        Laser hair removal can be used almost anywhere on the body where unwanted or
                                        excess hair is troublesome. The face, neck, chest, back, arms, under arms, legs
                                        and bikini area can be treated safely and effectively.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item custom-accordion mb-4 bg-white rounded-0">
                            <h5 class="accordion-header rounded-0" id="heading07">
                                <button class="accordion-button fw-500 text-capitalize collapsed gap-3" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse07" aria-expanded="true"
                                    aria-controls="collapse07">
                                    Is It Permanent?
                                </button>
                            </h5>
                            <div id="collapse07" class="accordion-collapse collapse" aria-labelledby="heading07"
                                data-bs-parent="#main-faq">
                                <div class="accordion-body">
                                    <p>
                                        There is no true permanent hair removal because the body is constantly
                                        regenerating hair follicles. The result will be permanent and substantial hair
                                        reduction.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item custom-accordion mb-4 bg-white rounded-0">
                            <h5 class="accordion-header rounded-0" id="heading08">
                                <button class="accordion-button fw-500 text-capitalize collapsed gap-3" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse08" aria-expanded="true"
                                    aria-controls="collapse08">
                                    What Will I Feel During The Treatment?
                                </button>
                            </h5>
                            <div id="collapse08" class="accordion-collapse collapse" aria-labelledby="heading08"
                                data-bs-parent="#main-faq">
                                <div class="accordion-body">
                                    <p>
                                        Laser hair removal can be mildly uncomfortable. Some areas of our body are more
                                        sensitive that others, but generally laser hair removal is less painful than
                                        waxing. With each laser pulse the sensation resembles a tingling pinch which
                                        subsides after a brief second.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item custom-accordion mb-4 bg-white rounded-0">
                            <h5 class="accordion-header rounded-0" id="heading09">
                                <button class="accordion-button fw-500 text-capitalize collapsed gap-3" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse09" aria-expanded="true"
                                    aria-controls="collapse09">
                                    How Do I Prepare For A Treatment?
                                </button>
                            </h5>
                            <div id="collapse09" class="accordion-collapse collapse" aria-labelledby="heading09"
                                data-bs-parent="#main-faq">
                                <div class="accordion-body">
                                    <p>
                                        No waxing or removing hair from the root with any other means for four to six
                                        weeks prior to and throughout the course of the treatment. The hair follicle
                                        needs to be intact to be targeted by the laser. Shave the area to be treated 1-3
                                        days prior to visit. The hair should be as short as possible so that the laser
                                        can target the energy towards the hair follicles and not the hair above the
                                        skin's surface.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item custom-accordion mb-4 bg-white rounded-0">
                            <h5 class="accordion-header rounded-0" id="heading10">
                                <button class="accordion-button fw-500 text-capitalize collapsed gap-3" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse10" aria-expanded="true"
                                    aria-controls="collapse10">
                                    What Should I Expect After The Treatment?
                                </button>
                            </h5>
                            <div id="collapse10" class="accordion-collapse collapse" aria-labelledby="heading10"
                                data-bs-parent="#main-faq">
                                <div class="accordion-body">
                                    <p>
                                        After the treatment is completed, apply aloe vera to soothe the skin for a few
                                        days. Within 1-2 weeks, hair remaining in the follicle will start to extrude.
                                        The hair will look like it is growing back in, but it is just coming through the
                                        skin to shed. Shedding can last up to 3 weeks post-treatment. To help speed up
                                        the process you can exfoliate and/or scrub gently in the shower. Avoid sun
                                        exposure to the area and do not pluck the hair from the follicle. If required,
                                        shaving can be performed one week after treatment.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item custom-accordion mb-4 bg-white rounded-0">
                            <h5 class="accordion-header rounded-0" id="heading11">
                                <button class="accordion-button fw-500 text-capitalize collapsed gap-3" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse11" aria-expanded="true"
                                    aria-controls="collapse11">
                                    Will Laser Work On All Hair Colors?
                                </button>
                            </h5>
                            <div id="collapse11" class="accordion-collapse collapse" aria-labelledby="heading11"
                                data-bs-parent="#main-faq">
                                <div class="accordion-body">
                                    <p>
                                        Laser hair removal works best on dark course hair and less well with light color
                                        hair.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item custom-accordion mb-4 bg-white rounded-0">
                            <h5 class="accordion-header rounded-0" id="heading12">
                                <button class="accordion-button fw-500 text-capitalize collapsed gap-3" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse12" aria-expanded="true"
                                    aria-controls="collapse12">
                                    How Many Laser Treatments Are Needed And How Far Apart Are They Scheduled?
                                </button>
                            </h5>
                            <div id="collapse12" class="accordion-collapse collapse" aria-labelledby="heading12"
                                data-bs-parent="#main-faq">
                                <div class="accordion-body">
                                    <p>
                                        Hair grows at different rate therefore to achieve optimal hair removal a set of
                                        4-7 treatments at 4-6 weeks intervals are required.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item custom-accordion mb-4 bg-white rounded-0">
                            <h5 class="accordion-header rounded-0" id="heading13">
                                <button class="accordion-button fw-500 text-capitalize collapsed gap-3" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse13" aria-expanded="true"
                                    aria-controls="collapse13">
                                    What are the possible risks and side effects?
                                </button>
                            </h5>
                            <div id="collapse13" class="accordion-collapse collapse" aria-labelledby="heading13"
                                data-bs-parent="#main-faq">
                                <div class="accordion-body">
                                    <p>
                                        Side effects occur infrequently and are generally temporary. Normal short-term
                                        side effects include itching, feeling of numbness or tingling, redness and
                                        slight swelling of the treatment area. The side effects typically lasts less
                                        than an hour. If any of the above last for more than 3 days, contact your
                                        technician as it is possible that the setting were set too high and should be
                                        adjusted for your next treatment. Rare side effects includes bruising,
                                        crusting/scab formation (on ingrown hairs), purpura (purple colouring of the
                                        skin) on tanned areas, and temporary pigment change (hyper-pigmentation).
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection