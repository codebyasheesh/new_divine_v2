@extends('frontend.layouts.app')

@section('content')
<div class="bg-primary-subtle vh-100 position-relative">
   <div class="container text-center">
      <div class="row flex-column justify-content-center align-items-center vh-50">
         <div style="z-index:1">
            <img src="{{asset('frontend_assets/images/pages/404.png')}}" alt="404" class="img-fluid mb-5" style="width: 40%;"> 
            <p class="mt-5 text-center text-body">The Page You Requested Could Not Be Found Please Go Back To Homepage</p>
            <div class="button-primary">
               <div class="iq-btn-container">
                  <a class="iq-button text-capitalize" href="{{route('home')}}">
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
      </div>
   </div>
   <div>
      <img src="{{asset('frontend_assets/images/pages/error-bg-5.png')}}" alt="img" class="position-absolute top-0 start-0 rtl-image-flip">
      <img src="{{asset('frontend_assets/images/pages/error-bg-2.png')}}" alt="img" class="position-absolute error-bg-one rtl-image-flip">
      <img src="{{asset('frontend_assets/images/pages/error-bg-3.png')}}" alt="img" class="position-absolute error-bg-two rtl-image-flip">
      <img src="{{asset('frontend_assets/images/pages/error-bg-6.png')}}" alt="img" class="position-absolute bottom-0 end-0 rtl-image-flip">
   </div>
</div>
@endsection