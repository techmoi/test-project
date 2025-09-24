@extends('layouts.frontlayout')
@section('content')

@include('frontend.products.filters')
<section class="recipe-section spad">
    <div class="container">
        <div class="row">
        	@if(!empty($listing->items()))
	        	@foreach($listing->items() as $k => $row)

	            <div class="col-lg-4 col-sm-6">
	                <div class="recipe-item">
	                    <a href="#"><img src="img/recipe/recipe-1.jpg" alt=""></a>
	                    <div class="ri-text">
	                        <div class="cat-name">{{ @$row->categories['name'] ?? 'Uncategorized' }}</div>
	                        <a href="#">
	                            <h4>{{ @$row->name }}</h4>
	                        </a>
	                        <p>{{ @$row->description }}</p>
	                    </div>
	                </div>
	            </div>
	            @endforeach
        	 @else
                <div class="col-lg-12 text-center">
                    <p>No products found.</p>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="recipe-pagination">
                     {{ $listing->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</section>


@endsection