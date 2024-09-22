@extends('frontend.layouts.account_app')

@section('title')  
<title>{{config('app.name')}} - Blockchain Search History</title>
@endsection

@section('content')
<div id="content" class="collapsed">
	<div class="main-content">
		<div class="container">
			<div class="search-history py-4">
				<!-- heading search history -->
				<div class="col-md-12">
					<div class="card search-history-heading py-3 px-3">
						<h3><i class="fa fa-search px-2"></i>Blockchain Search History</h3>
					</div>
				</div>
				<!-- buy credits -->
				<div class="col-md-12">
					<div class="card available-credits">
						<div class="credit d-flex tex-center justify-content-center">
							<h4>Available credits:<span>{{available_credits()}}</span></h4>
							<a href="{{route('pricing')}}"><button class="btn btn-credits mx-3" type="buttton">Buy Credits</button></a>
						</div>
					</div>
				</div>
				<!-- search table -->
				<div class="search-history-information">
					<div class="col-md-12">
						<div class="search-history-table">
							<div class="table-responsive-lg">
								<table class="table table-hover">
									<thead class="text-center">
										<tr>
											<th>#</th>
											<th>IP</th>
											<th>Keyword</th>
											<th>Status</th>
											<th>Location</th>
											<th>User Agent</th>
											<th>Time</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>

										@forelse($records as $key => $value)
										<tr>
											<td>{{$loop->index + 1}}</td>
											<td>{{$value->ip_address}}</td>
											
											<td><p class="mb-0 text-truncate txn-address" data-bs-toggle="tooltip" data-bs-original-title="{{$value->search->keyword}}">
												{{Illuminate\Support\Str::limit($value->search->keyword, 18, '..')}}
											</p></td>

											<td>{{$value->search->status_code}}</td>
											<td>
												@php
												$location = "";
												if(!is_null($value->location)){
												$location_obj = json_decode($value->location);
												$location = 'City: <span class="fw-bold">'.$location_obj->city.'</span>';
												$location .= '<br>State: <span class="fw-bold">'.$location_obj->state.'</span>';
												$location .= '<br>Country: <span class="fw-bold">'.$location_obj->country.'</span>';
											}
											echo $location;
											@endphp
										</td>
										<td>{{$value->user_agent}}</td>
										<td>{{$value->created_at->format('Y-m-d H:i:s')}}</td>

										<td><a href="{{route("blockchain-search-history.show", ['id' => $value->search_id])}}"><button class="btn btn-secondary"><i class="fa-solid fa-eye"></i></button></a></td>
									</tr>
									@empty
									<tr>
										<td colspan="8">No record found.</td>
									</tr>
									@endforelse

								</tbody>
							</table>
						</div>
						{{$records->links()}}

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
@endsection