@php
    $favicon = config('constant.favicon');
    $logo = config('constant.logo');
    $companyName = config('constant.company_name');
@endphp

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $companyName }}</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ url('admin/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{ url('admin/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{ url('admin/vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{ url('admin/vendors/font-awesome/css/font-awesome.min.css')}}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ url('admin/css/style.css')}}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ url('admin/images/favicon.png')}}" />
  </head>
  <body>
 		@yield('content')

    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ url('admin/vendors/js/vendor.bundle.base.js')}}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ url('admin/js/off-canvas.js')}}"></script>
    <script src="{{ url('admin/js/misc.js')}}"></script>
    <script src="{{ url('admin/js/settings.js')}}"></script>
    <script src="{{ url('admin/js/todolist.js')}}"></script>
    <script src="{{ url('admin/js/jquery.cookie.js')}}"></script>
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- endinject -->
  </body>
</html>