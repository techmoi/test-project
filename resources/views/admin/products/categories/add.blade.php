@extends('layouts.adminlayout')
@section('content')

<div class="page-header">
    <h3 class="page-title">Manage Product Categories </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.products.categories') }}">Product Categories</a></li>
            <li class="breadcrumb-item active" aria-current="page">Product Category Add</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            @include('admin.partials.flash_messages')
            <div class="card-body">
                <h4 class="card-title">Product Category</h4>
                <form action="{{ route('admin.products.categories.add') }}" method="post" class="form-validation">
                {{ csrf_field() }}
                    <div class="form-group">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Enter name" required />
                        <label id="name-error" class="error" for="name">@error('name') {{ $message }} @enderror</label>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea  class="form-control" name="description" placeholder="Enter description">{{ old('description') }}</textarea>
                        <label id="description-error" class="error" for="description">@error('description') {{ $message }} @enderror</label>
                    </div>
                    
                    <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection