<!doctype html>
<html lang="en">
  @include('admin.includes.head')
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
      @include('admin.includes.header')
      @include('admin.includes.sidebar')
      <main class="app-main">
        @yield('content')
      </main>
      @include('admin.includes.footer')
    </div>
    @include('admin.includes.scripts')
  </body>
</html>
