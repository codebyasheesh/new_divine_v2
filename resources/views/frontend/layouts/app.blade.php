<!doctype html>
<html lang="en" data-bs-theme="light" dir="ltr" class="landing-pages">
  @include('frontend.includes.head')
  <body class=" body-bg landing-pages">
    <span class="screen-darken"></span>
    {{-- loader Start --}}
    {{-- <div id="loading">
      <div class="loader simple-loader">
          <div class="loader-body">
              <img src="./assets/images/logo/divine-logo.png" alt="loader" class="light-loader img-fluid " width="200">
          </div>
      </div>    
    </div> --}}
    <main class="main-content">
      @include('frontend.includes.header')

      @yield('content')

    </main>
    @include('frontend.includes.footer')
    
    @include('frontend.includes.scripts')
  </body>
</html>