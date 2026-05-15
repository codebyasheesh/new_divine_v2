@extends('frontend.layouts.app')

@section('content')
<div class="">
   <div class="container position-relative">
    {{-- <div class="text-center position-relative">
         <div class="scrolling-text position-absolute">
            <div class="iq-title text-uppercase">About Us</div>
         </div>         
         <div class="iq-title-box">
            <span class="iq-subtitle text-uppercase">Doctors</span>
            <h2 class="iq-title iq-heading-title">
               <span class="right-text text-capitalize fw-500">About </span>
               <span class="left-text text-capitalize fw-light">Us</span>
            </h2>
            <p class="iq-title-desc text-body mt-3 mb-0">
               
            </p>
         </div>      
        </div> --}}
      <div class="row pt-5">
         <div class="col-lg-12 col-md-12 text-center">
            <div class="iq-img-area d-block m-auto">
                <img src="{{asset('frontend_assets/images/pages/about-banner.jpg')}}" alt="icon" class="img-fluid" loading="lazy">
            </div> 
            <p class="pt-5 px-5">While Divine Touch Therapy just came into operation in November of 2018, the concept of it came into existence long before that. As there is a shortage of Registered Massage Therapists in the region, the goal of its founder Sonia Chanana was to launch a clinic that could provide services to a currently under-serviced Southfields community of Caledon in a personalized and comfortable setting of a home.</p>
            <p class="pt-5 px-5">Divine Touch is a fully licenced home-based Clinic mainly focused on delivering holistic and therapeutic services such as Massage Therapy. An appealing feature of Divine Touch is the additional aesthetic services it offers alongside the main practice of Massage therapy - all in the comfort of a home like setting. Sonia is not only a Registered Massage Therapist but also an experienced aesthetician and a certified skin care specialist.</p>
            <p class="pt-5 px-5">As we operate under the business models of a home-based, as well as, a by-appointment-only one on one service provider, we are able to eliminate all over-head costs associated with a traditional store-front type business and keep our prices low - all whilst providing you with the highest standard of service using the specialized award winning equipment from industry leading manufacturers.</p>
            <p class="pt-5 px-5">We look forward to welcoming and serving you in our new clinic and building a relationship that is nothing short of Divine!</p>
        </div>
        {{-- <div class="col-lg-4 col-md-6 mt-5 mt-md-0 text-center">
            <div class="iq-fancy-box position-relative bg-white">
               <div class="iq-img-area bg-primary d-block m-auto">
                  <img src="./assets/images//general/treatment.svg" alt="icon" class="img-fluid" loading="lazy">
               </div>
               <div class="iq-fancy-box-content mt-5">
                  <h4 class="mb-2">Trusted Treatment</h4>
                  <p class="text-body m-0">KiviCare has many types of treatment to relieve symptoms for all types illness.</p>
                  <div class="fencybox-button mt-3 mt-md-5">
                     <div class="iq-btn-container">
                        <a class="iq-button iq-btn-link text-capitalize" href="./service1.html">
                           read more
                           <span class="btn-link-icon">
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
        <div class="col-lg-4 col-md-12 mt-5 mt-lg-0 text-center">
            <div class="iq-fancy-box position-relative bg-white">
               <div class="iq-img-area bg-primary d-block m-auto">
                  <img src="./assets/images//general/service.svg" alt="icon" class="img-fluid" loading="lazy">
               </div>
               <div class="iq-fancy-box-content mt-5">
                  <h4 class="mb-2">24/7 Services</h4>
                  <p class="text-body m-0">KiviCare is at your service 24×7 aiming to provide the best services of medical</p>
                  <div class="fencybox-button mt-3 mt-md-5">
                     <div class="iq-btn-container">
                        <a class="iq-button iq-btn-link text-capitalize" href="./service1.html">
                           read more
                           <span class="btn-link-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 8 8" fill="none">
                                 <path d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z" fill="currentColor"></path>
                              </svg>
                           </span>
                        </a>
                     </div>
                  </div>
               </div>
            </div>         
        </div> --}}
      </div>
   </div>
</div>
<div class="bg-primary-subtle section-padding">
   <div class="container position-relative">
      <div class="row">
         <div class="col-md-6 pe-md-5">
            <div class="scrolling-text position-absolute">
               <div class="iq-title text-uppercase">About The Founder</div>
            </div>            <div class="iq-title-box">
               <span class="iq-subtitle text-uppercase">About The</span>
               <h2 class="iq-title iq-heading-title">
                  <span class="right-text text-capitalize fw-500">Founder  </span>
                  {{-- <span class="left-text text-capitalize fw-light">Commitments</span> --}}
               </h2>
               <p class="iq-title-desc text-body mt-3 mb-0">
                  Divine Touch's founder and principle operator, <strong>Simple Sonia Chanana</strong>, is a Registered Massage Therapist. She is an active member in good standing with the regulatory body of the College of Massage Therapists of Ontario.
               </p>
               <p class="iq-title-desc text-body mt-3 mb-0">
                Sonia has also graduated in Advanced Aesthetics and holds certificates in Aromatherapy, Reflexology, and, Laser hair removal technology. She has over 15 years of practice experience here in Canada, with many more years of experience practicing in Germany prior to that.
               </p>
               <p class="iq-title-desc text-body mt-3 mb-0">
                Sonia is a member of the Registered Massage Therapists Association of Ontario.
               </p>
               <div class="text-center pt-4">
                <img src="{{ asset('frontend_assets/images/pages/rmt-en-rgb-box-tag.jpg') }}" class="img-fluid w-50" >
               </div>
            </div>
            
            <div class="d-flex gap-4 mt-5 flex-column flex-lg-row mb-5 mb-md-0">
               <div>
                  <h4 class="fw-normal">Sonia Chanana</h4>
                  <p class="text-primary text-uppercase fw-bold">CEO &amp; Founder</p>
               </div>
               <div class="sign-image">
                  <img src="./assets/images/general/signature.png" alt="" class="img-fluid mb-5">
               </div>
            </div>
         </div>
         <div class="col-md-6">
            <img src="{{ asset('frontend_assets/images/pages/about-the-founder.jpg') }}" alt="banner" class="img-fluid">
         </div>
      </div>
   </div>
</div>


<div class="team-section section-padding">
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
      <div class="row pt-5">
         <div class="col-lg-3 col-md-6 text-center">
            <div class="iq-fancy-box position-relative bg-white">
               <div class="iq-img-area bg-primary d-block m-auto">
                  <img src="{{ asset('frontend_assets/images/pages/hygiene-icon.svg') }}" alt="icon" class="img-fluid" loading="lazy">
               </div>
               <div class="iq-fancy-box-content mt-5">
                  <h4 class="mb-2">Hygiene</h4>
                  <p class="text-body m-0">We place high importance on cleanliness and hygiene, and ensure peace of mind for you.</p>
                  {{-- <div class="fencybox-button mt-3 mt-md-5">
                     <div class="iq-btn-container">
                        <a class="iq-button iq-btn-link text-capitalize" href="./service1.html">
                           read more
                           <span class="btn-link-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 8 8" fill="none">
                                 <path d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z" fill="currentColor"></path>
                              </svg>
                           </span>
                        </a>
                     </div>
                  </div> --}}
               </div>
            </div>         
        </div>
        <div class="col-lg-3 col-md-6 mt-5 mt-md-0 text-center">
            <div class="iq-fancy-box position-relative bg-white">
               <div class="iq-img-area bg-primary d-block m-auto">
                  <img src="{{ asset('frontend_assets/images/pages/privacy-icon.svg') }}" alt="icon" class="img-fluid" loading="lazy">
               </div>
               <div class="iq-fancy-box-content mt-5">
                  <h4 class="mb-2">Privacy</h4>
                  <p class="text-body m-0">We understand the value of your privacy and maintain full confidentiality of all treatment rendered.</p>
                  {{-- <div class="fencybox-button mt-3 mt-md-5">
                     <div class="iq-btn-container">
                        <a class="iq-button iq-btn-link text-capitalize" href="./service1.html">
                           read more
                           <span class="btn-link-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 8 8" fill="none">
                                 <path d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z" fill="currentColor"></path>
                              </svg>
                           </span>
                        </a>
                     </div>
                  </div> --}}
               </div>
            </div>         
        </div>
        <div class="col-lg-3 col-md-12 mt-5 mt-lg-0 text-center">
            <div class="iq-fancy-box position-relative bg-white">
               <div class="iq-img-area bg-primary d-block m-auto">
                  <img src="{{ asset('frontend_assets/images/pages/convenience.svg') }}" alt="icon" class="img-fluid" loading="lazy">
               </div>
               <div class="iq-fancy-box-content mt-5">
                  <h4 class="mb-2">Convenience</h4>
                  <p class="text-body m-0">We offer multiple payment options as well as Direct Insurance Billing for RMT services for clients with coverage</p>
                  {{-- <div class="fencybox-button mt-3 mt-md-5">
                     <div class="iq-btn-container">
                        <a class="iq-button iq-btn-link text-capitalize" href="./service1.html">
                           read more
                           <span class="btn-link-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 8 8" fill="none">
                                 <path d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z" fill="currentColor"></path>
                              </svg>
                           </span>
                        </a>
                     </div>
                  </div> --}}
               </div>
            </div>         
        </div>
        <div class="col-lg-3 col-md-12 mt-5 mt-lg-0 text-center">
            <div class="iq-fancy-box position-relative bg-white">
               <div class="iq-img-area bg-primary d-block m-auto">
                  <img src="{{ asset('frontend_assets/images/pages/consistency-icon.svg') }}" alt="icon" class="img-fluid" loading="lazy">
               </div>
               <div class="iq-fancy-box-content mt-5">
                  <h4 class="mb-2">Consistency</h4>
                  <p class="text-body m-0">Whether you are our first-time guest or a loyal client, you'll always receive same high standard of service.</p>
                  {{-- <div class="fencybox-button mt-3 mt-md-5">
                     <div class="iq-btn-container">
                        <a class="iq-button iq-btn-link text-capitalize" href="./service1.html">
                           read more
                           <span class="btn-link-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 8 8" fill="none">
                                 <path d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z" fill="currentColor"></path>
                              </svg>
                           </span>
                        </a>
                     </div>
                  </div> --}}
               </div>
            </div>         
        </div>
      </div>
   </div>
</div>
@endsection