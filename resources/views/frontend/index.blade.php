@extends('frontend.layouts.app')


@section('content')
<div class="skin-specialist-banner position-relative overflow-hidden">
    <div class="container-fluid">
        <div class="row align-items-center">
        <div class="col-lg-5">
            <div class="no-sub-title big-font py-lg-5">
                <div class="iq-title-box">
                    <span class="iq-subtitle text-uppercase"></span>
                    <h2 class="iq-title iq-heading-title">
                    <span class="right-text text-capitalize fw-500">The Balance Of</span>
                    <span class="left-text text-capitalize fw-light">Body Mind & Soul</span>
                    </h2>
                    <p class="iq-title-desc text-body mt-3 mb-0">
                    Heal your body, mind, and soul as you feel the soothing power of a human touch that is nothing short of Divine!
                    </p>
                </div>               
                <div class="row align-items-center">
                    <div class="col-xl-5 col-sm-6 pe-sm-2">
                    <div class="banner-btn text-lg-start text-sm-end text-center">
                        <div class="button-primary">
                            <div class="iq-btn-container">
                                <a class="iq-button text-capitalize" href="{{ route('book_appointment') }}" style="background-color:rgb(24, 23, 23);>
                                <span class="iq-btn-text-holder position-relative">Appointment</span>
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
                    <div class="col-xl-5 col-sm-6 ps-sm-2 mt-sm-0 mt-4">
                    <div class="d-flex align-items-center justify-content-sm-start justify-content-center">
                        <h2 class="mb-0">4.7</h2>
                        <div class="ps-3">
                            <div class="ratting">
                                <svg class="icon-20" xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 24 24" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13.1043 4.17701L14.9317 7.82776C15.1108 8.18616 15.4565 8.43467 15.8573 8.49218L19.9453 9.08062C20.9554 9.22644 21.3573 10.4505 20.6263 11.1519L17.6702 13.9924C17.3797 14.2718 17.2474 14.6733 17.3162 15.0676L18.0138 19.0778C18.1856 20.0698 17.1298 20.8267 16.227 20.3574L12.5732 18.4627C12.215 18.2768 11.786 18.2768 11.4268 18.4627L7.773 20.3574C6.87023 20.8267 5.81439 20.0698 5.98724 19.0778L6.68385 15.0676C6.75257 14.6733 6.62033 14.2718 6.32982 13.9924L3.37368 11.1519C2.64272 10.4505 3.04464 9.22644 4.05466 9.08062L8.14265 8.49218C8.54354 8.43467 8.89028 8.18616 9.06937 7.82776L10.8957 4.17701C11.3477 3.27433 12.6523 3.27433 13.1043 4.17701Z" fill="#FFD329"/>
                                </svg>
                                <svg class="icon-20" xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 24 24" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13.1043 4.17701L14.9317 7.82776C15.1108 8.18616 15.4565 8.43467 15.8573 8.49218L19.9453 9.08062C20.9554 9.22644 21.3573 10.4505 20.6263 11.1519L17.6702 13.9924C17.3797 14.2718 17.2474 14.6733 17.3162 15.0676L18.0138 19.0778C18.1856 20.0698 17.1298 20.8267 16.227 20.3574L12.5732 18.4627C12.215 18.2768 11.786 18.2768 11.4268 18.4627L7.773 20.3574C6.87023 20.8267 5.81439 20.0698 5.98724 19.0778L6.68385 15.0676C6.75257 14.6733 6.62033 14.2718 6.32982 13.9924L3.37368 11.1519C2.64272 10.4505 3.04464 9.22644 4.05466 9.08062L8.14265 8.49218C8.54354 8.43467 8.89028 8.18616 9.06937 7.82776L10.8957 4.17701C11.3477 3.27433 12.6523 3.27433 13.1043 4.17701Z" fill="#FFD329"/>
                                </svg>
                                <svg class="icon-20" xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 24 24" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13.1043 4.17701L14.9317 7.82776C15.1108 8.18616 15.4565 8.43467 15.8573 8.49218L19.9453 9.08062C20.9554 9.22644 21.3573 10.4505 20.6263 11.1519L17.6702 13.9924C17.3797 14.2718 17.2474 14.6733 17.3162 15.0676L18.0138 19.0778C18.1856 20.0698 17.1298 20.8267 16.227 20.3574L12.5732 18.4627C12.215 18.2768 11.786 18.2768 11.4268 18.4627L7.773 20.3574C6.87023 20.8267 5.81439 20.0698 5.98724 19.0778L6.68385 15.0676C6.75257 14.6733 6.62033 14.2718 6.32982 13.9924L3.37368 11.1519C2.64272 10.4505 3.04464 9.22644 4.05466 9.08062L8.14265 8.49218C8.54354 8.43467 8.89028 8.18616 9.06937 7.82776L10.8957 4.17701C11.3477 3.27433 12.6523 3.27433 13.1043 4.17701Z" fill="#FFD329"/>
                                </svg>
                                <svg class="icon-20" xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 24 24" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13.1043 4.17701L14.9317 7.82776C15.1108 8.18616 15.4565 8.43467 15.8573 8.49218L19.9453 9.08062C20.9554 9.22644 21.3573 10.4505 20.6263 11.1519L17.6702 13.9924C17.3797 14.2718 17.2474 14.6733 17.3162 15.0676L18.0138 19.0778C18.1856 20.0698 17.1298 20.8267 16.227 20.3574L12.5732 18.4627C12.215 18.2768 11.786 18.2768 11.4268 18.4627L7.773 20.3574C6.87023 20.8267 5.81439 20.0698 5.98724 19.0778L6.68385 15.0676C6.75257 14.6733 6.62033 14.2718 6.32982 13.9924L3.37368 11.1519C2.64272 10.4505 3.04464 9.22644 4.05466 9.08062L8.14265 8.49218C8.54354 8.43467 8.89028 8.18616 9.06937 7.82776L10.8957 4.17701C11.3477 3.27433 12.6523 3.27433 13.1043 4.17701Z" fill="#FFD329"/>
                                </svg>
                                <svg class="icon-20" xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 24 24" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M13.1043 4.17701L14.9317 7.82776C15.1108 8.18616 15.4565 8.43467 15.8573 8.49218L19.9453 9.08062C20.9554 9.22644 21.3573 10.4505 20.6263 11.1519L17.6702 13.9924C17.3797 14.2718 17.2474 14.6733 17.3162 15.0676L18.0138 19.0778C18.1856 20.0698 17.1298 20.8267 16.227 20.3574L12.5732 18.4627C12.215 18.2768 11.786 18.2768 11.4268 18.4627L7.773 20.3574C6.87023 20.8267 5.81439 20.0698 5.98724 19.0778L6.68385 15.0676C6.75257 14.6733 6.62033 14.2718 6.32982 13.9924L3.37368 11.1519C2.64272 10.4505 3.04464 9.22644 4.05466 9.08062L8.14265 8.49218C8.54354 8.43467 8.89028 8.18616 9.06937 7.82776L10.8957 4.17701C11.3477 3.27433 12.6523 3.27433 13.1043 4.17701Z" fill="#FFD329"/>
                                </svg>
                            </div>                           
                            <h6 class="mt-1">61 Reviews</h6>
                        </div>
                    </div>
                    </div>
                    <div class="col-xl-2 d-xl-block d-none">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-1"></div>
        <div class="col-lg-6 mt-5 mt-lg-0">
            <div class="banner-image">
                <img src="{{asset('frontend_assets/images/skin-specialist/skin-specialist-banner.webp')}}" alt="banner"
                    class="img-fluid rtl-image-flip">
            </div>
            <div class="banner-right-text">
                <div class="scrolling-text position-absolute">
                    <div class="iq-title text-uppercase">Beauty</div>
                </div>            </div>
        </div>
        </div>
    </div>
</div>
{{-- <div class="divine-section">
    <div class="container">
        <div class="row">
        <div class="col-lg-12 d-flex justify-content-center">
            <div class="text-center">
                <img src="{{asset('frontend_assets/images/divine-touch-large.gif')}}" alt="Welcome to Divine Touch" title="Welcome to Divine Touch" class="img-fluid">
                <div class="fs-1 mt-3" style="font-family:'Tangerine', cursive; color:#e53a40;">Welcome to Divine Touch</div>
            </div>
        </div>
        </div>
    </div>
</div> --}}
<div class="bg-primary-subtle skin-specialist-services">
    <div class="container">
        <div class="card mb-0">
        <div class="card-body p-0">
            <div class="row align-items-center m-0">
                <div class="col-lg-4 p-3 p-md-5">
                    <div class="iq-title-box">
                    <span class="iq-subtitle text-uppercase">OUR SERVICES</span>
                    <h2 class="iq-title iq-heading-title">
                        <span class="right-text text-capitalize fw-500">Welcome To</span>
                        <span class="left-text text-capitalize fw-light">Divine Touch Therapy</span>
                    </h2>
                    <p class="iq-title-desc text-body mt-3 mb-0">
                        Divine Touch is a home based Massage Therapy Clinic Located in Caledon Ontario and operated by a Registered Massage Therapist who is genuine and passionate about your health care needs.
                    </p>
                    <p class="iq-title-desc text-body mt-3 mb-0">While based in a comfortable home-like setting, Divine Touch still offers that professional ambiance of a real therapeutic clinic such as a reception, client waiting area, and a private practice/treatment room. We also have a separate business entrance directly into the clinic.
                    </p>
                    <p class="iq-title-desc text-body mt-3 mb-0">
                        In addition to the holistic and therapeutic services, Divine Touch also offers Skin Care and Hair Removal services which are provided by a fully certified and experienced aesthetician.
                    </p>
                    <p class="iq-title-desc text-body mt-3 mb-0">
                        At Divine Touch, we strive to bring you to an optimal state of well being - physically, emotionally, mentally, and spiritually. We operate by appointment only to ensure each and every one of our clients receives the full attention and care they deserve.
                    </p>
                    </div>                  
                    {{-- <div class="mt-4">
                    <div class="button-primary">
                        <div class="iq-btn-container">
                            <a class="iq-button text-capitalize" href="javascript:void(0);" style="background-color:rgb(24, 23, 23);">
                                <span class="iq-btn-text-holder position-relative">Read More</span>
                                <span class="iq-btn-icon-holder">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 8 8" fill="none">
                                    <path d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z" fill="currentColor"></path>
                                </svg>
                                </span>
                            </a>
                        </div>                     
                    </div>
                    </div> --}}
                </div>
                <div class="col-lg-8 p-md-5 p-0 border-start">
                    <div class="row py-0 py-md-5">
                    <div class="col-md-6">
                        <div class="no-img-bg pe-lg-5">
                            <div class="iq-icon-box transprent iconbox-has-border">
                                <div class="iq-img-area pulse-shrink-on-hover d-inline-block">
                                <img
                                    src="{{ asset('frontend_assets/images/skin-specialist/anti-ageing-treatment-blk-1.png') }}"
                                    alt="icon"
                                    class="img-fluid"
                                    loading="lazy"
                                />
                                </div>
                                <div class="icon-box-content mt-5">
                                <h4 class="mb-2">Massage Therapy</h4>
                                <p class="text-body m-0"> Massage therapy relieves stress, improves circulation, eases pain, and enhances relaxation.</p>
                                </div>
                            </div>
                        </div>
                        <div class="no-img-bg pe-lg-5 mt-0 mt-lg-5 mt-md-5">
                            <div class="iq-icon-box transprent iconbox-has-border">
                                <div class="iq-img-area pulse-shrink-on-hover d-inline-block">
                                <img
                                    src="{{asset('frontend_assets/images/skin-specialist/laser-treatment-blk-1.png')}}"
                                    alt="icon"
                                    class="img-fluid"
                                    loading="lazy"
                                />
                                </div>
                                <div class="icon-box-content mt-5">
                                <h4 class="mb-2">Laser Hair Removal</h4>
                                <p class="text-body m-0">Laser hair removal reduces unwanted hair growth, offering smooth skin with lasting results.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="no-img-bg pe-lg-5">
                            <div class="iq-icon-box transprent iconbox-has-border">
                                <div class="iq-img-area pulse-shrink-on-hover d-inline-block">
                                <img
                                    src="{{asset('frontend_assets/images/skin-specialist/skin-treatment-blk-1.png')}}"
                                    alt="icon"
                                    class="img-fluid"
                                    loading="lazy"
                                />
                                </div>
                                <div class="icon-box-content mt-5">
                                <h4 class="mb-2">Skin Care</h4>
                                <p class="text-body m-0">Skin care keeps skin healthy, glowing, protected, and prevents aging, acne, and dryness.</p>
                                </div>
                            </div>
                        </div>
                        <div class="no-img-bg pe-lg-5 mt-0 mt-lg-5 mt-md-5">
                            <div class="iq-icon-box transprent">
                                <div class="iq-img-area pulse-shrink-on-hover d-inline-block">
                                <img
                                src="{{asset('frontend_assets/images/skin-specialist/plastic-surgery-blk-1.png')}}"
                                alt="icon"
                                class="img-fluid"
                                loading="lazy"
                                />
                                </div>
                                <div class="icon-box-content mt-5">
                                <h4 class="mb-2">Add-On Servies</h4>
                                <p class="text-body m-0">Add-on services enhance main treatments, offering extra care, customization, and client satisfaction.</p>
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
<div class="section-padding">
    <div class="container">
        <div class="text-center position-relative">
         <div class="scrolling-text position-absolute">
            <div class="iq-title text-uppercase">Our Commitment</div>
         </div>         
         <div class="iq-title-box">
            <span class="iq-subtitle text-uppercase">Commitment</span>
            <h2 class="iq-title iq-heading-title">
               <span class="right-text text-capitalize fw-500">Our Commitment </span>
               <span class="left-text text-capitalize fw-light">To You</span>
            </h2>
            <p class="iq-title-desc text-body mt-3 mb-0">

            </p>
         </div>      
        </div>
        <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="iq-icon-box iconbox-list p-3 p-md-5">
                <div class="iq-img-area">
                    <img src="{{asset('frontend_assets/images/skin-specialist/hygiene-blk.webp')}}" alt="icon" class="img-fluid" loading="lazy">
                </div>
                <div class="icon-box-content mt-5">
                    <h4 class="mb-2">Hygiene</h4>
                    <p>We place high importance on cleanliness and hygiene, and ensure peace of mind for you.</p>
                    {{-- <ul class="list-inline m-0">
                    <li class="mb-2 d-flex align-items-center gap-2"><i aria-hidden="true" class="fas fa-chevron-right text-primary"></i>I need help managing my pain</li>
                    <li class="d-flex align-items-center gap-2"><i aria-hidden="true" class="fas fa-chevron-right text-primary"></i>Advance
                        Advisory Team</li>
                    </ul> --}}
                </div>
            </div>         </div>
        <div class="col-lg-3 col-md-6 mt-5 mt-md-0 active">
            <div class="iq-icon-box iconbox-list p-3 p-md-5">
                <div class="iq-img-area">
                    <img src="{{asset('frontend_assets/images/skin-specialist/privacy-blk.webp')}}" alt="Privacy Icon" class="img-fluid" loading="lazy">
                </div>
                <div class="icon-box-content mt-5">
                    <h4 class="mb-2">Privacy</h4>
                    <p>We understand the value of your privacy and maintain full confidentiality of all treatment rendered.</p>
                    {{-- <ul class="list-inline m-0">
                    <li class="mb-2 d-flex align-items-center gap-2"><i aria-hidden="true" class="fas fa-chevron-right text-primary"></i>I need help managing my pain</li>
                    <li class="d-flex align-items-center gap-2"><i aria-hidden="true" class="fas fa-chevron-right text-primary"></i>Advance Advisory Team</li>
                    </ul> --}}
                </div>
            </div>         
        </div>
        <div class="col-lg-3 mt-5 mt-lg-0">
                <div class="iq-icon-box iconbox-list p-3 p-md-5">
                    <div class="iq-img-area">
                        <img src="{{asset('frontend_assets/images/skin-specialist/convenience-blk.webp')}}" alt="icon" class="img-fluid" loading="lazy">
                    </div>
                    <div class="icon-box-content mt-5">
                        <h4 class="mb-2">Convenience</h4>
                        {{-- <ul class="list-inline m-0">
                        <li class="mb-2 d-flex align-items-center gap-2"><i aria-hidden="true" class="fas fa-chevron-right text-primary"></i>I need help managing my pain</li>
                        <li class="d-flex align-items-center gap-2"><i aria-hidden="true" class="fas fa-chevron-right text-primary"></i>Advance
                            Advisory Team</li>
                        </ul> --}}
                        <p>We offer multiple payment options as well as Direct Insurance Billing for RMT services for clients with coverage</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mt-5 mt-lg-0">
                <div class="iq-icon-box iconbox-list p-3 p-md-5">
                    <div class="iq-img-area">
                        <img src="{{asset('frontend_assets/images/skin-specialist/consistency-blk.webp')}}" alt="Consistency icon" class="img-fluid" loading="lazy">
                    </div>
                    <div class="icon-box-content mt-5">
                        <h4 class="mb-2">Consistency</h4>
                        {{-- <ul class="list-inline m-0">
                        <li class="mb-2 d-flex align-items-center gap-2"><i aria-hidden="true" class="fas fa-chevron-right text-primary"></i>I need help managing my pain</li>
                        <li class="d-flex align-items-center gap-2"><i aria-hidden="true" class="fas fa-chevron-right text-primary"></i>Advance
                            Advisory Team</li>
                        </ul> --}}
                        <p>Whether you are our first-time guest or a loyal client, you'll always receive same high standard of service.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <div class="section-about">
    <div class="container-fluid p-0">
        <div class="row align-items-center gx-0">
        <div class="col-lg-6 position-relative">
            <div class="about-banner">
                <img src="{{asset('frontend_assets/images/skin-specialist/about-banner.webp')}}" alt="banner"
                    class="img-fluid">
                <div class="banner-detail-slider position-absolute bg-white p-4 text-center d-none d-xl-block">
                    <div class="overflow-hidden">
                    <div class="swiper swiper-general" id="titlebox-slider" data-slide="1" data-laptop="1"
                        data-tab="1" data-mobile="1" data-mobile-sm="1" data-autoplay="true" data-loop="true"
                        data-navigation="true" data-pagination="true">
                        <ul class="p-0 m-0 swiper-wrapper list-inline">
                            <li class="swiper-slide">
                                <div class="text-slider-content position-relative">
                                <h2 class="iq-title iq-heading-title">23</h2>
                                <p class="iq-title-desc mb-0">Good Experience in skin treatment</p>
                                </div>                           </li>
                            <li class="swiper-slide">
                                <div class="text-slider-content position-relative">
                                <h2 class="iq-title iq-heading-title">500</h2>
                                <p class="iq-title-desc mb-0">Good Experience in skin treatment</p>
                                </div>                           </li>
                        </ul>
                        <div class="swiper-pagination"></div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 ps-lg-5 position-relative">
            <div class="py-lg-0 px-lg-0 px-md-5 px-3 py-5">
                <div class="scrolling-text position-absolute">
                    <div class="iq-title text-uppercase">about us</div>
                </div>               <div class="iq-title-box">
                    <span class="iq-subtitle text-uppercase">About DivineTouch</span>
                    <h2 class="iq-title iq-heading-title">
                    <span class="right-text text-capitalize fw-500">The world's Best Skin Care</span>
                    <span class="left-text text-capitalize fw-light">treatment</span>
                    </h2>
                    <p class="iq-title-desc text-body mt-3 mb-0">
                        Skin care treatment helps maintain healthy, glowing skin by cleansing, hydrating, and protecting it from damage, while addressing issues like acne, dryness, and premature aging.
                    </p>
                </div>               
                <div class="row w-100">
                    <div class="col-md-6">
                    <ul class="iq-list-with-icon p-0 ">
                        <li class="d-flex align-items-center gap-2 mb-3">
                            <i class="fa fa-check text-primary" aria-hidden="true"></i>
                            <span>Deep cleanses and detoxifies the skin</span>
                        </li>
                        <li class="d-flex align-items-center gap-2 mb-3">
                            <i class="fa fa-check text-primary" aria-hidden="true"></i>
                            <span>Reduces signs of aging and fine lines</span>
                        </li>
                    </ul>
                    </div>
                    <div class="col-md-6">
                    <ul class="iq-list-with-icon p-0">
                        <li class="d-flex align-items-center gap-2 mb-3">
                            <i class="fa fa-check text-primary" aria-hidden="true"></i>
                            <span>Improves skin texture and tone</span>
                        </li>
                        <li class="d-flex align-items-center gap-2 mb-3">
                            <i class="fa fa-check text-primary" aria-hidden="true"></i>
                            <span>Provides personalized skincare routines</span>
                        </li>
                    </ul>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="button-primary">
                    <div class="iq-btn-container">
                        <a class="iq-button text-capitalize" href="./about-us.html" style="background-color:rgb(24, 23, 23);>
                            <span class="iq-btn-text-holder position-relative">Read More</span>
                            <span class="iq-btn-icon-holder">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 8 8" fill="none">
                                <path d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z" fill="currentColor"></path>
                                </svg>
                            </span>
                        </a>
                    </div>                  </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2"></div>
        </div>
    </div>
</div> --}}
<div class="video-section">
    <div class="video-section-background">
        <img src="{{asset('frontend_assets/images/divine-touch-banner1.jpg')}}" class="img-fluid">
    </div>
</div>
 
<div class="section-padding bg-primary-subtle testimonial-section">
    <div class="container position-relative">
        <div class="scrolling-text position-absolute">
        <div class="iq-title text-uppercase">Testimonial</div>
        </div>      <div class="row align-items-center">
        <div class="col-lg-5">
            <div class="iq-title-box">
                <span class="iq-subtitle text-uppercase">Divine Touch Therapy Testimonial</span>
                <h2 class="iq-title iq-heading-title">
                    <span class="right-text text-capitalize fw-500">What Our Patients
                        Say</span>
                    <span class="left-text text-capitalize fw-light">about our Treatment</span>
                </h2>
                <p class="iq-title-desc text-body mt-3 mb-0">
                    
                </p>
            </div>         
        </div>
        <div class="col-lg-1"></div>
        <div class="col-lg-6 position-relative">
            <div class="overflow-hidden swiper swiper-general" data-slide="1" data-laptop="1" data-tab="1" data-mobile="1"
                data-mobile-sm="1" data-autoplay="true" data-loop="false" data-navigation="true" data-pagination="true">
                <ul class="p-0 m-0 mb-2 swiper-wrapper list-inline">
                    <li class="swiper-slide">
                    <div class="iq-testimonial testimonial-standard">
                        <div class="iq-testimonial-content">
                            <p class="text-body fw-normal fst-italic">
                                “Highly recommend Sonia for RMT services. She is very knowledgeable, takes her time and truly cares about you. Her clinical set up is clean and very professional.”
                            </p>
                        </div>
                        <div class="iq-testimonial-member mt-5 d-flex gap-3">
                            <div class="iq-testimonial-avtar">
                                <img src="{{asset('frontend_assets/images/testimonial/r.jpg')}}" alt="user" class="img-fluid rounded-circle" loading="lazy">
                            </div>
                            <div class="avtar-name">
                                <h5 class="iq-lead text-capitalize m-0">Roop Kaur</h5>
                                <span class="iq-post-meta text-secondary text-capitalize">Patient</span>
                            </div>
                        </div>
                    </div>                  </li>
                    <li class="swiper-slide">
                        <div class="iq-testimonial testimonial-standard">
                            <div class="iq-testimonial-content">
                                <p class="text-body fw-normal fst-italic">
                                    “Sonia is a very professional and conscientious therapist.Her efforts go beyond what I expected having had massage therapy with other registered massage therapists many times in the past.Walking into her clinic feels like the therapy appointment is already taking place with the calm, clean and serene environment before me.”
                                </p>
                            </div>
                            <div class="iq-testimonial-member mt-5 d-flex gap-3">
                                <div class="iq-testimonial-avtar">
                                    <img src="{{asset('frontend_assets/images/testimonial/m.png')}}" alt="user" class="img-fluid rounded-circle" loading="lazy">
                                </div>
                                <div class="avtar-name">
                                    <h5 class="iq-lead text-capitalize m-0">Mary Campeau</h5>
                                    <span class="iq-post-meta text-secondary text-capitalize">Patient</span>
                                </div>
                            </div>
                        </div>                  
                    </li>
                    <li class="swiper-slide">
                        <div class="iq-testimonial testimonial-standard">
                            <div class="iq-testimonial-content">
                                <p class="text-body fw-normal fst-italic">
                                    “I've been seeing Sonia for a few years now, and she is absolutely amazing. Both my husband and I trust her for all of our RMT needs. She is not only professional but also genuinely kind, patient, and always willing to answer any questions we have. Sonia creates such a calm and relaxing atmosphere during every session, and we both look forward to our appointments with her.”
                                </p>
                            </div>
                            <div class="iq-testimonial-member mt-5 d-flex gap-3">
                                <div class="iq-testimonial-avtar">
                                    <img src="{{asset('frontend_assets/images/testimonial/a.png')}}" alt="user" class="img-fluid rounded-circle" loading="lazy">
                                </div>
                                <div class="avtar-name">
                                    <h5 class="iq-lead text-capitalize m-0">Avneet Gill</h5>
                                    <span class="iq-post-meta text-secondary text-capitalize">Patient</span>
                                </div>
                            </div>
                        </div>                  
                    </li>
                    <li class="swiper-slide">
                        <div class="iq-testimonial testimonial-standard">
                            <div class="iq-testimonial-content">
                                <p class="text-body fw-normal fst-italic">
                                    “I've had the pleasure of experiencing Sonia's services at Divine Touch Therapy, and she is truly exceptional. Her massages are incredibly soothing and leave me feeling completely relaxed. Her facials are amazing, leaving my skin glowing and refreshed every time.”
                                </p>
                            </div>
                            <div class="iq-testimonial-member mt-5 d-flex gap-3">
                                <div class="iq-testimonial-avtar">
                                    <img src="{{asset('frontend_assets/images/testimonial/n.png')}}" alt="user" class="img-fluid rounded-circle" loading="lazy">
                                </div>
                                <div class="avtar-name">
                                    <h5 class="iq-lead text-capitalize m-0">Nisreen M</h5>
                                    <span class="iq-post-meta text-secondary text-capitalize">Patient</span>
                                </div>
                            </div>
                        </div>                  
                    </li>
                </ul>
                <div class="arrow-joint">
                    <div class="swiper-button swiper-button-next"></div>
                    <div class="swiper-button swiper-button-prev"></div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
    
<div class="section-padding pt-0">
    <div class="container">
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d5763.102858452681!2d-79.829381!3d43.761411!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x882b172caa330503%3A0x53ebbf7f84bbe6e6!2s70%20Twistleton%20St%2C%20Caledon%2C%20ON%20L7C%202H1%2C%20Canada!5e0!3m2!1sen!2sus!4v1744291708299!5m2!1sen!2sus" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</div>

@endsection