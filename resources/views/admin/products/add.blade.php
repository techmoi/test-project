@extends('layouts.adminlayout')
@section('content')

<div class="page-header">
    <h3 class="page-title">Manage Product  </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.products') }}">Product </a></li>
            <li class="breadcrumb-item active" aria-current="page">Product Add</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            @include('admin.partials.flash_messages')
            <div class="card-body">
                <h4 class="card-title">Product</h4>
                <form action="{{ route('admin.products.add') }}" method="post" class="form-validation">
                {{ csrf_field() }}
            		<div class="form-group">
						<label class="form-label">Category</label>
						<select class="select2 form-select" name="category_id">
							<option value="">Select</option>
					      	@foreach($categories as $c)
				      			<option 
				      				value="{{ $c->id }}" 
					      				{{ old('category_id') && $c->id == old('category_id')  ? 'selected' : '' }}
					      			>{{ $c->name }}
					      		</option>
					  		@endforeach
					    </select>
						<label id="category_id-error" class="error" for="category_id">@error('category_id') {{ $message }} @enderror</label>
					</div>
                    <div class="form-group">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Enter name" required />
                        <label id="name-error" class="error" for="name">@error('name') {{ $message }} @enderror</label>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Price</label>
                        <input type="number" class="form-control" name="price" value="{{ old('price') }}" placeholder="Enter price" step="0.01" min="0" required />
                        <label id="price-error" class="error" for="price">@error('price') {{ $message }} @enderror</label>
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