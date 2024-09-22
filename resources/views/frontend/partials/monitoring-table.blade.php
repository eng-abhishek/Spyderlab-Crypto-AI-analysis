<table class="table">
	<thead>
		<tr>
			<th scope="col">Token</th>
			<th scope="col">Wallet Address</th>
			<th scope="col">Description</th>
			<th scope="col">Recipient Email</th>
			<th scope="col">Status</th>
			<th scope="col">Action</th>
		</tr>
	</thead>
	<tbody>
		@forelse($result as $value)
		<tr>
			<th scope="row"><img src="{{asset('assets/frontend/images/coins/'.strtolower($value->token).'.png')}}" alt="{{$value->token}}" height="30">{{$value->token}}</th>

			<td><p class="mb-0 text-truncate txn-address" data-bs-toggle="tooltip" data-bs-original-title="{{$value->address}}">{{Illuminate\Support\Str::limit($value->address, 20, '..')}}</p></td>

			<td><p class="mb-0 text-truncate" data-bs-toggle="tooltip" data-bs-original-title="{{$value->description}}">
			{{Illuminate\Support\Str::limit($value->description, 25, '..')}}
			</p>
			</td>

			<td>
				@if($value->email != 'null')
				@php 
				$email = json_decode($value->email,true);
				@endphp

				{{ implode(', ', $email) }}
				@else
				NULL
				@endif
			</td>

			<td>
				@php
				if($value->is_active == 'Y'){
				$checked = 'checked';
			}else{
			$checked = '';
		}
		@endphp
		<div class="form-check form-switch">
			<input type="checkbox" {{$checked}} class="is_active{{$value->id}} form-check-input" id="customSwitch1" data-id="{{$value->id}}">
			<label class="form-check-label" for="customSwitch1"></label>
		</div>
	</td>

	<td>
		<div class="dropdown">
			<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
				...
			</button>
			<ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
				<li><a href="javascript:void(0)" class="dropdown-item editItem{{$value->id}}" data-url="{{route('monitoring.edit', $value->id)}}" onclick="getEditData('{{$value->id}}')" href="">Edit</a></li>
				<form action="{{ route('monitoring.destroy',$value->id) }}" method="POST">
					@csrf
					@method('DELETE')
					<li><button type="submit"class="dropdown-item">Delete</button></li>
				</form>

			</ul>
		</div>
	</td>
</tr>
@empty
<tr><td colspan="3">No data found.</td></tr>
@endforelse
</tbody>
</table>
<div class="custom-pagination mt-3">
	{{$result->onEachSide(0)->links()}}
</div>