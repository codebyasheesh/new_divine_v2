@extends('admin.layouts.app')

@section('content')
  {{-- begin::App Content Header --}}
  <div class="app-content-header">
    <div class="container-fluid">
            {{-- begin::Row --}}
        <div class="row">
            <div class="col-sm-6"><h3 class="mb-0">Dashboard</h3></div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
            </div>
        </div>
        {{-- end::Row --}}
        </div>
    </div>
  {{-- end::App Content Header --}}

  {{-- begin::App Content --}}
  <div class="app-content">
    <div class="container-fluid">
        {{-- begin::Row --}}
        <div class="row">
            {{-- begin::Col --}}
            <div class="col-lg-3 col-6">
            {{-- begin::Small Box Widget 1 --}}
            <div class="small-box text-bg-success">
                <div class="inner">
                <h3>{{$data['confirm_b_count']}}</h3>
                <p>Confirmed Bookings</p>
                </div>
                {{-- <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path
                    d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"
                ></path>
                </svg> --}}
                <svg class="small-box-icon" style="height: 40px" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">  <path fill="#555" d="M10,0 C15.5228475,0 20,4.4771525 20,10 C20,15.5228475 15.5228475,20 10,20 C4.4771525,20 0,15.5228475 0,10 C0,4.4771525 4.4771525,0 10,0 Z M10,1.39534884 C5.24778239,1.39534884 1.39534884,5.24778239 1.39534884,10 C1.39534884,14.7522176 5.24778239,18.6046512 10,18.6046512 C14.7522176,18.6046512 18.6046512,14.7522176 18.6046512,10 C18.6046512,5.24778239 14.7522176,1.39534884 10,1.39534884 Z M14.9217059,6.58259135 C15.2023597,6.83364758 15.2263532,7.26468369 14.975297,7.54533745 L10.0661666,13.0332153 C9.79907323,13.3317969 9.33334374,13.336857 9.05982608,13.0441491 L5.71907855,9.46901192 C5.46198377,9.19387916 5.47660645,8.76242348 5.75173921,8.5053287 C6.02687198,8.24823392 6.45832765,8.26285659 6.71542243,8.53798936 L9.54702033,11.5682545 L13.9589598,6.63618243 C14.210016,6.35552866 14.6410521,6.33153512 14.9217059,6.58259135 Z"/></svg>
                <a
                href="{{ route('admin.appointments', ['status' => 'confirmed']) }}"
                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
                >
                More info <i class="bi bi-link-45deg"></i>
                </a>
            </div>
            {{-- end::Small Box Widget 1 --}}
            </div>
            {{-- end::Col --}}

            {{-- Completed Booking Count --}}
            {{-- <div class="col-lg-3 col-6">
                
                <div class="small-box text-bg-success">
                    <div class="inner">
                    <h3>{{$data['complete_b_count']}}</h3>
                    <p>Completed Bookings</p>
                    </div>
                    
                    <svg version="1.1" id="Layer_1" class="small-box-icon"
                    fill="currentColor" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 205.6 210.1" style="enable-background:new 0 0 205.6 210.1; width: 40px;" xml:space="preserve">
                    <style type="text/css">
                        .st0{fill:none;stroke:#414141;stroke-width:20;stroke-linecap:round;stroke-miterlimit:10;}
                    </style>
                    <g id="Layer_1_00000013894529776988771080000008285348099351712953_"></g>
                    <g id="Layer_2_00000150065450979971019660000006376701433373302432_"></g><g id="Layer_3"></g><g id="Layer_4"></g><g id="Layer_5"></g><g id="Layer_6"></g>
                    <g id="Layer_7"></g><g id="Layer_8"></g><g id="Layer_9"><g><path class="st0" d="M37.3,22.6h143c8.5,0,15.3,6.8,15.3,15.1V185c0,8.3-6.9,15.1-15.3,15.1h-155c-8.5,0-15.3-6.8-15.3-15.1V37.7 c0-8.3,6.9-15.1,15.3-15.1L37.3,22.6z"/>
                    <path class="st0" d="M10,69.4h185.6"/><g><path class="st0" d="M150.3,10v25.3"/></g><g><path class="st0" d="M52.6,10v25.3"/></g><path class="st0" d="M72.3,129.7l20.5,20.2l45.1-44.3"/></g></g><g id="Layer_10"></g><g id="Layer_11">
                    </g><g id="Layer_12"></g><g id="Layer_13"></g><g id="Layer_14"></g><g id="Layer_15"></g><g id="Layer_17"></g><g id="Layer_18"></g><g id="Layer_19">
                    </g><g id="Layer_20"></g><g id="Layer_21"></g><g id="Layer_23"></g>
                    <g id="Layer_24"></g><g id="Layer_25"></g><g id="Layer_26"></g><g id="Layer_27"></g><g id="Layer_28"></g><g id="Layer_29"></g><g id="Layer_30">
                    </g><g id="Layer_31"></g><g id="Layer_32"></g><g id="Layer_33"></g><g id="Layer_34"></g><g id="Layer_35"></g><g id="Layer_36">
                    </g><g id="Layer_37"></g><g id="Layer_38"></g><g id="Layer_39"></g>
                    <g id="Layer_40"></g><g id="Layer_41"></g><g id="Layer_42"></g><g id="Layer_43"></g>
                    <g id="Layer_44">
                    </g>
                    <g id="Layer_46">
                    </g>
                    <g id="Layer_45">
                    </g>
                    <g id="Layer_47">
                    </g>
                    <g id="Layer_48">
                    </g>
                    <g id="Layer_49">
                    </g>
                    <g id="Layer_50">
                    </g>
                    <g id="Layer_51">
                    </g>
                    </svg>
                    <a
                    href="{{ route('admin.appointments', ['status' => 'completed']) }}"
                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
                    >
                    More info <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
            
            </div> --}}
            <!--end::Col-->
            
            <div class="col-lg-3 col-6">
                <div class="small-box text-bg-warning">
                    <div class="inner">
                    <h3>{{$data['pending_b_count']}}</h3>
                    <p>Pending Bookings</p>
                    </div>
                    <svg
                    class="small-box-icon"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                    >
                    <path
                        clip-rule="evenodd"
                        fill-rule="evenodd"
                        d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z"
                    ></path>
                    <path
                        clip-rule="evenodd"
                        fill-rule="evenodd"
                        d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z"
                    ></path>
                    </svg>
                    <a
                    href="{{ route('admin.appointments', ['status' => 'pending']) }}"
                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
                    >
                    More info <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-3 col-6">
            {{-- begin::Small Box Widget 3 --}}
                <div class="small-box text-bg-primary">
                    <div class="inner">
                    <h3>{{$data['customer_count']}}</h3>
                    <p>User Registrations</p>
                    </div>
                    <svg
                    class="small-box-icon"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                    >
                    <path
                        d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z"
                    ></path>
                    </svg>
                    <a
                    href="{{ route('admin.users') }}"
                    class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover"
                    >
                    More info <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
            {{-- end::Small Box Widget 3 --}}
            </div>
            {{-- end::Col --}}

            {{-- Canceled Booking Count --}}
            {{-- <div class="col-lg-3 col-6">
            
                <div class="small-box text-bg-danger">
                    <div class="inner">
                    <h3>{{$data['cancel_b_count']}}</h3>
                    <p>Canceled Bookings</p>
                    </div>
                    <svg
                    class="small-box-icon"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                    >
                    <path
                        clip-rule="evenodd"
                        fill-rule="evenodd"
                        d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z"
                    ></path>
                    <path
                        clip-rule="evenodd"
                        fill-rule="evenodd"
                        d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z"
                    ></path>
                    </svg>
                    <a
                    href="{{ route('admin.appointments', ['status' => 'canceled']) }}"
                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
                    >
                    More info <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
            
            </div> --}}

            

            {{-- Declined Booking Count --}}
            {{-- <div class="col-lg-3 col-6">
                <div class="small-box text-bg-secondary">
                    <div class="inner">
                    <h3>{{$data['declined_b_count']}}</h3>
                    <p>Declined Bookings</p>
                    </div>
                    <svg
                    class="small-box-icon"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                    >
                    <path
                        clip-rule="evenodd"
                        fill-rule="evenodd"
                        d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z"
                    ></path>
                    <path
                        clip-rule="evenodd"
                        fill-rule="evenodd"
                        d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z"
                    ></path>
                    </svg>
                    <a
                    href="{{ route('admin.appointments', ['status' => 'declined']) }}"
                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
                    >
                    More info <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
            </div> --}}
        </div>
        {{-- end::Row --}}

        {{-- Calender :: Row --}}
        <div class="row">
            <div class="col-12 mt-3">
                <h3>Appointments</h3>
                <div class="card">
                    <div class="card-body p-3">
                        <!-- THE CALENDAR -->
                        <div id="calendar"></div>
                    </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
            
            </div>
        </div>
        {{-- End Calender :: Row --}}
        </div>
  </div>
  {{-- end::App Content --}}
@endsection
