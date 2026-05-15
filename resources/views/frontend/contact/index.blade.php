@extends('frontend.layouts.app')

@section('content')
<div class="text-center">
   <div class="container section-padding border-bottom">
      <div class="row">
         <div class="col-md-4">
            <i class="fas fa-map-marker-alt text-secondary font-size-60 mb-5"></i>
            <div class="iq-title-box mb-0">
               <span class="iq-subtitle text-uppercase">By Appointment Only</span>
               <h5 class="iq-title iq-heading-title mt-3">
                  <span class="right-text text-capitalize ">70 Twistleton St, Caledon, ON L7C 4B5, Canada.</span>
               </h5>
            </div>
         </div>
         <div class="col-md-4 mt-md-0 mt-5">
            <i class="far fa-envelope text-secondary font-size-60 mb-5"></i>
            <div class="iq-title-box mb-0">
               <span class="iq-subtitle text-uppercase">Email Anytime</span>
               <h5 class="iq-title iq-heading-title mt-3">
                  <span class="right-text">info@divinetouchtherapy.com</span>
               </h5>
            </div>
         </div>
         <div class="col-md-4 mt-md-0 mt-5">
            <i class="fas fa-phone  text-secondary font-size-60 mb-5"></i>
            <div class="iq-title-box mb-0">
               <span class="iq-subtitle text-uppercase">10 AM to 7 PM Mon-Fri</span>
               <h5 class="iq-title iq-heading-title mt-3">
                  <span class="right-text text-capitalize ">+1 (905) 996 2700</span>
               </h5>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="section-padding">
   <div class="container text-center">
      <div class="iq-title-box">
         {{-- <span class="iq-subtitle text-uppercase">JUST A CALL AWAY</span> --}}
         <h2 class="iq-title iq-heading-title">
            <span class="right-text text-capitalize fw-500">We'd love to</span>
            <span class="left-text text-capitalize fw-light">hear from you!</span>
         </h2>
         <p class="iq-title-desc text-body mt-3 mb-0">
            We are here and always ready to help you. Let us know how we serve
            you and we'll get back within no time.
         </p>
      </div>      <div class="row">
         <div class="col-lg-2 d-lg-block d-none"></div>
         <div class="col-lg-8">
            <form id="frmContact" method="post">
               <div class="row gy-5">
                  <div class="col-lg-6">
                     <div class="custom-form-field">
                        <input type="text" name="first_name" placeholder="First Name" class="form-control"
                           required>
                           @error('first_name')
                           <div class="text-start text-danger error-f_nm">{{ $message }}</div>
                           @enderror
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <div class="custom-form-field">
                        <input type="text" name="last_name" placeholder="Last Name" class="form-control"
                           required>
                        @error('last_name')
                        <div class="text-start text-danger error-l_nm">{{ $message }}</div>
                        @enderror
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <div class="custom-form-field">
                        <input type="text" name="mobile" maxlength="12" placeholder="Mobile Number" class="form-control" required>
                        @error('mobile')
                        <div class="text-start text-danger error-mob"> {{ $message }} </div>
                        @enderror
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <div class="custom-form-field">
                        <input type="email" name="email" id="contact_email" placeholder="Your Email" class="form-control"
                           required>
                           @error('email')
                           <div class="text-start text-danger error-email">{{ $message }}</div>
                           @enderror
                     </div>
                  </div>
                  <div class="col-lg-12">
                     <div class="custom-form-field">
                        <textarea name="message" placeholder="Your Message" class="form-control"
                           required></textarea>
                           @error('message')
                           <div class="text-start text-danger error-msg">{{ $message }}</div>
                           @enderror
                     </div>
                  </div>
                  <div class="col-lg-12 text-start">
                     <div class="iq-btn-container">
                        <button class="iq-button text-capitalize border-0" id="btnContact" type="submit">
                           <span class="iq-btn-text-holder position-relative">send message</span>
                           <span class="iq-btn-icon-holder">
                              <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 8 8" fill="none">
                                 <path d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z" fill="currentColor"></path>
                              </svg>
                           </span>
                        </button>
                        <button class="btn btn-primary d-none" id="loader" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                     </div>
                  </div>
               </div>
            </form>
         </div>
         <div class="col-lg-2 d-lg-block d-none"></div>
      </div>
   </div>
</div>
@endsection