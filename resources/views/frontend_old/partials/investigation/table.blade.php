<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th scope="col">Token</th>
				<th scope="col">Wallet Address</th>
				<th scope="col">Description</th>
				<th scope="col">Investigation</th>
				<th scope="col">Status</th>
				<th scope="col">Action</th>
			</tr>
		</thead>
		<tbody>
			@forelse($result as $value)
			<tr>
				<th scope="row">
					<img src="{{asset('assets/frontend/images/coins/'.strtolower($value->token).'.png')}}" alt="{{$value->token}}" height="30">{{$value->token}}</th>

					<td><p class="mb-0 text-truncate txn-address" data-bs-toggle="tooltip" data-bs-original-title="{{$value->address}}">{{Illuminate\Support\Str::limit($value->address, 18, '..')}}</p></td>

					<td>
						{{Illuminate\Support\Str::limit($value->description, 18, '..')}}
					</td>

					{{--<td><a href="{{route('investigation.graph')}}?keyword={{$value->address}}&token={{$value->token}}" class="btn btn-main-2 my-2 btnSearch" target="_blank">Click Here<i class="fa-thin fa-external-link p-1"></i></a>
					</td>--}}

					<td><a href="{{route('investigation.graph')}}?keyword={{$value->address}}&token={{$value->token}}" class="btn btn-secondary btnSearch" target="_blank"><i class="fa-regular fa-share-from-square"></i>Click Here</a>
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
						<li><a href="javascript:void(0)" class="dropdown-item editItem{{$value->id}}" data-url="{{route('investigation.edit', $value->id)}}" onclick="getEditData('{{$value->id}}')" href="">Edit</a></li>
						<form action="{{ route('investigation.destroy',$value->id) }}" method="POST">
							@csrf
							@method('DELETE')
							<li><button type="submit"class="dropdown-item">Delete</button></li>
						</form>

					</ul>
				</div>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>
<div class="custom-pagination mt-3">
	{{$result->onEachSide(0)->links()}}
</div>