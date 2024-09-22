@extends('frontend.layouts.account_app')

@section('title')  
<title>{{config('app.name')}} - Blockchain Search</title>
@endsection

@section('content')
<!-- main content -->
<div id="content" class="collapsed">
	<div class="main-content">
		<div class="container">
			<div class="search-result py-4">
				<div class="col-md-12">
					<div class="card search-result-heading">
						<div class="heading d-flex py-3 px-3">
							<h2><i class="fa fa-search px-2"></i>Search Result</h2>
						</div>
					</div>
				</div>
				@foreach($results as $key => $result)
				<div class="result">
					<div class="col-md-12">
						<h3>{{$key+1}} Result[S]</h3>
						<div class="card result-card py-3 px-5">
							<div class="row">

								@if($result->anti_fraud->credit == 1)

								<div class="col-md-3">
									<img src="{{asset('assets/frontend/images/icons/aml-safe.jpg')}}">
								</div>

								@elseif($result->anti_fraud->credit == 2)

								<div class="col-md-3">
									<img src="{{asset('assets/frontend/images/icons/aml-risk.jpg')}}">
								</div>

								@elseif($result->anti_fraud->credit == 3)

								<div class="col-md-3">
									<img src="{{asset('assets/frontend/images/icons/aml-warning.jpg')}}">
								</div>

								@endif

								<div class="col-md-6">
									<div class="result-details">
										<ul class="py-5">
											<li>Type: <span> {{$result->type}}</span> </li>


											@if(!empty($result->chain))
											<li>Chain: <span>{{$result->chain->name}}</span></li>
											@elseif(!empty($result->url))
											<li>URL: <span>{{$result->url}}</span></li>
											@elseif(!empty($result->domain))
											<li>Domain: <span>{{$result->domain}}</span></li>
											@elseif(!empty($result->ip))
											<li>Ip: <span>{{$result->ip}}</span></li>
											@endif

											@if(!empty($result->address))
											<li class="text-break">Address: <span>{{$result->address}}</span></li>
											@endif

										</ul>
									</div>
								</div>

								<div class="col-md-3">

									@if(!empty($result->address))

									@if(auth()->guard('backend')->check())

									<a href="{{route('blockchain-search').'?keyword='.$keyword.'&result_no='.$result->unique_id}}"><button class="btn btn-listing" title="{{($result->chain) ? $result->chain->name : '' }}"><i class="fa-solid fa-arrow-right mx-2"></i>Click Here</button></a>

									@else

									<a href="{{route('blockchain-search').'?keyword='.$keyword.'&result_no='.$result->unique_id}}"><button class="btn btn-listing" title="{{($result->chain) ? $result->chain->name : '' }}"><i class="fa-solid fa-arrow-right mx-2"></i>Click Here</button></a>


									@endif

									@endif

								</div>

							</div>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</div>
@endsection