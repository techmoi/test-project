@php
  $admin = AdminAuth::getLoginUser();
@endphp

<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <a href="{{ route('admin.dashboard') }}" class="nav-link">
        <div class="nav-profile-image">
          <img src="{{url('admin/images/faces/face1.jpg')}}" alt="profile" />
          <span class="login-status online"></span>
          <!--change to offline or busy as needed-->
        </div>
        <div class="nav-profile-text d-flex flex-column">
          <span class="font-weight-bold mb-2">{{ ucfirst($admin->first_name).' '.ucfirst($admin->last_name) }}</span>
        </div>
        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
      </a>
    </li>
    @php 
      $active = strpos(request()->route()->getAction()['as'], 'admin.dashboard') > -1
    @endphp
    <li class="nav-item {{ $active ? ' active' : '' }}">
      <a class="nav-link" href="{{ route('admin.dashboard') }}">
        <span class="menu-title">Dashboard</span>
        <i class="mdi mdi-home menu-icon"></i>
      </a>
    </li>
    @php 
        $active = strpos(request()->route()->getAction()['as'], 'admin.products') > -1 || strpos(request()->route()->getAction()['as'], 'admin.products.categories') > -1;
    @endphp
    <li class="nav-item ">
      <a class="nav-link" data-bs-toggle="collapse" href="#tables" aria-expanded="{{ $active ? 'true' : 'false' }} " aria-controls="tables">
        <span class="menu-title">Products</span>
        <i class="mdi mdi-table-large menu-icon"></i>
      </a>
      <div class="collapse {{ $active ? ' show' : '' }} " id="tables">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.products') }}">Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.products.categories') }}">Categories</a>
          </li>
        </ul>
      </div>
    </li>
  </ul>
</nav>