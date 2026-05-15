<head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Massage Therapy Clinic in Caledon - Divine Touch Therapy</title>
      <!-- Config Options -->
      <meta name="setting_options" content='{&quot;saveLocal&quot;:&quot;sessionStorage&quot;,&quot;storeKey&quot;:&quot;huisetting&quot;,&quot;setting&quot;:{&quot;app_name&quot;:{&quot;value&quot;:&quot;Kivicare&quot;}}}'>
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <!-- Google Font Api KEY-->
      <meta name="google_font_api" content="AIzaSyBG58yNdAjc20_8jAvLNSVi9E4Xhwjau_k">
      <!-- Favicon -->
      <!-- <link rel="shortcut icon" href="assets/images/favicon.ico" /> -->
      <link rel="icon" href="{{asset('frontend_assets/divinetherapy.ico')}}" type="image/x-icon" >
      
      <!-- Library / Plugin Css Build -->
      <link rel="stylesheet" href="{{asset('frontend_assets/css/core/libs.min.css')}}" />
      
      <!-- flaticon css -->
      <link rel="stylesheet" href="{{asset('frontend_assets/vendor/flaticon/css/flaticon.css')}}" />
      
      <!-- font-awesome css -->
      <link rel="stylesheet" href="{{asset('frontend_assets/vendor/font-awesome/css/all.min.css')}}" />
      
      <!-- Flatpickr css -->
      @if(Route::currentRouteName() === 'book_appointment')
      <link rel="stylesheet" href="{{asset('frontend_assets/vendor/flatpickr/dist/flatpickr.min.css')}}" />
      @endif
      
      <!-- Sweetlaert2 css -->
      <link rel="stylesheet" href="{{asset('frontend_assets/vendor/sweetalert2/dist/sweetalert2.min.css')}}"/>
      
      
      <!-- SwiperSlider css -->
      <link rel="stylesheet" href="{{asset('frontend_assets/vendor/swiperSlider/swiper-bundle.min.css')}}">
      
      <!-- Kivicare Design System Css -->
      <link rel="stylesheet" href="{{asset('frontend_assets/css/kivicare.min.css?v=1.4.1')}}" />
      
      <!-- Custom Css -->
      <link rel="stylesheet" href="{{asset('frontend_assets/css/custom.min.css?v=1.4.1')}}" />
      
      <!-- Rtl Css -->
      <link rel="stylesheet" href="{{asset('frontend_assets/css/rtl.min.css?v=1.4.1')}}" />
      
      <!-- Customizer Css -->
      <link rel="stylesheet" href="{{asset('frontend_assets/css/customizer.min.css?v=1.4.1')}}"/>
      <link rel="stylesheet" href="{{asset('frontend_assets/css/custom_style.css')}}"/>
      @if(Route::currentRouteName() === 'medical_form' || Route::currentRouteName() === 'my_account' || Route::currentRouteName() === 'book_appointment')
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" />
      @endif
      <!-- Google Font -->
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

      <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@300;400;500;600;700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;1,300;1,400;1,500&display=swap" rel="stylesheet">
      <!-- <link href='//fonts.googleapis.com/css?family=Tangerine:400,700' rel='stylesheet' type='text/css'> -->
      @stack('styles')
      
      <meta name="page_colors" content='[{&quot;var&quot;:&quot;--bs-primary&quot;,&quot;value&quot;:&quot;#ff6d9f&quot;},{&quot;var&quot;:&quot;--bs-primary-bg-subtle&quot;,&quot;value&quot;:&quot;#fbebf1&quot;},{&quot;var&quot;:&quot;--bs-primary-rgb&quot;,&quot;value&quot;:&quot;255, 109, 159&quot;},{&quot;var&quot;:&quot;--bs-primary-shade-20&quot;,&quot;value&quot;:&quot;#e55f8d&quot;},{&quot;var&quot;:&quot;--bs-secondary&quot;,&quot;value&quot;:&quot;#171c26&quot;},{&quot;var&quot;:&quot;--bs-secondary-rgb&quot;,&quot;value&quot;:&quot;23, 28, 38&quot;}]'>
      <style>
         /* Global system font for all text elements */
         * {
            /* font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji" !important; */
            -webkit-font-smoothing: antialiased !important;
            -moz-osx-font-smoothing: grayscale !important;
         }
          .divine-section {
            background-color: #f5f5f5;
            padding: 9.375rem 1rem 6.375rem 1rem;
          }
      </style>
  </head>