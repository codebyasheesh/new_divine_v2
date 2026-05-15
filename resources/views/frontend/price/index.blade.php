@extends('frontend.layouts.app')

@section('content')
<div class="section-padding" style="padding-top: 1.375rem;">
   <div class="container">
      <div class="iq-pricetable-tabs">
         <div class="tab-content iq-tab-fade-up mt-5" id="icon-tab-content">
            <div class="tab-pane fade show active"  id="icon-month-1" role="tabpanel">
               <div class="row gy-4">
                    @forelse($services as $key => $service)
                    <div class="col-md-6 col-lg-2">&nbsp;</div>
                    <div class="col-md-6 col-lg-8">
                        <div class="iq-price-box iq-price-box-tab bg-white text-body box-shadow rounded-4">
                            <div class="iq-inner-box">
                                <div class="iq-price-header bg-primary-subtle text-body">
                                    <div class="text-center">
                                        <h4>{{ $service->service_name }}</h4>
                                        {{-- <p class="mb-0">discuss your issues &amp; create a plan with your talk therapist</p> --}}
                                    </div>
                                </div>
                                <div class="iq-price-body text-center">
                                    {{-- Child Services --}}
                                    @if($service->children->isNotEmpty())
                                    <ul class="list-inline border-top mt-5 pt-5">
                                        @foreach($service->children as $child)
                                        <li class="mb-3 text-capitalize">
                                            
                                            <div class="row">
                                                <div class="col-8 text-start"><i class="fa fa-check me-2" aria-hidden="true"></i> {{ $child->service_name }}</div>
                                                <div class="col-4 text-end">
                                                    @if($child->price > 0)
                                                    <strong>${{ number_format($child->price, 2) }}</strong>
                                                    @endif
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach
                                        @if($service->service_name == 'Massage Therapy')
                                        <li class="mb-3 text-capitalize">
                                            <div class="text-start"><small>*Taxes not included. 13% HST applies to above prices.</small></div>
                                        </li>
                                        @else
                                        <li class="mb-3 text-capitalize">
                                            <div class="text-start"><small>*Starting prices per session. Promotional and packaged pricing discounts are available. Contact us for details.</small></div>
                                        </li>
                                        @endif
                                    </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2">&nbsp;</div>
                    @empty
                    @endforelse
                    {{-- <div class="col-md-6 col-lg-4">
                        <div class="iq-price-box iq-price-box-tab bg-primary-subtle text-body box-shadow rounded-4">
                            <div class="iq-inner-box">
                            <div class="iq-price-header bg-dark text-white">
                                <div class="text-center">
                                    <h4 class="text-secondary">First Steps</h4>
                                    <p class="mb-0">Identify thought patterns, break negative thought loops &amp; initiate positive ones</p>
                                </div>
                            </div>
                            <div class="iq-price-body text-center">
                                <p class="mt-0">Price Per Session</p>
                                <h2 class="mb-0">$33.17</h2>
                                <ul class="list-inline border-top mt-5 pt-5">
                                    <li class="mb-3 text-capitalize">
                                        <i class="fa fa-check me-2" aria-hidden="true"></i>
                                        2 weeks of chat access
                                    </li>
                                    <li class="mb-3 text-capitalize">
                                        <i class="fa fa-check me-2" aria-hidden="true"></i>
                                        30 min Online Follow up
                                    </li>
                                    <li class="mb-3 text-capitalize">
                                        <i class="fa fa-check me-2" aria-hidden="true"></i>
                                        24hour Emergency
                                    </li>
                                    <li class="mb-3 text-capitalize">
                                        <i class="fa fa-check me-2" aria-hidden="true"></i>
                                        Evidence based theraphy
                                    </li>
                                </ul>
                            </div>
                            <div class="iq-price-footer text-center button-primary">
                                <div class="iq-btn-container">
                                    <a class="iq-button text-capitalize" href="./pricing-plan-two.html">
                                        <span class="iq-btn-text-holder position-relative">read more</span>
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
                    </div> --}}
                    {{-- <div class="col-lg-4 mt-5 mt-lg-0">
                        <div class="iq-price-box iq-price-box-tab bg-white text-body box-shadow rounded-4">
                            <div class="iq-inner-box">
                            <div class="iq-price-header bg-primary-subtle text-body">
                                <div class="text-center">
                                    <h4>Mind Your Mind</h4>
                                    <p class="mb-0">Initiate behavioural changes, learn how to manage your thoughts and emotions</p>
                                </div>
                            </div>
                            <div class="iq-price-body text-center">
                                <p class="mt-0">Price Per Session</p>
                                <h2 class="mb-0">$117.98</h2>
                                <ul class="list-inline border-top mt-5 pt-5">
                                    <li class="mb-3 text-capitalize">
                                        <i class="fa fa-check me-2" aria-hidden="true"></i>
                                        2 weeks of chat access
                                    </li>
                                    <li class="mb-3 text-capitalize">
                                        <i class="fa fa-check me-2" aria-hidden="true"></i>
                                        30 min Online Follow up
                                    </li>
                                    <li class="mb-3 text-capitalize">
                                        <i class="fa fa-check me-2" aria-hidden="true"></i>
                                        24hour Emergency
                                    </li>
                                    <li class="mb-3 text-capitalize">
                                        <i class="fa fa-check me-2" aria-hidden="true"></i>
                                        Evidence based theraphy
                                    </li>
                                </ul>
                            </div>
                            <div class="iq-price-footer text-center">
                                <div class="iq-btn-container">
                                    <a class="iq-button text-capitalize" href="./pricing-plan-two.html">
                                        <span class="iq-btn-text-holder position-relative">read more</span>
                                        <span class="iq-btn-icon-holder">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 8 8" fill="none">
                                            <path d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z" fill="currentColor"></path>
                                        </svg>
                                        </span>
                                    </a>
                                </div>      </div>
                            </div>
                        </div>
                    </div> --}}
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection