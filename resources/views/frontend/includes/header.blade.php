<div class="position-relative">
    {{--Nav Start--}}
    @if(Route::currentRouteName() !== 'register')
        <header class="skin-specialist">
            <nav class="nav navbar navbar-expand-xl navbar-light iq-navbar header-hover-menu py-xl-0">
            <div class="container-fluid navbar-inner">
                <div class="d-flex align-items-center justify-content-between w-100 landing-header">
                    <div class="d-flex gap-3 gap-xl-0 align-items-center">
                        <div>
                        <button data-trigger="navbar_main"
                            class="d-xl-none btn btn-primary rounded-pill p-1 pt-0 toggle-rounded-btn" type="button">
                            <svg width="20px" class="icon-20" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z"></path>
                            </svg>
                        </button>
                        </div>
                    <a href="{{route('home')}}" class="navbar-brand m-0">
                        <span class="logo-normal">
                            <img src="{{asset('frontend_assets/images/logo/divine-logo.png')}}" alt="Divine Logo" class="img-fluid" loading="lazy">
                        </span>
                    </a>
                        <!-- Horizontal Menu Start -->
                        <nav id="navbar_main" class="mobile-offcanvas nav navbar navbar-expand-xl hover-nav horizontal-nav mega-menu-content py-xl-0">
                        <div class="container-fluid p-lg-0">
                            <div class="offcanvas-header px-0">
                                <a href="{{route('home')}}" class="navbar-brand m-0">
                                    <span class="logo-normal">
                                        <img src="{{asset('frontend_assets/images/logo/divine-logo.png')}}" alt="Divine Logo" class="img-fluid" loading="lazy">
                                    </span>
                                </a>
                                <button class="btn-close float-end px-3"></button>
                            </div>
                            <ul class="navbar-nav iq-nav-menu list-unstyled" id="header-menu">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('massage_therapy') }}">
                                        <span class="item-name">Massage Therapy</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="collapse" href="#allPages" role="button" aria-expanded="false" aria-controls="allPages">
                                        <span class="item-name">Aesthetics Services</span>
                                        <span class="menu-icon">
                                        <svg width="8" height="9" viewBox="0 0 8 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4 0.5C4.27614 0.5 4.5 0.723858 4.5 1V4H7.5C7.77614 4 8 4.22386 8 4.5C8 4.77614 7.77614 5 7.5 5H4.5V8C4.5 8.27614 4.27614 8.5 4 8.5C3.72386 8.5 3.5 8.27614 3.5 8V5H0.5C0.223858 5 0 4.77614 0 4.5C0 4.22386 0.223858 4 0.5 4H3.5V1C3.5 0.723858 3.72386 0.5 4 0.5Z" fill="currentColor"/>
                                        </svg>
                                        </span>
                                    </a>
                                    <ul class="sub-nav collapse list-unstyled">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('laser_hair_removal') }}">
                                                <span class="item-name">Laser Hair Removal</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link " href="{{ route('skincare') }}">
                                            Skin Care
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link " href="{{ route('twist_microneedling') }}">
                                            Twist Microneedling
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                {{-- <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="collapse" href="#specializationPages" role="button" aria-expanded="false" aria-controls="specializationPages">
                                        <span class="item-name">Products</span>
                                        <span class="menu-icon">
                                        <svg width="8" height="9" viewBox="0 0 8 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4 0.5C4.27614 0.5 4.5 0.723858 4.5 1V4H7.5C7.77614 4 8 4.22386 8 4.5C8 4.77614 7.77614 5 7.5 5H4.5V8C4.5 8.27614 4.27614 8.5 4 8.5C3.72386 8.5 3.5 8.27614 3.5 8V5H0.5C0.223858 5 0 4.77614 0 4.5C0 4.22386 0.223858 4 0.5 4H3.5V1C3.5 0.723858 3.72386 0.5 4 0.5Z" fill="currentColor"/>
                                        </svg>
                                        </span>
                                    </a>
                                    <ul class="sub-nav collapse  list-unstyled" id="specializationPages">
                                        <li class="nav-item">
                                            <a class="nav-link " href="./oncologist.html">
                                            Product Catalogue
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link " href="./neurologist.html">
                                            e-Gift Card
                                            </a>
                                        </li>
                                    </ul>
                                </li> --}}
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('price') }}">
                                        <span class="item-name">Prices</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="https://squareup.com/gift/TA5B90NCVKRDW/order" target="_blank">
                                        <span class="item-name">e-Gift Card</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="collapse" href="#shopPage" role="button" aria-expanded="false" aria-controls="shopPage">
                                        <span class="item-name">More</span>
                                        <span class="menu-icon">
                                        <svg width="8" height="9" viewBox="0 0 8 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4 0.5C4.27614 0.5 4.5 0.723858 4.5 1V4H7.5C7.77614 4 8 4.22386 8 4.5C8 4.77614 7.77614 5 7.5 5H4.5V8C4.5 8.27614 4.27614 8.5 4 8.5C3.72386 8.5 3.5 8.27614 3.5 8V5H0.5C0.223858 5 0 4.77614 0 4.5C0 4.22386 0.223858 4 0.5 4H3.5V1C3.5 0.723858 3.72386 0.5 4 0.5Z" fill="currentColor"/>
                                        </svg>
                                        </span>
                                    </a>
                                    <ul class="sub-nav collapse list-unstyled" id="shopPage">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('about') }}">
                                            About
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('gallery') }}">
                                            Gallery
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('contact') }}">
                                            Contact
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                
                            </ul>
                        </div> <!-- container-fluid.// -->
                        </nav>
                        <!-- Sidebar Menu End -->            </div>
                    <div class="right-panel">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-btn">
                        <span class="navbar-toggler-icon"></span>
                        </span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav align-items-center ms-auto mb-2 mb-xl-0">
                            <li>
                                <div class="iq-btn-container">
                                    <a class="iq-button text-capitalize" href="{{ route('book_appointment') }}">
                                    <span class="iq-btn-text-holder position-relative">Appointment</span>
                                    <span class="iq-btn-icon-holder">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 8 8" fill="none">
                                            <path d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z" fill="currentColor"></path>
                                        </svg>
                                    </span>
                                    </a>
                                </div>
                            </li>
                               
                            <li class="nav-item dropdown" id="itemdropdown1">
                                {{-- <a class="nav-link d-flex align-items-center" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="btn-icon btn-sm rounded-pill">
                                    <span class="btn-inner">
                                        <svg class="user-icons" xmlns="http://www.w3.org/2000/svg" width="20"
                                            height="21" viewBox="0 0 20 21" fill="none">
                                            <mask style="mask-type:alpha" maskUnits="userSpaceOnUse" x="3" y="12"
                                                width="14" height="7">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M3.33203 12.3041H16.5319V18.4491H3.33203V12.3041Z"
                                                fill="white"></path>
                                            </mask>
                                            <g>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M9.93286 13.5541C6.38203 13.5541 4.58203 14.1641 4.58203 15.3682C4.58203 16.5832 6.38203 17.1991 9.93286 17.1991C13.4829 17.1991 15.282 16.5891 15.282 15.3849C15.282 14.1699 13.4829 13.5541 9.93286 13.5541ZM9.93286 18.4491C8.30036 18.4491 3.33203 18.4491 3.33203 15.3682C3.33203 12.6216 7.09953 12.3041 9.93286 12.3041C11.5654 12.3041 16.532 12.3041 16.532 15.3849C16.532 18.1316 12.7654 18.4491 9.93286 18.4491Z"
                                                fill="currentColor"></path>
                                            </g>
                                            <mask style="mask-type:alpha" maskUnits="userSpaceOnUse" x="5" y="1"
                                                width="10" height="10">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M5.50781 1.89075H14.3578V10.7396H5.50781V1.89075Z"
                                                fill="white"></path>
                                            </mask>
                                            <g>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M9.93367 3.08038C8.14951 3.08038 6.69784 4.53121 6.69784 6.31538C6.69201 8.09371 8.13284 9.54371 9.9095 9.55038L9.93367 10.1454V9.55038C11.717 9.55038 13.1678 8.09871 13.1678 6.31538C13.1678 4.53121 11.717 3.08038 9.93367 3.08038ZM9.93367 10.7395H9.90701C7.47201 10.732 5.49951 8.74622 5.50784 6.31288C5.50784 3.87538 7.49284 1.89038 9.93367 1.89038C12.3737 1.89038 14.3578 3.87538 14.3578 6.31538C14.3578 8.75538 12.3737 10.7395 9.93367 10.7395Z"
                                                fill="currentColor"></path>
                                            </g>
                                        </svg>
                                    </span>
                                    </div>
                                </a> --}}
                                <ul class="dropdown-menu dropdown-menu-end dropdown-user" aria-labelledby="navbarDropdown">
                                    @auth
                                    <li><a class="dropdown-item border-bottom"
                                    href="javascript:void(0);"><storng>Welcome, {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</storng></a></li>
                                    <li><a class="dropdown-item" href="{{ route('my_account') }}">Dashboard</a></li>
                                    <li><a class="dropdown-item" href="{{ route('logout') }}">Sign Out</a>
                                    </li>
                                    @endauth
                                    @guest
                                    {{-- <li><a class="dropdown-item border-bottom"
                                    href="{{ route('login') }}">Sign in</a></li>
                                    <li><a class="dropdown-item" href="{{ route('register') }}">Sign up</a>
                                    </li> --}}
                                    @endguest
                                </ul>
                            </li>
                            <li class="ms-3">
                                <div class="cursor-pointer" data-bs-toggle="offcanvas"
                                    data-bs-target="#right-panel-toggle" aria-controls="right-panel-toggle">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="22" viewBox="0 0 28 22"
                                    fill="none">
                                    <path d="M0 0H24V2H0V0Z" fill="#171C26" />
                                    <path d="M4 10H28V12H4V10Z" fill="#171C26" />
                                    <path d="M0 20H24V22H0V20Z" fill="#171C26" />
                                    </svg>
                                </div>
                            </li>
                        </ul>
                        </div>
                    </div>
                </div>
            </div>
            </nav>
        </header>
        <div class="offcanvas offcanvas-end " tabindex="-1" id="right-panel-toggle">
            <div class="offcanvas-header border-bottom px-5 mb-5 py-4">
            <a href="{{ route('home') }}" class="navbar-brand m-0">
                <span class="logo-normal">
                    <img src="{{asset('frontend_assets/images/logo/divine-logo.png')}}" alt="Divine Logo" class="img-fluid" loading="lazy">
                </span>
            </a>
            <button type="button" class="btn-close text-reset"
                data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body px-5 d-flex flex-column justify-content-between">
            <div class="mb-5 pb-5 border-bottom">
                <h4 class="mb-3">Contact Us:</h4>
                <p>70 Twistleton St, Caledon, ON L7C 4B5, Canada.</p>
                <p>info@divinetouchtherapy.com</p>
                <p>Phone : (+1) 905-996-2700</p>
            </div>
            <div class="mb-5">
                <h4 class="mb-3">Follow Us:</h4>
                <ul class="iq-social list-inline d-flex align-items-center gap-3 m-0">
                    <li>
                        <a href="https://www.facebook.com/DivineTouchTherapyCaledon/">
                        <svg class="base-circle animated" width="38" height="38"
                            viewBox="0 0 50 50">
                            <circle class="c1" cx="25" cy="25" r="23" stroke="#6e7990"
                                stroke-width="1"
                                fill="none"></circle>
                        </svg>
                        <i class="fab fa-facebook-f"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://x.com/DivineTouchThe1">
                        <svg class="base-circle animated" width="38" height="38"
                            viewBox="0 0 50 50">
                            <circle class="c1" cx="25" cy="25" r="23" stroke="#6e7990"
                                stroke-width="1"
                                fill="none"></circle>
                        </svg>
                        <i class="fab fa-twitter"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/divinetouch_therapy/">
                        <svg class="base-circle animated" width="38" height="38"
                            viewBox="0 0 50 50">
                            <circle class="c1" cx="25" cy="25" r="23" stroke="#6e7990"
                                stroke-width="1"
                                fill="none"></circle>
                        </svg>
                        <i class="fab fa-instagram"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.linkedin.com/in/divinetouch-therapy-10a48a177/">
                        <svg class="base-circle animated" width="38" height="38"
                            viewBox="0 0 50 50">
                            <circle class="c1" cx="25" cy="25" r="23" stroke="#6e7990"
                                stroke-width="1"
                                fill="none"></circle>
                        </svg>
                        <i class="fab fa-linkedin"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <p class="pt-3 mb-0 border-top">&copy;
                <script>document.write(new Date().getFullYear())</script> Divine Touch Therapy, All
                Rights Reserved.</p>
            </div>
        </div>
    @endif
    

    {{-- bread-crumb --}}
    @if(Route::currentRouteName() === 'book_appointment')
        {{-- <div class="iq-breadcrumb bg-primary-subtle">
            <div class="container">
            <nav aria-label="breadcrumb" class="text-center">
                <h2 class="title">Appointment</h2>
                <ol class="breadcrumb justify-content-center mt-2 mb-0">
                <li class="breadcrumb-item">
                    <a href="index.html">Home</a>
                </li>
                <li class="breadcrumb-item active">Appointment</li>
                </ol>
            </nav>
            </div>
        </div> --}}
    @endif
    
    @switch(Route::currentRouteName())
        @case('book_appointment')
            @php 
            $breadcrum_title = 'Appointment'; 
            $breadcrum_li_html = 'Appointment';
            @endphp
            @break

        @case('my_account')
            @php
            $breadcrum_title = 'My Account'; 
            $breadcrum_li_html = 'Dashboard';
            @endphp
            @break

        @case('medical_form')
            @if(isset($booking_id))
                @php
                $breadcrum_title = 'Medical Form';
                $breadcrum_li_html = 'Medical Form';
                @endphp
            @else
                @php
                $breadcrum_title
                @endphp
            @endif
            @break

        @case('contact')
            @php
            $breadcrum_title = 'Contact Us';
            $breadcrum_li_html = 'Contact Us';
            @endphp
            @break;
        
        @case('about')
            @php
            $breadcrum_title = 'About';
            $breadcrum_li_html = 'About';
            @endphp
            @break;

        @case('laser_hair_removal')
            @php
            $breadcrum_title = 'Laser Hair Removal';
            $breadcrum_li_html = 'Laser Hair Removal';
            @endphp
            @break;
        
        @case('skincare')
            @php
            $breadcrum_title = 'Skin Care';
            $breadcrum_li_html = 'Skin Care';
            @endphp
            @break;
        
        @case('twist_microneedling')
            @php
            $breadcrum_title = 'Twist Microneedling';
            $breadcrum_li_html = 'Twist Microneedling';
            @endphp
            @break;
        
        @case('massage_therapy')
            @php
            $breadcrum_title = 'Massage Therapy';
            $breadcrum_li_html = 'Massage Therapy';
            @endphp
            @break;
        
        @case('gallery')
            @php
            $breadcrum_title = 'Gallery';
            $breadcrum_li_html = 'Gallery';
            @endphp
            @break;
        
        @case('price')
            @php
            $breadcrum_title = 'Prices';
            $breadcrum_li_html = 'Prices';
            @endphp
            @break;

    @endswitch
    @if(!empty($breadcrum_title))
    <div class="iq-breadcrumb bg-primary-subtle">
        <div class="container">
        <nav aria-label="breadcrumb" class="text-center">
            <h2 class="title">{{$breadcrum_title}}</h2>
            <ol class="breadcrumb justify-content-center mt-2 mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">{{$breadcrum_title}}</li>
            </ol>
        </nav>
        </div>
    </div>
    @endif
    {{--bread-crumb--}}
</div>