@extends('layouts.adminlayout')
@section('content')

<div class="page-header">
 <h3 class="page-title">Manage Product Categories </h3>
</div>
<div class="row">
  	<div class="col-lg-12 grid-margin stretch-card">
	    <div class="card">
	      	<div class="card-body">
		  		@include('admin.partials.flash_messages')
		        <h4 class="card-title">Product Categories</h4>
		        <a href="{{ route('admin.products.categories.add') }}"><p class="	card-description"> Add category <code></code>
		        </p></a>
		        <table class="table">
		          <thead>
		            <tr>
		              <th>Sno</th>
		              <th>Names</th>
		              <th>Created By</th>
		              <th>Created</th>
		              <th>Action</th>
		            </tr>
		          </thead>
		          <tbody>
		            @if(!empty($listing->items()))
						@include('admin.products.categories.listingLoop')
					@else
					<td align="left" colspan="7">
		            	No records found!
		            </td>
					@endif
		          	</tbody>
			        <tfoot>
						<tr>
							<th colspan="7">
								<div class="provider_pagination">
									@include('admin.partials.pagination', [
										"pagination" => $listing
									])
								</div>
							</th>
						</tr>
					</tfoot>
		        </table>
	      	</div>
	    </div>
	</div>
</div>

@endsection