@php
    $currencySymbol = config('constant.currency_symbol');
@endphp
@foreach($listing->items() as $k => $row)
<tr>
	<td>
		{{ $row->id }}
	</td>
	<td>
		{{ $row->name }}
	</td>
	<td>
		<span class="badge bg-primary">{{ @$row->categories['name'] }}</span>
	</td>
	<td>
		{{ $row->owner_first_name . ' ' . $row->owner_last_name }}
	</td>
	<td>
		{{ $currencySymbol}} {{ $row->price}}
	</td>
	
	<td>
		{{ _dt($row->created_at) }}
	</td>
	<td class="text-right">
		<div class="action_dropdown btn-group">
			<a href="javascript:;" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fas fa-ellipsis-v"></i>
			</a>
			<ul class="dropdown-menu dropdown-menu-end">
				<li>
					<a class="dropdown-item" href="{{ route('admin.products.edit', ['id' => $row->id]) }}">
						<i class="fas fa-edit text-primary"></i>
						<span class="status">Edit</span>
					</a>
				</li>
				<li>
					<a class="dropdown-item delete_confirm" href="{{ route('admin.products.delete', ['id' => $row->id]) }}">
						<i class="fas fa-trash-alt text-danger"></i>
						<span class="status">Delete</span>
					</a>
				</li>
			</ul>
		</div>
	</td>
</tr>
@endforeach