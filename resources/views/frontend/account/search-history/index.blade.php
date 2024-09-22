@extends('frontend.layouts.account_app')

@section('title')  
<title>{{config('app.name')}} - Search History</title>
@endsection

@section('content')
<div id="content" class="collapsed">
	<div class="main-content">
		<div class="container">
			<div class="search-history py-4">
				<!-- heading search history -->
				<div class="col-md-12">
					<div class="card search-history-heading py-3 px-3">
						<h3><i class="fa fa-search px-2"></i>Search History</h3>
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
											<th scope="col">#</th>
											<th scope="col">IP</th>
											<th scope="col">Search By</th>
											<th scope="col">Search Value</th>
											<th scope="col">Status</th>
											<th>Credit Used</th>
											<th scope="col">Location</th>
											<th scope="col">User Agent</th>
											<th scope="col">Time</th>
											<th scope="col">Action</th>
										</tr>
									</thead>
									<tbody>

										@forelse($records as $key => $value)
										<tr>
											<td scope="row">{{$loop->index + 1}}</td>
											<td>{{$value->ip_address}}</td>
											<td>{{$value->result->search_key}}</td>
											@if($value->result->search_key == 'phone')
											<td>{{$value->result->country->phone_code ?? '' .$value->result->search_value ?? ''}}</td>
											@else
											<td>{{$value->result->search_value}}</td>
											@endif
											<td>{{$value->result->status_code}}</td>
											<td>1</td>
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
										<td><a href="{{route('history.show', ['id' => $value->id])}}"><button class="btn btn-secondary"><i class="fa-solid fa-eye"></i></button></a></td>
									</tr>
									@empty
									<tr>
										<td colspan="9">No record found.</td>
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