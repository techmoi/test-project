@php
    $profileImage = AdminAuth::getLoginUser()->image;
    $firstname = AdminAuth::getLoginUser()->first_name;
    $lastname = AdminAuth::getLoginUser()->last_name;
    $isAdmin = AdminAuth::getLoginUser()->is_admin;
    $logo = config('constant.logo');
    $companyName = config('constant.company_name');
@endphp

<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
      <a class="navbar-brand brand-logo" href="{{ route('admin.dashboard') }}"> <img src="{{ General::renderImage($logo ?? '')}}" alt="{{ $companyName ?? 'Logo'}}"></a>
      <a class="navbar-brand brand-logo-mini" href="{{ route('admin.dashboard') }}"> <img src="{{ General::renderImage($logo ?? '')}}" alt="{{ $companyName ?? 'Logo'}}"></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
        <span class="mdi mdi-menu"></span>
      </button>
      
      <ul class="navbar-nav navbar-nav-right">
        <li class="nav-item nav-profile dropdown">
          <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="nav-profile-img">
              <img src="{{url('admin/images/faces/face1.jpg')}}" alt="image">
              <span class="availability-status online"></span>
            </div>
            <div class="nav-profile-text">
              <p class="mb-1 text-black">{{ $firstname }} {{ $lastname }}</p>
            </div>
          </a>
          <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('admin.logout') }}">
              <i class="mdi mdi-logout me-2 text-primary"></i> Signout </a>
          </div>
        </li>
        <li class="nav-item d-none d-lg-block full-screen-link">
          <a class="nav-link">
            <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
          </a>
        </li>
       
        <li class="nav-item nav-logout d-none d-lg-block">
          <a class="nav-link"  href="{{ route('admin.logout') }}">
            <i class="mdi mdi-power"></i>
          </a>
        </li>
      </ul>
      <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
        <span class="mdi mdi-menu"></span>
      </button>
    </div>
</nav>
	