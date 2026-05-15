@extends('frontend.layouts.app')

@section('content')
<div class="section-padding service-details">
   <div class="container">
      <div class="row">
         <div class="col-lg-3 col-md-4">
            <div class="bg-primary-subtle p-4 mb-5 mb-lg-0 mb-md-0">
               <div class="product-menu">
                  <ul class="list-inline m-0 nav nav-tabs flex-column bg-transparent" role="tablist">
                     <li class="pb-3 border-bottom nav-item">
                        <button class="nav-link active p-0 bg-transparent" data-bs-toggle="tab"
                           data-bs-target="#dashboard" type="button" role="tab" aria-selected="true"><i
                           class="fas fa-tachometer-alt"></i><span class="ms-2">Dashboard</span></button>
                     </li>
                     <li class="py-3 border-bottom nav-item">
                        <button class="nav-link p-0 bg-transparent" onclick="getBookingByStatus('confirmed', '{{ $data['family_ids'] }}', 'confirm_booking_tbody');" data-bs-toggle="tab"
                           data-bs-target="#confirmed_bookings" type="button" role="tab" aria-selected="true"><i
                           class="fas fa-list"></i><span class="ms-2">Confirmed Bookings</span></button>
                     </li>
                     <li class="py-3 border-bottom nav-item">
                        <button class="nav-link p-0 bg-transparent" onclick="getBookingByStatus('completed', '{{ $data['family_ids'] }}', 'completed_b_tbody');" data-bs-toggle="tab"
                           data-bs-target="#completed_bookings" type="button" role="tab" aria-selected="true"><i
                           class="fas fa-list"></i><span class="ms-2">Completed Bookings</span></button>
                     </li>
                     <li class="py-3 border-bottom nav-item">
                        <button class="nav-link p-0 bg-transparent" onclick="getBookingByStatus('canceled', '{{ $data['family_ids'] }}', 'canceledbookingtbody');" data-bs-toggle="tab"
                           data-bs-target="#canceled_bookings" type="button" role="tab" aria-selected="true"><i
                           class="fas fa-list"></i><span class="ms-2">Canceled Bookings</span></button>
                     </li>
                     <li class="py-3 border-bottom nav-item">
                        <button class="nav-link p-0 bg-transparent" onclick="getBookingByStatus('pending', '{{ $data['family_ids'] }}', 'pbtbody');" data-bs-toggle="tab"
                           data-bs-target="#pending_bookings" type="button" role="tab" aria-selected="true"><i
                           class="fas fa-list"></i><span class="ms-2">Pending Bookings</span></button>
                     </li>
                     <li class="py-3 border-bottom nav-item">
                        <button class="nav-link p-0 bg-transparent" onclick="getBookingByStatus('waitlist', '{{ $data['family_ids'] }}', 'wait_b_tbody')" data-bs-toggle="tab"
                           data-bs-target="#waitlist_bookings" type="button" role="tab" aria-selected="true"><i
                           class="fas fa-list"></i><span class="ms-2">Decline Bookings</span></button>
                     </li>
                     {{-- <li class="py-3 border-bottom nav-item">
                        <button class="nav-link p-0 bg-transparent" data-bs-toggle="tab"
                           data-bs-target="#downloads" type="button" role="tab" aria-selected="true"><i
                           class="fas fa-download"></i><span class="ms-2">Downloads</span></button>
                     </li>
                     <li class="py-3 border-bottom nav-item">
                        <button class="nav-link p-0 bg-transparent" data-bs-toggle="tab"
                           data-bs-target="#address" type="button" role="tab" aria-selected="true"><i
                           class="fas fa-map-marker-alt"></i><span class="ms-2">Address</span></button>
                     </li> --}}
                     <li class="py-3 border-bottom nav-item">
                        <button class="nav-link p-0 bg-transparent" onclick="accountDetail();" data-bs-toggle="tab"
                           data-bs-target="#account-detail" type="button" role="tab" aria-selected="true"><i
                           class="fas fa-user"></i><span class="ms-2">Account details</span></button>
                     </li>
                     <li class="py-3 border-bottom nav-item">
                        <button class="nav-link p-0 bg-transparent" onclick="familyMembers('family_tbody');" data-bs-toggle="tab"
                           data-bs-target="#family_members" type="button" role="tab" aria-selected="true"><i
                           class="fas fa-user"></i><span class="ms-2">Family Members</span></button>
                     </li>
                     <li class="pt-3 nav-item">
                        <button class="nav-link p-0 bg-transparent" data-bs-toggle="tab"
                           data-bs-target="#change_password" type="button" role="tab" aria-selected="true"><i
                           class="fas fa-sign-out-alt"></i><span class="ms-2">Change Password</span></button>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
         <div class="col-lg-9 col-md-8">
            <div class="tab-content" id="product-menu-content">
                <div class="tab-pane fade show active" id="dashboard" role="tabpanel">
                    <div class="myaccount-content bg-primary-subtle text-body p-4">
                     <div class="container py-4">
                        <div class="row g-4">
                           <div class="col-md-6">
                              <h4>Hello {{Auth::user()->first_name}}</h4>
                           </div>
                        </div>
                     </div>
                        <div class="container py-4">
                            <div class="row g-4">
                                <!-- Confirmed -->
                                {{-- {{pr($data)}} --}}
                                <div class="col-md-4">
                                    <div class="p-4 booking-card bg-confirmed shadow-sm">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="mb-1 text-white">Confirmed</h5>
                                            <i class="fas fa-check-circle icon"></i>
                                        </div>  
                                        <p class="fs-4 fw-bold mb-1">{{$data['confirm_booking_count']}} Appointments</p>
                                        <a href="#" class="card-link text-white">View Bookings</a>
                                    </div>
                                </div>

                                <!-- Completed -->
                                <div class="col-md-4">
                                    <div class="p-4 booking-card bg-completed shadow-sm">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="mb-1">Completed</h5>
                                            <i class="fas fa-calendar-check icon"></i>
                                        </div>
                                        <p class="fs-4 fw-bold mb-1">{{$data['completed_booking_count']}} Appointments</p>
                                        <a href="/bookings/completed" class="card-link text-white">View Bookings</a>
                                    </div>
                                </div>

                                <!-- Pending -->
                                <div class="col-md-4">
                                    <div class="p-4 booking-card bg-pending shadow-sm">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="mb-1">Pending</h5>
                                            <i class="fas fa-hourglass-half icon"></i>
                                        </div>
                                        <p class="fs-4 fw-bold mb-1">{{$data['pending_booking_count']}} Appointments</p>
                                        <a href="/bookings/pending" class="card-link text-dark">View Bookings</a>
                                    </div>
                                </div>

                                <!-- Canceled -->
                                <div class="col-md-4">
                                    <div class="p-4 booking-card bg-canceled shadow-sm">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="mb-1">Canceled</h5>
                                            <i class="fas fa-times-circle icon"></i>
                                        </div>
                                        <p class="fs-4 fw-bold mb-1">{{$data['canceled_booking_count']}} Appointments</p>
                                        <a href="/bookings/canceled" class="card-link text-white">View Bookings</a>
                                    </div>
                                </div>

                                <!-- Waiting -->
                                <div class="col-md-4">
                                    <div class="p-4 booking-card bg-waiting shadow-sm">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="mb-1">Declined</h5>
                                            <i class="fas fa-clock icon"></i>
                                        </div>
                                        <p class="fs-4 fw-bold mb-1">{{$data['decline_booking_count']}} Appointments</p>
                                        <a href="/bookings/declined" class="card-link text-white">View Bookings</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="confirmed_bookings" role="tabpanel">
                    <div class="orders-table bg-primary-subtle text-body p-4">
                        <h4>Confirmed Bookings</h4>
                        <div class="table-responsive">
                            <table class="w-100">
                            <thead>
                                <tr class="border-bottom">
                                    <th class="text-primary fw-bolder p-3">Order</th>
                                    <th class="text-primary fw-bolder p-3">Date</th>
                                    <th class="text-primary fw-bolder p-3">Services</th>
                                    <th class="text-primary fw-bolder p-3">Patient</th>
                                    <th class="text-primary fw-bolder p-3">Total</th>
                                    <th class="text-primary fw-bolder p-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="confirm_booking_tbody">
                                {{-- <tr class="border-bottom">
                                    <td class="text-primary p-3 fs-6">#32604</td>
                                    <td class="p-3">October 28, 2022</td>
                                    <td class="p-3">October 28, 2022</td>
                                    <td class="p-3">$215.00 For 0 Items</td>
                                    <td class="text-primary p-3 fs-6">View</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td class="text-primary p-3 fs-6">#32584</td>
                                    <td class="p-3">October 27, 2022</td>
                                    <td class="p-3">$522.00 For 0 Items</td>
                                    <td class="text-primary p-3 fs-6">View</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td class="text-primary p-3 fs-6">#31756</td>
                                    <td class="p-3">October 19, 2022</td>
                                    <td class="p-3">$243.00 For 0 Items</td>
                                    <td class="text-primary p-3 fs-6">View</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td class="text-primary p-3 fs-6">#23663</td>
                                    <td class="p-3">October 7, 2022</td>
                                    <td class="p-3">$123.00 For 0 Items</td>
                                    <td class="text-primary p-3 fs-6">View</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td class="text-primary p-3 fs-6">#23612</td>
                                    <td class="p-3">October 7, 2022</td>
                                    <td class="p-3">$64.00 For 0 Items</td>
                                    <td class="text-primary p-3 fs-6">View</td>
                                </tr>
                                <tr>
                                    <td class="text-primary p-3 fs-6">#19243</td>
                                    <td class="p-3">April 1, 2022</td>
                                    <td class="p-3">$159.00 For 0 Items</td>
                                    <td class="text-primary p-3 fs-6">View</td>
                                </tr> --}}
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="completed_bookings" role="tabpanel">
                    <div class="orders-table bg-primary-subtle text-body p-4">
                        <h4>Completed Bookings</h4>
                        <div class="table-responsive">
                            <table class="w-100">
                                <thead>
                                <tr class="border-bottom">
                                    <th class="text-primary fw-bolder p-3">Order</th>
                                    <th class="text-primary fw-bolder p-3">Date</th>
                                    <th class="text-primary fw-bolder p-3">Services</th>
                                    <th class="text-primary fw-bolder p-3">Patient</th>
                                    <th class="text-primary fw-bolder p-3">Total</th>
                                    <th class="text-primary fw-bolder p-3">Actions</th>
                                </tr>
                                </thead>
                                <tbody id="completed_b_tbody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="canceled_bookings" role="tabpanel">
                    <div class="orders-table bg-primary-subtle text-body p-4">
                        <h4>Canceled Bookings</h4>
                        <div class="table-responsive">
                            <table class="w-100">
                                <thead>
                                <tr class="border-bottom">
                                    <th class="text-primary fw-bolder p-3">Order</th>
                                    <th class="text-primary fw-bolder p-3">Date</th>
                                    <th class="text-primary fw-bolder p-3">Services</th>
                                    <th class="text-primary fw-bolder p-3">Patient</th>
                                    <th class="text-primary fw-bolder p-3">Total</th>
                                    <th class="text-primary fw-bolder p-3">Actions</th>
                                </tr>
                                </thead>
                                <tbody id="canceledbookingtbody">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pending_bookings" role="tabpanel">
                    <div class="orders-table bg-primary-subtle text-body p-4">
                        <h4>Pending Bookings</h4>
                        <div class="table-responsive">
                            <table class="w-100">
                                <thead>
                                <tr class="border-bottom">
                                    <th class="text-primary fw-bolder p-3">Order</th>
                                    <th class="text-primary fw-bolder p-3">Date</th>
                                    <th class="text-primary fw-bolder p-3">Services</th>
                                    <th class="text-primary fw-bolder p-3">Patient</th>
                                    <th class="text-primary fw-bolder p-3">Total</th>
                                    <th class="text-primary fw-bolder p-3">Actions</th>
                                </tr>
                                </thead>
                                <tbody id="pbtbody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="waitlist_bookings" role="tabpanel">
                    <div class="orders-table bg-primary-subtle text-body p-4">
                        <h4>Waitlist Bookings</h4>
                        <div class="table-responsive">
                            <table class="w-100">
                                <thead>
                                <tr class="border-bottom">
                                    <th class="text-primary fw-bolder p-3">Order</th>
                                    <th class="text-primary fw-bolder p-3">Date</th>
                                    <th class="text-primary fw-bolder p-3">Services</th>
                                    <th class="text-primary fw-bolder p-3">Patient</th>
                                    <th class="text-primary fw-bolder p-3">Amount</th>
                                    <th class="text-primary fw-bolder p-3">Actions</th>
                                </tr>
                                </thead>
                                <tbody id="wait_b_tbody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
               {{-- <div class="tab-pane fade" id="downloads" role="tabpanel">
                  <div class="orders-table bg-primary-subtle text-body p-4">
                     <div class="table-responsive">
                        <table class="w-100">
                           <thead>
                              <tr class="border-bottom">
                                 <th class="text-primary fw-bolder p-3">Product</th>
                                 <th class="text-primary fw-bolder p-3">Downloads Remaining</th>
                                 <th class="text-primary fw-bolder p-3">Expires</th>
                                 <th class="text-primary fw-bolder p-3">Download</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td class="text-primary p-3 fs-6">Electric Toothbrush</td>
                                 <td class="p-3">∞</td>
                                 <td class="p-3 fs-6">Never</td>
                                 <td class="p-3"><a href="#" class="p-2 bg-primary text-white fs-6"
                                    download>Product
                                    Demo</a>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
               <div class="tab-pane fade" id="address" role="tabpanel">
                  <div class="bg-primary-subtle text-body p-4">
                     <p class="my-3">The following addresses will be used on the checkout page by default.</p>
                     <div class="d-flex align-items-center justify-content-between my-5 gap-2 flex-wrap">
                        <h4 class="mb-0">Billing Address.</h4>
                        <a href="#" class="btn btn-primary" data-bs-toggle="collapse"
                           data-bs-target="#edit-address-1" aria-expanded="false">Edit<i
                           class="fas fa-chevron-right ms-1"></i></a>
                     </div>
                     <div id="edit-address-1" class="collapse">
                        <div class="primary-soft-dark p-4 text-body mb-4">
                           <form>
                              <label class="mb-1">First name&nbsp; <span class="text-danger">*</span></label>
                              <input type="text" name="first-name" value="John" class="form-control mb-5 rounded-0" required="required">
                              <label class="mb-1">Last name&nbsp; <span class="text-danger">*</span></label>
                              <input type="text" name="last-name" value="deo" class="form-control mb-5 rounded-0" required="required">
                              <label class="mb-1">Company name (optional)</label>
                              <input type="text" name="company-name" value="Iqonic Design" class="form-control mb-5 rounded-0">
                              <label class="mb-1">Country / Region &nbsp; <span class="text-danger">*</span></label>
                              <div class="mb-5">
                                 <select class="select2-basic-single js-states" aria-label="select country"
                                    required="required">
                                    <option value="" selected>Choose a country</option>
                                    <option value="1">India</option>
                                    <option value="2">United Kingdom</option>
                                    <option value="3">United States</option>
                                    <option value="4">Australia</option>
                                    <option value="5">North Corea</option>
                                 </select>
                              </div>
                              <label class="mb-1">Street address&nbsp; <span class="text-danger">*</span></label>
                              <input type="text" name="address" placeholder="House number and street name" value="4517 Kentucky" class="form-control mb-5 rounded-0"
                                 required="required">
                              <input type="text" name="address" placeholder="Apartment, suite, unit, etc. (optional)" class="form-control mb-5 rounded-0">
                              <label class="mb-1">Town / City&nbsp; <span class="text-danger">*</span></label>
                              <input type="text" name="city" value="Navsari" class="form-control mb-5 rounded-0" required="required">
                              <label class="mb-1">State&nbsp; <span class="text-danger">*</span></label>
                              <div class="mb-5">
                                 <select class="select2-basic-single js-states" aria-label="select state">
                                    <option value="" selected>Choose a State</option>
                                    <option value="1">Gujarat</option>
                                    <option value="2">Delhi</option>
                                    <option value="3">Goa</option>
                                    <option value="4">Haryana</option>
                                    <option value="5">Ladakh</option>
                                 </select>
                              </div>
                              <label class="mb-1">PIN code&nbsp; <span class="text-danger">*</span></label>
                              <input type="text" name="pin code" value="396321" class="form-control mb-5 rounded-0" required="required">
                              <label class="mb-1">Phone&nbsp; <span class="text-danger">*</span></label>
                              <input type="tel" name="number" value="1234567890" class="form-control mb-5 rounded-0" required="required">
                              <label class="mb-1">Email address&nbsp; <span class="text-danger">*</span></label>
                              <input type="email" name="email" value="johndeo@gmail.com" class="form-control mb-5 rounded-0" required="required">
                              <div class="iq-btn-container button-primary">
                                 <button type="submit" class="iq-button text-capitalize border-0">
                                    <span class="iq-btn-text-holder position-relative">Save Address</span>
                                    <span class="iq-btn-icon-holder">
                                       <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"
                                          viewBox="0 0 8 8" fill="none">
                                          <path
                                             d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z"
                                             fill="currentColor"></path>
                                       </svg>
                                    </span>
                                 </button>
                              </div>
                           </form>
                        </div>
                     </div>
                     <div class="table-responsive">
                        <table class="edit-address w-100">
                           <tr>
                              <td class="label-name p-2">Name</td>
                              <td class="seprator p-2"><span>:</span></td>
                              <td class="p-2">john deo</td>
                           </tr>
                           <tr>
                              <td class="label-name p-2">Company</td>
                              <td class="seprator p-2"><span>:</span></td>
                              <td class="p-2">Iqonic Design</td>
                           </tr>
                           <tr>
                              <td class="label-name p-2">Country</td>
                              <td class="seprator p-2"><span>:</span></td>
                              <td class="p-2">India</td>
                           </tr>
                           <tr>
                              <td class="label-name p-2">Address</td>
                              <td class="seprator p-2"><span>:</span></td>
                              <td class="p-2">4517 Washington Ave, Manchester.</td>
                           </tr>
                           <tr>
                              <td class="label-name p-2">E-mail</td>
                              <td class="seprator p-2"><span>:</span></td>
                              <td class="p-2">johndeo@gmail.com</td>
                           </tr>
                           <tr>
                              <td class="label-name p-2">Phone</td>
                              <td class="seprator p-2"><span>:</span></td>
                              <td class="p-2">1234567890</td>
                           </tr>
                        </table>
                     </div>
                     <div class="d-flex align-items-center justify-content-between my-5 gap-2 flex-wrap">
                        <h4 class="mb-0">Shipping Address</h4>
                        <a href="#" class="btn btn-primary" data-bs-toggle="collapse"
                           data-bs-target="#edit-address-2" aria-expanded="false">Edit<i
                           class="fas fa-chevron-right ms-1"></i></a>
                     </div>
                     <div id="edit-address-2" class="collapse">
                        <div class="primary-soft-dark p-4 text-body mb-4">
                           <form>
                              <label class="mb-1">First name&nbsp; <span class="text-danger">*</span></label>
                              <input type="text" name="first-name" value="John"
                                 class="form-control mb-5 rounded-0" required="required">
                              <label class="mb-1">Last name&nbsp; <span class="text-danger">*</span></label>
                              <input type="text" name="last-name" value="deo"
                                 class="form-control mb-5 rounded-0" required="required">
                              <label class="mb-1">Company name (optional)</label>
                              <input type="text" name="last-name" value="Iqonic Design"
                                 class="form-control mb-5 rounded-0">
                              <label class="mb-1">Country / Region &nbsp; <span
                                 class="text-danger">*</span></label>
                              <div class="mb-5">
                                 <select class="select2-basic-single js-states" aria-label="select country"
                                    required="required">
                                    <option value="" selected>Choose a country</option>
                                    <option value="1">India</option>
                                    <option value="2">United Kingdom</option>
                                    <option value="3">United States</option>
                                    <option value="4">Australia</option>
                                    <option value="5">North Corea</option>
                                 </select>
                              </div>
                              <label class="mb-1">Street address&nbsp; <span
                                 class="text-danger">*</span></label>
                              <input type="text" name="address" placeholder="House number and street name"
                                 value="4517 Kentucky" class="form-control mb-3 rounded-0"
                                 required="required">
                              <input type="text" name="address"
                                 placeholder="Apartment, suite, unit, etc. (optional)" class="form-control mb-5 rounded-0">
                              <label class="mb-1">Town / City&nbsp; <span class="text-danger">*</span></label>
                              <input type="text" name="city" value="Navsari"
                                 class="form-control mb-5 rounded-0" required="required">
                              <label class="mb-1">State&nbsp; <span class="text-danger">*</span></label>
                              <div class="mb-5">
                                 <select class="select2-basic-single js-states" aria-label="select state">
                                    <option value="" selected>Choose a State</option>
                                    <option value="1">Gujarat</option>
                                    <option value="2">Delhi</option>
                                    <option value="3">Goa</option>
                                    <option value="4">Haryana</option>
                                    <option value="5">Ladakh</option>
                                 </select>
                              </div>
                              <label class="mb-1">PIN code&nbsp; <span class="text-danger">*</span></label>
                              <input type="text" name="pin code" value="396321"
                                 class="form-control mb-5 rounded-0" required="required">
                              <label class="mb-1">Phone&nbsp; <span class="text-danger">*</span></label>
                              <input type="tel" name="number" value="1234567890"
                                 class="form-control mb-5 rounded-0" required="required">
                              <label class="mb-1">Email address&nbsp; <span
                                 class="text-danger">*</span></label>
                              <input type="email" name="email" value="johndeo@gmail.com"
                                 class="form-control mb-5 rounded-0" required="required">
                              <div class="iq-btn-container button-primary">
                                 <button type="submit" class="iq-button text-capitalize border-0">
                                    <span class="iq-btn-text-holder position-relative">Save
                                    Address</span>
                                    <span class="iq-btn-icon-holder">
                                       <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 8 8" fill="none">
                                          <path
                                             d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z"
                                             fill="currentColor"></path>
                                       </svg>
                                    </span>
                                 </button>
                              </div>
                           </form>
                        </div>
                     </div>
                     <div class="table-responsive">
                        <table class="edit-address w-100">
                           <tr>
                              <td class="label-name p-2">Name</td>
                              <td class="seprator p-2"><span>:</span></td>
                              <td class="p-2">john deo</td>
                           </tr>
                           <tr>
                              <td class="label-name p-2">Company</td>
                              <td class="seprator p-2"><span>:</span></td>
                              <td class="p-2">Iqonic Design</td>
                           </tr>
                           <tr>
                              <td class="label-name p-2">Country</td>
                              <td class="seprator p-2"><span>:</span></td>
                              <td class="p-2">India</td>
                           </tr>
                           <tr>
                              <td class="label-name p-2">Address</td>
                              <td class="seprator p-2"><span>:</span></td>
                              <td class="p-2">4517 Washington Ave, Manchester.</td>
                           </tr>
                           <tr>
                              <td class="label-name p-2">E-mail</td>
                              <td class="seprator p-2"><span>:</span></td>
                              <td class="p-2">johndeo@gmail.com</td>
                           </tr>
                           <tr>
                              <td class="label-name p-2">Phone</td>
                              <td class="seprator p-2"><span>:</span></td>
                              <td class="p-2">1234567890</td>
                           </tr>
                        </table>
                     </div>
                  </div>
               </div> --}}
               <div class="tab-pane fade" id="account-detail" role="tabpanel">
                  <div class="bg-primary-subtle p-4 text-body">
                     <h4 class="pb-3">Account Detail</h4>
                     <form id="accountForm">
                        <label class="mb-1">First Name&nbsp; <span class="text-danger">*</span></label>
                        <input type="text" name="acc_first_name" id="acc_first_name" value="" class="form-control mb-5 rounded-0" required="required">

                        <label class="mb-1">Last Name&nbsp; <span class="text-danger">*</span></label>
                        <input type="text" name="acc_last_name" id="acc_last_name" value="" class="form-control mb-5 rounded-0" required="required">
                        <em class="d-block mb-5">This will be how your name will be displayed in the account section and in reviews</em>
                        
                        <label class="mb-1">Email address&nbsp; <span class="text-danger">*</span></label>
                        <input type="email" name="acc_email" id="acc_email" value="" class="form-control mb-5 rounded-0" required="required">

                        <label class="mb-1">Mobile&nbsp; <span class="text-danger">*</span></label>
                        <input type="text" name="acc_mobile" id="acc_mobile" value="" class="form-control mb-5 rounded-0" required="required">
                        
                        <label class="mb-1">Gender&nbsp; <span class="text-danger">*</span></label>
                        <select name="acc_gender" id="acc_gender" class="form-select mb-5 rounded-0" required="required">
                           <option value="">Select Gender</option>
                           <option value="Male">Male</option>
                           <option value="Female">Female</option>
                           <option value="Other">Other</option>
                        </select>

                        <label class="mb-1">City&nbsp; <span class="text-danger">*</span></label>
                        <input type="text" name="acc_city" id="acc_city" value="" class="form-control mb-5 rounded-0">

                        <label class="mb-1">State&nbsp; <span class="text-danger">*</span></label>
                        <input type="text" name="acc_state" id="acc_state" value="" class="form-control mb-5 rounded-0">

                        <label class="mb-1">Postal Code&nbsp; <span class="text-danger">*</span></label>
                        <input type="text" name="acc_postal_code" id="acc_postal_code" value="" class="form-control mb-5 rounded-0">

                        <label class="mb-1">Address&nbsp; <span class="text-danger">*</span></label>
                        <input type="text" name="acc_address" id="acc_address" value="" class="form-control mb-5 rounded-0">
                        
                        <div class="iq-btn-container button-primary">
                           <button type="submit" class="iq-button text-capitalize border-0">
                              <span class="iq-btn-text-holder position-relative">Save changes</span>
                              <span class="iq-btn-icon-holder">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"
                                    viewBox="0 0 8 8" fill="none">
                                    <path
                                       d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z"
                                       fill="currentColor"></path>
                                 </svg>
                              </span>
                           </button>
                        </div>
                     </form>
                  </div>
               </div>
               <div class="tab-pane fade" id="family_members" role="tabpanel">
                    <div class="orders-table bg-primary-subtle text-body p-4">
                        <div class="row pb-5">
                           <div class="col-lg-4 d-flex justify-content-start">
                              <h4>Family Members</h4>
                           </div>
                           <div class="col-lg-8 d-flex justify-content-end">
                              <a href="javascript:void(0);" data-dependent="no" data-bs-toggle="modal" data-bs-target="#addFamilyPop" data-bs-whatever="addFamilyPop" class="btn btn-primary openModalBtn me-2">Add Family Member</a>
                              <a href="javascript:void(0);" data-dependent="yes" data-bs-toggle="modal" data-bs-target="#addFamilyPop" data-bs-whatever="addFamilyPop" class="btn btn-primary openModalBtn me-2" title="Add Dependent like Minor, who have not email and mobile number">Add Dependent</a>
                              <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addExistingClientPopUp" data-bs-whatever="addExistingClientPopUp" class="btn btn-primary" title="Add Existing in Family">Add Existing in Family</a>
                           </div>
                        </div>
                        <div class="table-responsive">
                            <table class="w-100">
                                <thead>
                                <tr class="border-bottom">
                                    <th class="text-primary fw-bolder p-3">Name</th>
                                    <th class="text-primary fw-bolder p-3">Email</th>
                                    <th class="text-primary fw-bolder p-3">Mobile</th>
                                    <th class="text-primary fw-bolder p-3">Actions</th>
                                </tr>
                                </thead>
                                <tbody id="family_tbody">
                                  
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
               <div class="tab-pane fade" id="change_password" role="">
                <div class="bg-primary-subtle p-4 text-body">
                    <h4 class="fw-normal mb-5">Password change</h4>
                  <form id="changePassForm">
                    <label class="mb-1">Current password (leave blank to leave unchanged)</label>
                    <input type="password" name="current_password" id="current_password" class="form-control mb-5 rounded-0">
                    <label class="mb-1">New password (leave blank to leave unchanged)</label>
                    <input type="password" name="new_password" id="new_password" class="form-control mb-5 rounded-0">
                    <label class="mb-1">Confirm new password</label>
                    <input type="password" name="new_password_confirmation" id="confirm_password" class="form-control mb-5 rounded-0">
                    <div class="iq-btn-container button-primary">
                        <button type="submit" class="iq-button text-capitalize border-0">
                            <span class="iq-btn-text-holder position-relative">Save changes</span>
                            <span class="iq-btn-icon-holder">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"
                                viewBox="0 0 8 8" fill="none">
                                <path
                                    d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z"
                                    fill="currentColor"></path>
                                </svg>
                            </span>
                        </button>
                    </div>
                  </form>
                </div> 
               </div>
               <div class="tab-pane fade" id="logout" role="tabpanel">
                  <div class="row">
                     <div class="col-md-6">
                        <h4 class="mb-5 text-primary">Login</h4>
                        <form method="post">
                           <input type="text" name="user-name" class="form-control mb-4 rounded-0" placeholder="Username or email address *" required>
                           <input type="password" name="pwd" class="form-control mb-4 rounded-0" placeholder="Password" required>
                           <label class="custom-form-field mb-5">
                           <input type="checkbox" required="required" class="mr-2">
                           <span class="checkmark"></span>
                           <span>Remember me</span>
                           </label>
                           <div class="iq-btn-container button-primary">
                              <button type="submit" class="iq-button text-capitalize border-0 mb-3">
                                 <span class="iq-btn-text-holder position-relative">log in</span>
                                 <span class="iq-btn-icon-holder">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"
                                       viewBox="0 0 8 8" fill="none">
                                       <path
                                          d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z"
                                          fill="currentColor"></path>
                                    </svg>
                                 </span>
                              </button>
                           </div>
                        </form>
                        <a href="reset-password.html" class="forgot-pwd text-primary">Lost your password?</a>
                     </div>
                     <div class="col-md-6">
                        <h4 class="mb-5 mt-5 mt-lg-0 mt-md-0 text-primary">Register</h4>
                        <form method="post">
                           <input type="text" name="user-name" placeholder="Username *"
                              class="form-control mb-4 rounded-0" required>
                           <input type="email" name="email-address" placeholder="Email address *"  pattern="^[a-zA-Z0-9._%+-]+@gmail\.com$"
                              class="form-control mb-4 rounded-0" required>
                           <input type="password" name="password" placeholder="Password *"
                              class="form-control mb-4 rounded-0" required>
                           <p class="mb-5"> Your personal data will be used to support your experience
                              throughout this
                              website, to manage access to your account, and for other purposes described in
                              our <a href="./privacy-policy.html"> privacy policy</a>. 
                           </p>
                           <div class="button-primary">
                              <button type="submit" class="iq-button text-capitalize border-0">
                                 <span class="iq-btn-text-holder position-relative">register</span>
                                 <span class="iq-btn-icon-holder">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"
                                       viewBox="0 0 8 8" fill="none">
                                       <path
                                          d="M7.32046 4.70834H4.74952V7.25698C4.74952 7.66734 4.41395 8 4 8C3.58605 8 3.25048 7.66734 3.25048 7.25698V4.70834H0.679545C0.293423 4.6687 0 4.34614 0 3.96132C0 3.5765 0.293423 3.25394 0.679545 3.21431H3.24242V0.673653C3.28241 0.290878 3.60778 0 3.99597 0C4.38416 0 4.70954 0.290878 4.74952 0.673653V3.21431H7.32046C7.70658 3.25394 8 3.5765 8 3.96132C8 4.34614 7.70658 4.6687 7.32046 4.70834Z"
                                          fill="currentColor"></path>
                                    </svg>
                                 </span>
                              </button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

{{-- Add Family POPUP --}}
<div class="modal fade" id="addFamilyPop" tabindex="-1" aria-labelledby="varyingFamilyLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-primary-subtle">
            <div class="modal-header">
                <h5 class="modal-title" id="varyingFamilyLabel">Add Family Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form name="frmAddFamily" id="frmAddFamily" action="javascript:void(0);" method="POST">
                <div class="modal-body">
                  <div class="row">
                     <div class="col-6">
                        <div class="mb-3">
                           <input type="hidden" name="parent_id" value="{{$data['all_members']['id']}}">
                           <input type="hidden" name="dependent" value="no">
                           <label for="first_name" class="form-label">First Name</label>
                           <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" maxlength="40">
                           <div class="text-danger ms-5 error-first_name"></div>
                        </div>
                     </div>
                     <div class="col-6">
                        <div class="mb-3">
                           <label for="last_name" class="form-label">Last Name</label>
                           <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" maxlength="40">
                           <div class="text-danger ms-5 error-last_name"></div>
                        </div>
                     </div>
                     <div class="col-6">
                        <div class="mb-3">
                           <label for="email" class="form-label">Email:</label>
                           <input type="email" name="email" id="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon2">
                           <div class="text-danger ms-5 error-email"></div>
                        </div>
                     </div>
                     <div class="col-6">
                        <div class="mb-3">
                           <label for="mobile" class="form-label">Mobile:</label>
                           <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile" maxlength="10" aria-label="Mobile" aria-describedby="basic-addon2">
                           <div class="text-danger ms-5 error-mobile"></div>
                        </div>
                     </div>
                     <div class="col-6">
                        <div class="mb-3">
                           <label for="dob" class="form-label">Date of Birth:</label>
                           <input type="text" name="dob" id="dob" class="form-control" placeholder="Date of Birth" readonly aria-label="dob" aria-describedby="basic-addon2">
                           <div class="text-danger ms-5 error-dob"></div>
                        </div>
                     </div>
                     <div class="col-6">
                        <div class="mb-3">
                           <label for="gender" class="form-label">Gender:</label>
                           <select name="gender" id="gender" class="form-select" required>
                              <option value="">Select </option>
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                              <option value="Other">Other</option>
                           </select>
                           <div class="text-danger ms-5 error-gender"></div>
                        </div>
                     </div>
                     <div class="col-6">
                        <div class="mb-3">
                           <label class="form-label">City</label>
                           <input type="text" name="city" id="city" class="form-control" placeholder="City" maxlength="30">
                           <div class="text-danger ms-5 error-city"></div>
                        </div>
                     </div>
                     <div class="col-6">
                        <div class="mb-3">
                           <label class="form-label">State</label>
                           <input type="text" name="state" id="state" class="form-control" placeholder="State" maxlength="30">
                           <div class="text-danger ms-5 error-state"></div>
                        </div>
                     </div>
                     <div class="col-12">
                        <div class="mb-3">
                           <label class="form-label">Postal Code</label>
                           <input type="text" name="postal_code" id="postal_code" class="form-control" placeholder="Postal Code" maxlength="6">
                           <div class="text-danger ms-5 error-postal_code"></div>
                        </div>
                     </div>
                     <div class="col-6">
                        <div class="mb-3">
                           <label class="form-label">Address</label>
                           <textarea name="address" id="address" class="form-control" style="height: 10px;" placeholder="Address"></textarea>
                           <div class="text-danger ms-5 error-address"></div>
                        </div>
                     </div>
                     <div class="col-6">
                        <div class="mb-3">
                           <label for="remark" class="form-label">Remark:</label>
                           <textarea name="remark" id="remark" class="form-control" placeholder="Remark" style="height: 10px;"></textarea>
                           <div class="text-danger ms-5 error-remark"></div>
                        </div>
                     </div>
                  </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="btnLog"
                        class="btn btn-primary">Save</button>
                    <button class="btn btn-primary d-none" id="loader" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Add Family POPUP --}}

{{-- Add Existing Member in Family POPUP --}}
<div class="modal fade" id="addExistingClientPopUp" tabindex="-1" aria-labelledby="varyingFamilyLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-primary-subtle">
            <div class="modal-header">
                <h5 class="modal-title" id="varyingFamilyLabel">Add Individual as Family Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form name="frmAddExistingClient" id="frmAddExistingClient" action="javascript:void(0);" method="POST">
                <div class="modal-body">
                  <div class="row">
                     <div class="col-6">
                        <div class="mb-3">
                           <input type="hidden" name="parent_id" value="{{$data['all_members']['id']}}">
                           <label for="first_name" class="form-label">First Name</label>
                           <input type="text" class="form-control" name="first_name" id="exist_first_name" placeholder="First Name" maxlength="40">
                           <div class="text-danger ms-5 error-exist_first_name"></div>
                        </div>
                     </div>
                     <div class="col-6">
                        <div class="mb-3">
                           <label for="last_name" class="form-label">Last Name</label>
                           <input type="text" class="form-control" name="last_name" id="exist_last_name" placeholder="Last Name" maxlength="40">
                           <div class="text-danger ms-5 error-exist_last_name"></div>
                        </div>
                     </div>
                     <div class="col-6">
                        <div class="mb-3">
                           <label for="email" class="form-label">Email:</label>
                           <input type="email" name="email" id="exist_email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon2">
                           <div class="text-danger ms-5 error-exist_email"></div>
                        </div>
                     </div>
                     <div class="col-6">
                        <div class="mb-3">
                           <label for="mobile" class="form-label">Mobile:</label>
                           <input type="text" name="mobile" id="exist_mobile" class="form-control" placeholder="Mobile" maxlength="10" aria-label="Mobile" aria-describedby="basic-addon2">
                           <div class="text-danger ms-5 error-exist_mobile"></div>
                        </div>
                     </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="btnLog"
                        class="btn btn-primary">Submit</button>
                    <button class="btn btn-primary d-none" id="loader" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Add Existing Member in Family POPUP --}

{{-- Delete Existing Member From Family POPUP --}}
<div class="modal fade" id="memberDeletePopup" tabindex="-1" aria-labelledby="varyingFamilyLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-primary-subtle">
            <div class="modal-header">
                <h5 class="modal-title" id="varyingFamilyLabel">Add Individual as Family Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form name="frmAddExistingClient" id="frmAddExistingClient" action="javascript:void(0);" method="POST">
                <div class="modal-body">
                  <div class="row">
                     <div class="col-6">
                        <div class="mb-3">
                           <input type="hidden" name="parent_id" value="{{$data['all_members']['id']}}">
                           <label for="first_name" class="form-label">First Name</label>
                           <input type="text" class="form-control" name="first_name" id="exist_first_name" placeholder="First Name" maxlength="40">
                           <div class="text-danger ms-5 error-exist_first_name"></div>
                        </div>
                     </div>
                     <div class="col-6">
                        <div class="mb-3">
                           <label for="last_name" class="form-label">Last Name</label>
                           <input type="text" class="form-control" name="last_name" id="exist_last_name" placeholder="Last Name" maxlength="40">
                           <div class="text-danger ms-5 error-exist_last_name"></div>
                        </div>
                     </div>
                     <div class="col-6">
                        <div class="mb-3">
                           <label for="email" class="form-label">Email:</label>
                           <input type="email" name="email" id="exist_email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon2">
                           <div class="text-danger ms-5 error-exist_email"></div>
                        </div>
                     </div>
                     <div class="col-6">
                        <div class="mb-3">
                           <label for="mobile" class="form-label">Mobile:</label>
                           <input type="text" name="mobile" id="exist_mobile" class="form-control" placeholder="Mobile" maxlength="10" aria-label="Mobile" aria-describedby="basic-addon2">
                           <div class="text-danger ms-5 error-exist_mobile"></div>
                        </div>
                     </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="btnLog"
                        class="btn btn-primary">Submit</button>
                    <button class="btn btn-primary d-none" id="loader" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Add Existing Member in Family POPUP --}}
@endsection