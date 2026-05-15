@extends('frontend.layouts.app')

@section('content')
<div class="sign-in-page position-relative">
    <div class="container">
        <div
            class="row justify-content-center align-items-center height-self-center h-100">
            <div class="col-lg-5 col-md-12 align-self-center">
            <div class="sign-user_card position-relative bg-white mx-auto">
                <div class="logo-img text-center mb-5">
                    <a href="{{route('home')}}" class="navbar-brand m-0">
                        <span class="logo-normal">
                            <img src="{{asset('frontend_assets/images/logo/divine-logo.png')}}" alt="logo" class="img-fluid" loading="lazy">
                        </span>
                    </a>
                </div>
                
                @if(Session::has('error'))
                <div class="alert alert-danger"> {{ Session::get('error') }} </div>
                @endif
                <form action="{{ route('process_register') }}" method="post">
                    @csrf
                    <div class="custom-form-field">
                        <input
                        type="text"
                        name="first_name"
                        id="first_name"
                        placeholder="Your First Name *"
                        class="form-control mb-5"
                        required
                        pattern="^[a-zA-Z\s]+$"
                        title="Please enter a valid first name (letters and spaces only)"
                        value="{{ old('first_name') }}">
                        @error('first_name')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="custom-form-field">
                        <input
                        type="text"
                        name="last_name"
                        id="last_name"
                        placeholder="Your Last Name *"
                        class="form-control mb-5"
                        required
                        pattern="^[a-zA-Z\s]+$"
                        title="Please enter a valid last name (letters and spaces only)"
                        value="{{ old('last_name') }}">
                        @error('last_name')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="custom-form-field">
                        <input
                        type="text"
                        name="mobile"
                        placeholder="Your Mobile *"
                        class="form-control mb-5"
                        required
                        pattern="^[1-9][0-9]{9}$"
                        maxlength="10"
                        title="Please enter a valid mobile number (10 digits, not starting with 0)"
                        value="{{ old('mobile') }}">
                        @error('mobile')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="custom-form-field">
                        <input
                        type="email"
                        name="email"
                        id="email"
                        placeholder="Your email id *"
                        class="form-control mb-5"
                        required                        
                        title="Please enter a valid Email address"
                        value="{{ old('email') }}">
                        @error('email')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="custom-form-field">
                        <input
                        type="password"
                        name="password"
                        id="password"
                        placeholder="Your password *"
                        class="form-control mb-5"
                        required>
                        @error('password')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="custom-form-field">
                        <input
                        type="password"
                        name="password_confirmation"
                        placeholder="Confirm Your password *"
                        class="form-control mb-5"
                        required>
                        @error('password_confirmation')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <p class="mb-5"> Your personal data will be used to support
                        your experience throughout this
                        website, to manage access to your account, and for other
                        purposes described in our <a
                        href="./privacy-policy.html"> privacy policy</a>.
                    </p>
                    <button type="submit"
                        class="iq-button text-capitalize border-0">
                        <span
                        class="iq-btn-text-holder position-relative">register</span>
                        <span class="iq-btn-icon-holder">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10"
                            height="10" viewBox="0 0 8 8" fill="none">
                            <path
                                d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z"
                                fill="currentColor"></path>
                        </svg>
                        </span>
                    </button>
                </form>
                <div class="d-flex align-items-center mt-3">
                    <p class="my-0 text-capitalize">Already have an account?</p>
                    <h5 class="sign_up_btn mb-0 ms-2">
                        <div class="iq-btn-container">
                        <a class="iq-button iq-btn-link text-capitalize" href="{{ route('login') }}">
                            sign in
                            <span class="btn-link-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 8 8" fill="none">
                                    <path d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z" fill="currentColor"></path>
                                </svg>
                            </span>
                        </a>
                        </div>                  
                    </h5>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection