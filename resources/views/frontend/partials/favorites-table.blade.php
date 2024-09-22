<div class="table-responsive">
	<table>
		<tr>
			<th>Token</th>
			<th>Favorited Address</th>
			<th>Note</th>
			<th>Action</th>
		</tr>
		@forelse($records as $recordsData)
		<tr>
			<td>
				<div class="d-flex align-items-center">
					<img src="{{asset('assets/frontend/images/coins/'.strtolower($recordsData->address_type).'.png')}}" alt="" class="me-1 coin-sm">
					<span class="lh-1">{{strtoupper($recordsData->address_type)}}</span>
				</div>
			</td>
			<td><p class="mb-0 text-truncate txn-address" data-bs-toggle="tooltip" data-bs-original-title="{{$recordsData->address}}">
				{{Illuminate\Support\Str::limit($recordsData->address, 20, '..')}}
			</p></td>
			<td><p class="mb-0 text-truncate" data-bs-toggle="tooltip" data-bs-original-title="{{$recordsData->description}}">{{Illuminate\Support\Str::limit($recordsData->description, 25, '..')}}</p>
			</td>
			@php
			$ad = $recordsData->address;
			$url = route('blockchain-search').'?keyword='.$ad;
			@endphp
			
			<td><a href="{{$url}}"><button class="btn btn-secondary btn-eye"><i class="fa-solid fa-eye"></i></button></a></td>

		</tr>
		@empty
		<tr><td colspan="4">No data found.</td></tr>
		@endforelse
	</table>
</div>
<div class="custom-pagination mt-3">
	{{$records->onEachSide(0)->links()}}
</div>