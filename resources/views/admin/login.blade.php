<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Admin - Login, Divine Touch Therapy</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="Divine Touch Therapy Admin | Login Page" />
    <meta name="author" content="Asheesh Ranjan Khare" />
    <meta name="description" content="Divine Touch Therapy" />
    <meta name="keywords" content="Divine Touch Therapy" />

    <link rel="shortcut icon" href="{{asset('admin_assets/assets/img/favicon.png')}}" />
    <!--end::Primary Meta Tags-->
    <!--begin::Fonts-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="{{asset('admin_assets/css/adminlte.css')}}" />
    <!--end::Required Plugin(AdminLTE)-->
  </head>
  <!--end::Head-->
  <!--begin::Body-->
  {{-- {{session()->forget(['otp_admin_id', 'otp_required','otp_expiry_time']);}} --}}
  <body class="login-page bg-body-secondary">
    <div class="login-box">
      <div class="login-logo">
        <a href="{{ route('admin.login') }}"><img src="{{asset('admin_assets/assets/img/divine-logo.png')}}" alt="Divine Touch Therapy" title="Divine Touch Therapy"></a>
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          @if(Session::has('success'))
          <div class="alert alert-success">{{ Session::get('success') }}</div>
          @endif

          @if(Session::has('error'))
          <div class="alert alert-danger"> {{ Session::get('error') }} </div>
          @endif
          <p class="login-box-msg">Sign in to start your session</p>
          {{-- <form action="#" id="frmLogin" method="post"> --}}
          <form action="{{ route('admin.authenticate') }}" method="post">
            @csrf
            @if(!session('otp_required'))
            <div class="input-group mb-3">
              <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}" tabindex="1" />
              <div class="input-group-text"><span class="bi bi-envelope"></span></div>
              @error('email')
              <div class="w-100 text-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control" name="password" placeholder="Password" tabindex="2" />
              <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
              @error('password')
              <div class="text-danger w-100"> {{ $message }} </div>
              @enderror
            </div>
            @endif
            <!--begin::Row-->
            @if(session('otp_required'))
            <div class="input-group mb-3">
              <input type="text" class="form-control" name="otp" maxlength="6" placeholder="Enter OTP" tabindex="2" />
              <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
              @error('otp_validate')
              <div class="text-danger w-100"> {{ $message }} </div>
              @enderror
            </div>
            <div class="input-group mb-3">
              <div class="input-group-text">OTP expires in &nbsp; <span id="otp-timer"></span></div>
            </div>
            @endif
            <div class="row">
              {{-- <div class="col-8">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                  <label class="form-check-label" for="flexCheckDefault"> Remember Me </label>
                </div>
              </div> --}}
              <!-- /.col -->
              <div class="col-12">
                <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-primary" id="sing_in_btn" tabindex="3">{{ session('otp_required') ? 'Verify OTP' : 'Sign In' }}</button>
                </div>
                <div class="d-grid gap-2"></div>
              </div>
              <!-- /.col -->
            </div>
            <!--end::Row-->
          </form>
          <!--<div class="social-auth-links text-center mb-3 d-grid gap-2">
            <p>- OR -</p>
            <a href="#" class="btn btn-primary">
              <i class="bi bi-facebook me-2"></i> Sign in using Facebook
            </a>
            <a href="#" class="btn btn-danger">
              <i class="bi bi-google me-2"></i> Sign in using Google+
            </a>
          </div>-->
          <!-- /.social-auth-links -->
          <!--<p class="mb-1"><a href="forgot-password.html">I forgot my password</a></p>
          <p class="mb-0">
            <a href="register.html" class="text-center"> Register a new membership </a>
          </p>-->
        </div>
        <!-- /.login-card-body -->
      </div>
    </div>
    <!-- /.login-box -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="{{asset('admin_assets/js/adminlte.js')}}"></script>
    
    <!--end::Script-->
    {{-- Login Script --}}
    @if(session('otp_required'))
      <script>
          document.addEventListener('DOMContentLoaded', function () {

          const expiryTime = Number(@json(session('otp_expiry_time')));
          const timerEl = document.getElementById('otp-timer');

          if (!expiryTime || !timerEl) {
              return;
          }

          function updateTimer() {
              const now = Math.floor(Date.now() / 1000);
              let remaining = expiryTime - now;

              if (remaining <= 0) {
                  timerEl.textContent = '00:00';
                  alert('OTP expired. Please login again.');
                  window.location.href = "{{ route('admin.relogin') }}";
                  return false;
              }

              const minutes = Math.floor(remaining / 60);
              const seconds = remaining % 60;

              timerEl.textContent =
                  String(minutes).padStart(2, '0') + ':' +
                  String(seconds).padStart(2, '0');
          }

          updateTimer();
          setInterval(updateTimer, 1000);
      });
      </script>
    @endif
    {{-- End Login Script --}}
  </body>
  <!--end::Body-->
</html>
