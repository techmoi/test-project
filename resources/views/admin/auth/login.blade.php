@php
	$logo = config('constant.logo');
	$companyName = config('constant.company_name');
@endphp

@extends('layouts.adminloginlayout')

@section('content')

<div class="container-scroller">
  <div class="container-fluid page-body-wrapper full-page-wrapper">
    <div class="content-wrapper d-flex align-items-center auth">
      <div class="row flex-grow">
        <div class="col-lg-4 mx-auto">
          <div class="auth-form-light text-left p-5">
            <div class="brand-logo">
              {{-- <img src="{{ url('admin/images/logo.svg')}}"> --}}
              <img src="{{ General::renderImage($logo ?? '')}}" alt="{{ $companyName ?? 'Logo'}}">
            </div>
            <h4>Hello! let's get started</h4>
            <h6 class="font-weight-light">Sign in to continue.</h6>
             @include('admin.partials.flash_messages')
		        <form action="{{ route('admin.login') }}" method="post" class="mb-3" id="login">
		    	   {{ csrf_field() }}
              <div class="form-group">
                <input type="email" name = "email"class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Username" required>
                <label id="email-error" class="error" for="email"></label>
              </div>
              <div class="form-group">
                <input type="password" name = "password"class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password" required>
                 <label id="password-error" class="error" for="password"></label>
              </div>
              <div class="mt-3 d-grid gap-2">
              	<button class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" type="submit">Sign in</button>
              </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
  </div>
  <!-- page-body-wrapper ends -->
</div>




@endsection