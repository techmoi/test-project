@php
    $currencySymbol = config('constant.currency_symbol');
@endphp
@extends('layouts.adminlayout')
@section('content')
 <div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white me-2">
      <i class="mdi mdi-home"></i>
    </span> Dashboard
  </h3>
  <nav aria-label="breadcrumb">
    <ul class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
        <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
      </li>
    </ul>
  </nav>
</div>
<div class="row">
  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Recent Products</h4>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th> Name </th>
                <th> Price </th>
                <th> Created At </th>
              </tr>
            </thead>
            <tbody>
              @foreach($product as $v)
              <tr>
                <td> {{ @$v['name'] }}</td>
                <td> {{ @$currencySymbol }}{{ @$v['price'] }}</td>
                <td> {{ _dt($v['created_at']) }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection