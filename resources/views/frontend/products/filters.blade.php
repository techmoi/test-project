<div class="hero-search set-bg" data-setbg="{{ url('frontend/img/search-bg.jpg') }}">
    <div class="container">
        <div class="filter-table">
            <form action="{{ route('product.index') }}" class="filter-search">
                <input type="text" name  = "search"placeholder="Search product" value="{{ isset($_GET['search']) && $_GET['search'] ? $_GET['search'] : '' }}">
                <select id="category" name = "category_id" data-placeholder="Nothing Selected">
                	<option value="">Category</option>
                    @foreach($categories as $c)
		      			<option value="{{ $c->id }}" {{ isset($_GET['category']) && $c->id == $_GET['category']  ? 'selected' : '' }}>{{ $c->name }}</option>
			  		@endforeach
                </select>
                <button type="submit">Search</button>
               <a href="{{ route('product.index') }}" class="btn btn-primary btn-lg">Reset All</a>
            </form>
        </div>
    </div>
</div>