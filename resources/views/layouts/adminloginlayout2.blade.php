<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Purple Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{url('admin/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{url('admin/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{url('admin/vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{url('admin/vendors/font-awesome/css/font-awesome.min.css')}}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{url('admin/vendors/font-awesome/css/font-awesome.min.css')}}" />
    <link rel="stylesheet" href="{{url('admin/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{url('admin/css/style.css')}}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{url('admin/images/favicon.png')}}" />
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial -->
      <div class="content-wrapper" style="display:flex;justify-content:center;align-items:center;min-height:100vh;">
        @yield('content')
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{url('admin/vendors/js/vendor.bundle.base.js')}}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{url('admin/vendors/chart.js/chart.umd.js')}}"></script>
    <script src="{{url('admin/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{url('admin/js/off-canvas.js')}}"></script>
    <script src="{{url('admin/js/misc.js')}}"></script>
    <script src="{{url('admin/js/settings.js')}}"></script>
    <script src="{{url('admin/js/todolist.js')}}"></script>
    <script src="{{url('admin/js/jquery.cookie.js')}}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{url('admin/js/dashboard.js')}}"></script>
    <!-- End custom js for this page -->
  </body>
</html> 