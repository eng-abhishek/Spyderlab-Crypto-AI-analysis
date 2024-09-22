@extends('frontend.layouts.app')

@section('og')
<title>{{ (!empty($seoData->title) && !empty($seoData)) ? $seoData->title : (settings('site')->meta_title ?? config('app.name')) }}</title>
<meta name="title" content="{{ ( !empty($seoData) && !empty($seoData->meta_title)) ? $seoData->meta_title : settings('site')->meta_title ?? ''}}">
<meta name="description" content="{{ ( !empty($seoData) && !empty($seoData->meta_des)) ? $seoData->meta_des :(settings('site')->meta_description ?? '')}}">
<meta name="keywords" content="{{ ( !empty($seoData) && !empty($seoData->meta_keyword)) ? $seoData->meta_keyword : (settings('site')->meta_keywords ?? '') }}">
<meta name="author" content="Osint">
<meta name="robots" content="index follow" />
<link rel="canonical" href="{{url()->current()}}"/>
<meta property="og:type" content="website" />
<meta property="og:title" content="{{ ( !empty($seoData) && !empty($seoData->meta_title)) ? $seoData->meta_title : settings('site')->meta_title ?? ''}}" />
<meta property="og:description" content="{{ (!empty($seoData) && !empty($seoData->meta_des) ) ? $seoData->meta_des :(settings('site')->meta_description ?? '')}}" />
<meta property="og:url" content="{{url()->current()}}"/>
<meta property="og:image" content="{{ !empty($seoData) ?  getNormalImage('featured_image',$seoData->featured_image) : asset('assets/frontend/images/spyderlab_featured_image.png')}}" />
<meta property="og:image:width" content="850">
<meta property="og:image:height" content="560">
<meta property="og:site_name" content="spyderlab" />
<meta property="og:locale" content="en" />
<meta property="twitter:url" content="{{url()->current()}}">
<meta property="twitter:image" content="{{ !empty($seoData) ? getNormalImage('featured_image',$seoData->featured_image) : asset('assets/frontend/images/spyderlab_featured_image.png')}}">
<meta property="twitter:title" content="{{ ( !empty($seoData) && !empty($seoData->meta_title)) ? $seoData->meta_title : settings('site')->meta_title ?? ''}}">
<meta property="twitter:description" content="{{ ( !empty($seoData) && !empty($seoData->meta_des)) ? $seoData->meta_des :(settings('site')->meta_description ?? '')}}">
<meta name="twitter:description" content="{{ ( !empty($seoData) && !empty($seoData->meta_des)) ? $seoData->meta_des :(settings('site')->meta_description ?? '')}}">
<meta name="twitter:image" content="{{ !empty($seoData) ? getNormalImage('featured_image',$seoData->featured_image) : asset('assets/frontend/images/spyderlab_featured_image.png')}}">
<meta name="twitter:card" value="summary_large_image">
<meta name="twitter:site" value="@spyderlab">
@endsection

@section('styles')
<style type="text/css">
	.highcharts-figure,
	.highcharts-data-table table {
		min-width: 320px;
		max-width: 800px;
		margin: 1em auto;
	}

	.highcharts-data-table table {
		font-family: Verdana, sans-serif;
		border-collapse: collapse;
		border: 1px solid #ebebeb;
		margin: 10px auto;
		text-align: center;
		width: 100%;
		max-width: 500px;
	}

	.highcharts-data-table caption {
		padding: 1em 0;
		font-size: 1.2em;
		color: #555;
	}

	.highcharts-data-table th {
		font-weight: 600;
		padding: 0.5em;
	}

	.highcharts-data-table td,
	.highcharts-data-table th,
	.highcharts-data-table caption {
		padding: 0.5em;
	}

	.highcharts-data-table thead tr,
	.highcharts-data-table tr:nth-child(even) {
		background: #f8f8f8;
	}

	.highcharts-data-table tr:hover {
		background: #f1f7ff;
	}
	.highcharts-credits{
		display:none;
	}
	#highchart_transaction_network_graph {
		height: 500px;
		width: auto;
		border: 1px solid lightgray;
		background-image: url("{{asset('assets/frontend/images/logo-wm.png')}}");
		background-repeat: no-repeat;
		background-size: 550px auto;
		background-position: center;
		background-color: #fff;
	}
	#aml-risk-score-chart {
      width: 100%;
      height: 250px;
  }
</style>
@endsection

@section('content')
<main>
	<section class="section-home py-5">
		<div class="container-xl container-fluid">
			<div class="row justify-content-center text-center">
				<div class="col-lg-12">
					<nav>
						<ol class="breadcrumb justify-content-center mb-3 text-light">
							<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
							<li class="breadcrumb-item active"><a href="{{route('blockchain-analysis')}}">Crypto Tracking</a></li>
							<li class="breadcrumb-item active">Details</li>
						</ol>
					</nav>
					<h1 class="fs-2 mb-0">Details</h1>
				</div>
			</div>
		</div>
	</section>
	<section class="bg-custom-light py-5">
		<div class="container-fluid">
			<div class="row">
				@if(Auth::guard('backend')->user())
				<div class="col-lg-12">
					@else
					<div class="col-lg-2">
						@include('frontend.layouts.partials.account-sidebar')
					</div>
					<div class="col-lg-10">
						@endif
						<div class="row">
							<div class="col-lg-8 col-md-12">
								<div class="row">
									<div class="col-lg-12 col-md-12">
										<div class="coin-item">
											<div class="d-flex justify-content-between align-items-center flex-md-row flex-column">
												@if(!empty($chainsight->chain) && isset($blockcypher['address_details']->currency))
												<img src="{{asset('assets/frontend/images/coins/'.$blockcypher['address_details']->currency.'.png')}}" alt="" class="me-md-3 me-auto ms-auto mb-md-0 mb-3 coin-symbol">
												@endif
												<div class="flex-grow-1 text-md-start text-center">
													<h2 class="">{{isset($blockcypher['address_details']->currency) ? strtoupper($blockcypher['address_details']->currency) : ''}}</h2> 
													<h3 class="text-break">
														@if(!empty($chainsight->address))
														<text class="key_address">{{$chainsight->address}}</text>
														@endif
														<a href="javascript:void(0)" onclick="copyToClipboard('.key_address')"><i class="fa-regular fa-copy mx-1"></i></a>
														<a href="#" data-bs-toggle="modal" data-bs-target="#flagModal"><i class="fa-solid fa-flag-alt mx-1 text-danger"></i></a>
													</h3>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-5 col-md-12 my-3">
										<div class="coin-item text-center">
											<h3 class="fs-4">AML Risk Score <i class="fa-regular fa-info-circle"></i></h3>
											
											<div id="aml-risk-score-chart"></div>
										</div>
									</div>

									<div class="col-lg-7 col-md-12 my-3">
										<div class="coin-item loader-div">
											<div class="d-flex justify-content-md-between justify-content-center flex-md-row flex-column text-md-start text-center">
												<div>
													<h3 class="d-inline-block mb-0">Overview</h3>
													<div class="btn-group rounded-pill overflow-hidden">

														@if($blockcypher['address_details']->currency == 'btc')
														<a class="btn btn-main-3 btn-sm" onclick="original_currency('btc')"><i class="fa-regular fa-bitcoin-sign"></i></a>
														<a onclick="btc_to_usd()" class="btn btn-main-3 btn-sm"><i class="fa-regular fa-dollar-sign"></i></a>
														@else
														<a class="btn btn-main-3 btn-sm" onclick="original_currency('eth')"><i class="fa-brands fa-ethereum"></i></a>
														<a onclick="eth_to_usd()" class="btn btn-main-3 btn-sm"><i class="fa-regular fa-dollar-sign"></i></a>
														@endif

													</div>
												</div>                                        
												<p class="fs-7 mb-0">Data Updated 1 min(s) ago <a href="javascript:void(0)" class="custom-link loader"><i class="fa-regular fa-refresh"></i></a></p>
											</div>
											<div class="row mt-3">
												@if(isset($blockcypher['address_details']))
												<div class="col-md-6">

													<div class="address-info">
														<h4>Balance</h4>
														<h5>
															@php
															$balance = $blockcypher['address_details']->balance;

															$original_balance = $blockcypher['address_details']->balance;

															if($blockcypher['address_details']->currency == 'btc'){
																$balance = round($blockcypher['address_details']->balance/config('constants.blockcypher.amount.btc'), 4).' BTC';

																$original_balance = round($blockcypher['address_details']->balance/config('constants.blockcypher.amount.btc'), 4);

															}elseif($blockcypher['address_details']->currency == 'eth'){
																$balance = round($blockcypher['address_details']->balance/config('constants.blockcypher.amount.eth'), 4).' ETH';

																$original_balance = round($blockcypher['address_details']->balance/config('constants.blockcypher.amount.eth'), 4);
															}
															@endphp
															<font class="balance_amount">{{$balance}}</font>
															<div data-balance="{{$original_balance}}" class="d-none currency-convert"></div>

														</h5>
													</div>

													<div class="address-info">
														<h4>First Seen (UTC)</h4>
														<h5>{{gmdate('M d, Y, h:i A', strtotime($blockcypher['address_details']->first_seen_at))}}</h5>
													</div>             

													<div class="address-info">
														<h4>Total Received</h4>
														<h5>
															@php
															$total_received = $blockcypher['address_details']->total_received;

															$or_total_received = $blockcypher['address_details']->total_received;

															if($blockcypher['address_details']->currency == 'btc'){
																$total_received = round($blockcypher['address_details']->total_received/config('constants.blockcypher.amount.btc'), 4).' BTC';

																$or_total_received = round($blockcypher['address_details']->total_received/config('constants.blockcypher.amount.btc'), 4);

															}elseif($blockcypher['address_details']->currency == 'eth'){
																$total_received = round($blockcypher['address_details']->total_received/config('constants.blockcypher.amount.eth'), 4).' ETH';

																$or_total_received = round($blockcypher['address_details']->total_received/config('constants.blockcypher.amount.eth'), 4);

															}

															@endphp
															
															<font class="total_received">{{$total_received}}</font>
															<div data-received="{{$or_total_received}}" class="d-none currency-received"></div>
														</h5>
													</div>

													<div class="address-info">
														<h4>Incoming Txn</h4>
														<h5>{{$blockcypher['address_details']->incoming_txn}}</h5>
													</div>   

												</div>

												<div class="col-md-6">
													<div class="address-info">
														<h4>TXS Count</h4>
														<h5>{{$blockcypher['address_details']->total_txn}}</h5>
													</div>

													<div class="address-info">
														<h4>Last Seen (UTC)</h4>
														<h5>{{gmdate('M d, Y, h:i A', strtotime($blockcypher['address_details']->last_seen_at))}}</h5>
													</div>

													<div class="address-info">
														<h4>Total Sepnt</h4>
														<h5>
															@php
															$total_sent = $blockcypher['address_details']->total_sent;

															$or_total_sent = $blockcypher['address_details']->total_sent;

															if($blockcypher['address_details']->currency == 'btc'){
																$total_sent = round($blockcypher['address_details']->total_sent/config('constants.blockcypher.amount.btc'), 4).' BTC';

																$or_total_sent = round($blockcypher['address_details']->total_sent/config('constants.blockcypher.amount.btc'), 4);

															}elseif($blockcypher['address_details']->currency == 'eth'){
																$total_sent = round($blockcypher['address_details']->total_sent/config('constants.blockcypher.amount.eth'), 4).' ETH';

																$or_total_sent = round($blockcypher['address_details']->total_sent/config('constants.blockcypher.amount.eth'), 4);

															}
															@endphp
															<font class="total_sent">{{$total_sent}}</font>
															<div data-sent="{{$or_total_sent}}" class="d-none currency-send"></div>
														</h5>
													</div>

													<div class="address-info">
														<h4>Outgoing Txn</h4>
														<h5>{{$blockcypher['address_details']->outgoing_txn}}</h5>
													</div>
												</div>

												@else
												<div class="text-center">
													<img src="{{asset('assets/frontend/images/frown.png')}}" alt="" class="mb-2 coin-symbol">
													<p class="mb-0"><small>Not Found</small></p>
												</div>
												@endif
											</div>
										</div>
									</div>

								</div>
							</div>
							<div class="col-lg-4 col-md-12">
								<div class="coin-item">
									<h3 class="fs-5">
										Spyderlab AI detect
										<i class="fa-regular fa-info-circle"></i>
									</h3>

									@if(count($new_array_labels)>0)
									<p class="mb-1">This account is related to</p>
									@foreach($new_array_labels as $key=>$labelsData)
									<span class="badge bg-danger d-inline">{{ $labelsData }}</span>
									@endforeach
									@else

									<div class="text-center">
										<img src="{{asset('assets/frontend/images/frown.png')}}" alt="" class="mb-2 coin-symbol">
										<p class="mb-0"><small>Not Found</small></p>
									</div>
									@endif
								</div>
								@if(Auth::user())
								<div class="coin-item my-3">
									<h3 class="fs-5">
										<i class="fa-solid fa-star"></i>
										Favorites
									</h3>
									<form>
										<label for="" class="form-label">Private Note: </label>
										<textarea name="user_notes" id="user_notes" rows="5" class="form-control" placeholder="Adding Note Here">{!! $user_notes !!}</textarea>
										<input type="text" name="coin_type" class="coin_type" hidden value="{{(isset($blockcypher['address_details']->currency)) ? $blockcypher['address_details']->currency : ''}}">
										<div class="form-text">* Only you can see this note</div>
									</form>
								</div>
								@endif
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 col-md-12">
								<div class="coin-item my-3">
									<h3 class="fs-5">
										Tranaction Action Analysis
										<i class="fa-regular fa-info-circle"></i>
									</h3>
									<div class="row text-center">
										<div class="col-lg-12 my-3">
											{{-- <h4 class="fs-6">Incoming Transaction Actions</h4> --}}
											<figure class="highcharts-figure">
												<div id="in_out_txn_pie_chart"></div>
											</figure>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12 col-md-12">
								<div class="coin-item my-3">
									<div class="d-flex justify-content-between align-items-center flex-column flex-md-row">
										<h3 class="fs-5 mb-md-0 mb-3">
											Address Profile Analysis
											<i class="fa-regular fa-info-circle"></i>
										</h3>
				{{--<div class="d-flex">
					<label class="form-check-label" for="txn">All Txs</label>
					<div class="form-check form-switch ps-0">
						<input class="form-check-input mx-1" type="checkbox" role="switch" id="txn" checked="">
					</div>                                    
					<label class="form-check-label" for="txn">Only Outgoing</label>
				</div>--}}
			</div>
			<div class="row mt-3">
				<div class="col-lg-12">
					<div class="d-flex flex-column flex-md-row justify-content-start">
						<div class="me-md-12 d-flex address-analysis">
							<p class="text-truncate text-nowrap gas-fee mb-0" id="add_profile_analisis"> {{$chainsight->address}}</p>
							<a href="javascript:void(0)" onclick="copyToClipboard('#add_profile_analisis')" class="text-secondary"><i class="fa-regular fa-copy mx-1"></i></a>
						</div>
						{{--<div class="address-analysis">Common Use Time: 00 00 00 00 00 (UTC)</div>--}}
					</div>
				</div>
			</div>
			<div class="row text-center">

				<div class="col-lg-12 py-3">
					<h4 class="fs-6"><i class="fa-regular fa-route bg-dark p-2 rounded-circle text-light"></i> Related Events</h4>
					<div class="row">

						<div class="col-lg-3 my-3">
							<div class="address-vitals">
								<h5>{{ (in_array('theft',$array_labels) ? '1' : '0')}}</h5>
								<h6>Theft</h6>
							</div>
						</div>

						<div class="col-lg-3 my-3">
							<div class="address-vitals">
								<h5>{{ (in_array('phishing',$array_labels) ? '1' : '0')}}</h5>
								<h6>Phishing</h6>
							</div>
						</div>

						<div class="col-lg-3 my-3">
							<div class="address-vitals">
								<h5>{{ ( (in_array('ransom',$array_labels) || in_array('ransomware',$array_labels) ) ? '1' : '0')}}</h5>
								<h6>Ransom</h6>
							</div>
						</div>

						<div class="col-lg-3 my-4">
							<div class="address-vitals">
								<h5>{{ ($array_flip_count > 0) ? '1' : '0'}}</h5>
								<h6>Darknet Market</h6>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="coin-item my-3">
			<div class="d-flex justify-content-between align-items-center flex-column flex-md-row">
				<h3 class="fs-5 mb-md-0 mb-3">
					Transaction Time Analysis
					<i class="fa-regular fa-info-circle"></i>
				</h3>
			</div>
			<div class="row text-center">
				<div class="col-lg-12 my-3">
					<figure class="highcharts-figure">
						<div id="transaction_months_column_chart"></div>
					</figure>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="coin-item my-3">
			<div class="d-flex justify-content-between align-items-center flex-column flex-md-row">
				<h3 class="fs-5 mb-md-0 mb-3">
					Transaction Graph
					<i class="fa-regular fa-info-circle"></i>
				</h3>
			</div>
			{{-- <p class="text-secondary"><small><i class="fa-regular fa-lightbulb me-2"></i> Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque, quis.</small></p> --}}
			<div class="row justify-content-center align-items-center">
				<div class="col-lg-6 my-3">
					<button type="button" onclick="open_in_fullscreen()" class="btn btn-main-2 rounded-0 mb-3"><i class="fa-light fa-arrows-maximize"></i> View Fullscreen</button>
					<div class="text-center">
						<div id="highchart_transaction_network_graph"></div>						
					</div>
				</div>
				<div class="col-lg-6 my-3">
					<div class="bg-custom-light p-3 rounded-3">
						<form action="">
							<div class="row">
								@php
								$from_date = date('Y-m-d', strtotime($blockcypher['address_details']->first_seen_at));
								$to_date = date('Y-m-d', strtotime($blockcypher['address_details']->last_seen_at));
								@endphp
								<div class="col-lg-6 mb-3">
									<label for="from_date" class="form-label">Date Range:</label>
									<input type="date" name="from_date" id="from_date" class="form-control" min="{{$from_date}}" max="{{$to_date}}" value="{{$from_date}}">
								</div>
								<div class="col-lg-6 mb-3">
									<label for="to_date" class="form-label">To:</label>
									<input type="date" name="to_date" id="to_date" class="form-control" min="{{$from_date}}" max="{{$to_date}}" value="{{$to_date}}">
								</div>
							</div>
						</form>
					</div>
					<div class="bg-custom-light p-3 rounded-3 mt-3">
						<h3 class="fs-5">Analysis</h3>
						{{-- <div class="d-flex">
							<p class="text-truncate mb-0">qp3wjpa3tjlj042z2wv7hahsldgwhwy0rq9sywjpyy</p>
							<i class="fa-regular fa-copy mx-2 lh-26"></i>
							<span class="text-danger text-nowrap"><i class="fa-light fa-crosshairs text-danger"></i> Monitor</span>
						</div> --}}
						{{-- <form action="">
							<div class="row my-3">
								<div class="col-lg-12 mb-3">
									<div class="position-relative">
										<i class="fa-thin fa-magnifying-glass position-absolute start-0 top-50 translate-middle-y px-2"></i>
										<input type="text" name="" id="" class="form-control ps-4" placeholder="Search by address / label">
									</div>
								</div>
							</div>
						</form> --}}
						<div class="card">
							<div class="card-body" id="blockcypher-txn-senders">
								<!-- ajax -->
							</div>
						</div>
						<div class="card mt-3">
							<div class="card-body" id="blockcypher-txn-recipients">
								<!-- ajax -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="coin-item my-3">
			<div class="row text-center">
				<div class="col-lg-12 my-3">
					<figure class="highcharts-figure">
						<div id="highchart_network_graph"></div>
					</figure>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>		
</div>
</section>
<!---------  Flag Modal ----------->
<div class="modal fade custom-modal" id="flagModal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header section-home">
				<h4 class="modal-title fs-6">Report</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body bg-custom-light">
				<div class="coin-item mb-3">
					<div class="d-flex justify-content-between align-items-center flex-md-row flex-column">
						@if(!empty($chainsight->chain) && isset($blockcypher['address_details']->currency))           
						<img src="{{asset('assets/frontend/images/coins/'.$blockcypher['address_details']->currency.'.png')}}" alt="" class="me-md-3 me-auto ms-auto mb-md-0 mb-3 coin-symbol">
						@endif
						<div class="flex-grow-1 text-md-start text-center">
							@if(!empty($chainsight->address))
							<h3 class="text-break">{{$chainsight->address}}</h3>
							@endif
							<p class="mb-0"><small>@if($total_flag > 0) {{$total_flag}} Report @else No Report @endif</small></p>
						</div>
					</div>
				</div>

				<div class="form-wrap">                             
					<form action="{{route('flag')}}" method="POST" id="addressReport">
						@csrf
						<div class="row mb-3">
							<div class="col-lg-3">
								<label for="" class="form-label">Report: </label>
							</div>
							<div class="col-lg-9">
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="report_type" id="inlineRadio1" value="Phishing" checked>
									<label class="form-check-label" for="inlineRadio1">Phishing</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="report_type" id="inlineRadio2" value="Ransom">
									<label class="form-check-label" for="inlineRadio2">Ransom</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="report_type" id="inlineRadio3" value="Theft">
									<label class="form-check-label" for="inlineRadio3">Theft</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="report_type" id="inlineRadio4" value="Other">
									<label class="form-check-label" for="inlineRadio3">Other</label>
								</div>
								@error('report_type')
								<span class="invalid-feedback">{{$message}}</span>
								@enderror
							</div>
						</div>

						<div class="row mb-3">
							<div class="col-lg-3">
								<label for="" class="form-label">Description: </label>
							</div>
							<div class="col-lg-9">
								<textarea name="description" id="description" rows="5" class="form-control" placeholder="Please enter the desctiption"></textarea>
								@error('description')
								<span class="invalid-feedback">{{$message}}</span>
								@enderror
							</div>
							@if(!empty($chainsight->address))
							<input type="text" hidden name="address" value="{{$chainsight->address}}">
							@endif
							<input type="text" name="address_type" hidden value="{{(isset($blockcypher['address_details']->currency)) ? $blockcypher['address_details']->currency : ''}}">
						</div>

						<div class="row">
							<div class="col-lg-12 text-end">                                    
								<button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-main-2">Report</button>
							</div>
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
</div>
<div class="toast-container position-fixed bottom-0 end-0 p-3 ajax-alert-box d-none">
	<div class="toast align-items-center toster-bg border-0 fade show" role="alert" aria-live="assertive" aria-atomic="true">
		<div class="d-flex">
			<div class="toast-body toster-ajax-message">

			</div>
			<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
		</div>
	</div>
</div>
@include('frontend.layouts.partials.alert-message')
</main>
@endsection

@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\FlagRequest', '#addressReport'); !!}
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/networkgraph.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/modules/no-data-to-display.js"></script>
<script src="{{asset('assets/frontend/js/vis-network.min.js')}}"></script>

<!-- For AML risk score guage chart -->
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

<script type="text/javascript">
	var anti_fraud_credit = @json($chainsight->anti_fraud->credit);

	/* For aml risk score chart */
	if(anti_fraud_credit == 1){
		var aml_risk_score = 0.5;
	}else if(anti_fraud_credit == 2){
		var aml_risk_score = 1.5;
	}else{
		var aml_risk_score = 2.5;
	}
</script>

<script src="{{asset('assets/frontend/js/amchart-guage.js')}}"></script>


<script src="{{asset('assets/frontend/js/jquery.blockUI.js')}}"></script>


<script type="text/javascript">
	var network_graph_url = @json(route('blockchain-search.network-graph'));
	var blockcypher_txn_list_url = @json(route('blockchain-search.blockcypher-txn-list'));
	var transaction_network_graph_url = @json(route('blockchain-search.transaction-network-graph'));
	var blockcypher_txn_details = @json(route('blockchain-search.blockcypher-txn-details'));
	var keyword = @json($keyword);
	
</script>


<script type="text/javascript">
	$(document).ready(function(){

		$('#from_date, #to_date').on('change',function(){

			$('#to_date').attr('min', $('#from_date').val());
			$('#from_date').attr('max', $('#to_date').val());
			
			get_blockcypher_txn_list('senders');
			get_blockcypher_txn_list('recipients');
			get_transaction_network_graph_data();
		})

		$.ajax({
			headers: {
				'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
			},
			type: "get",
			url: network_graph_url+"?keyword="+keyword,
			success: function (result) {
				if(result.status == 'success'){
					draw_network_graph(result.network_graph_data);
				}else{
					draw_network_graph([]);
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				draw_network_graph([]);
			}
		});

		get_transaction_network_graph_data();
		
		$('.loader').on('click',function(){

			$('div.loader-div').block({
				message: '<h1 class="fs-7 mb-0">Processing</h1>',
			}); 
			setTimeout(function(){ $('div.loader-div').unblock() },2000)
		})

		$('#user_notes').on('focusout',function(){
			var user_notes = $('#user_notes').val();
			var address = $('.key_address').text();
			var coin = $('.coin_type').val();
			
			$.ajax({
				headers:{
					'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
				},
				url:"{{route('notes')}}",
				type:"POST",
				data:{user_notes:user_notes,address:address,coin:coin},
				success:function(result){
					$('.ajax-alert-box').removeClass('d-none');
					$('.toster-bg').addClass('show');      
					$('.toster-bg').addClass('text-bg-'+result.status);
					$('.toster-ajax-message').html(result.message);
				}
			});
		});

		draw_inout_transaction_pie_chart({{$blockcypher['address_details']->incoming_txn ?? 0}}, {{$blockcypher['address_details']->outgoing_txn ?? 0}});
		draw_transaction_months_column_chart({!! $blockcypher['monthly_txn_chart_data'] ?? '' !!});

		get_blockcypher_txn_list('senders');

		$(document).on('click', '#blockcypher-txn-senders .pagination a', function(event){
			event.preventDefault(); 
			var page = $(this).attr('href').split('page=')[1];

			get_blockcypher_txn_list('senders' ,page);

		});



		$(document).on('click', '#blockcypher-txn-detail .pagination a', function(event){
			event.preventDefault(); 
			var page = $(this).attr('href').split('page=')[1];
			var address = $('#current_searched_address').val();
			var type = $('#current_type').val();
			getTxnDetails(type,address,page,'true');
		});


		get_blockcypher_txn_list('recipients');

		$(document).on('click', '#blockcypher-txn-recipients .pagination a', function(event){
			event.preventDefault(); 
			var page = $(this).attr('href').split('page=')[1];

			get_blockcypher_txn_list('recipients' ,page);

		});

	});

	function open_in_fullscreen() {
		var elem = document.getElementById("highchart_transaction_network_graph");
		if (elem.requestFullscreen) {
			elem.requestFullscreen();
		} else if (elem.webkitRequestFullscreen) { /* Safari */
			elem.webkitRequestFullscreen();
		} else if (elem.msRequestFullscreen) { /* IE11 */
			elem.msRequestFullscreen();
		}

		// if (!document.mozFullScreen && !document.webkitFullScreen) { 
		// 	if (elem.mozRequestFullScreen) { 
		// 		elem.mozRequestFullScreen(); 
		// 	} else { 
		// 		elem.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT); 
		// 	} 
		// } else { 
		// 	if (document.mozCancelFullScreen) { 
		// 		document.mozCancelFullScreen(); 
		// 	} else { 
		// 		document.webkitCancelFullScreen();
		// 	} 
		// }
	}

	function btc_to_usd(){

		var or_balance = $('.currency-convert').attr('data-balance');

		var or_sent = $('.currency-send').attr('data-sent');

		var or_received = $('.currency-received').attr('data-received');

		$('div.loader-div').block({
			message: '<h1 class="fs-7 mb-0">Processing</h1>',
		}); 
		setTimeout(function(){ $('div.loader-div').unblock() },3000)

		$.getJSON( "https://api.coindesk.com/v1/bpi/currentprice/usd.json", 
			function( data) {
				var origBalance = parseFloat(or_balance);        
				var exchangeRate = parseInt(data.bpi.USD.rate_float);

				var origSent = parseFloat(or_sent);

				var origReceived = parseFloat(or_received);

				let balance_amount;
				let sent_amount;
				let receive_amount;

				balance_amount = parseFloat(origBalance * exchangeRate);
				
				sent_amount = parseFloat(origSent * exchangeRate);
				
				received_amount = parseFloat(origReceived * exchangeRate);
				
				$('.balance_amount').text('$'+balance_amount.toFixed(2));
				$('.total_sent').text('$'+sent_amount.toFixed(2));
				$('.total_received').text('$'+received_amount.toFixed(2));

			});
	}

	function eth_to_usd(){
		var balance = $('.currency-convert').attr('data-balance');

		var sent = $('.currency-send').attr('data-sent');

		var received = $('.currency-received').attr('data-received');

		$('div.loader-div').block({
			message: '<h1 class="fs-7 mb-0">Processing</h1>',
		}); 
		setTimeout(function(){ $('div.loader-div').unblock() },3000)

		$.getJSON("https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&ids=ethereum", 
			function( data) {

				var origBalance = parseFloat(balance);

				var origSent = parseFloat(sent);

				var orgReceived = parseFloat(received);

				var exchangeRate = parseInt(data[0].current_price);

				let amount;
				let total_sent;
				let total_received;

				amount = parseFloat(origBalance * exchangeRate);    
				var balance_amount = amount.toFixed(2);

				total_sent = parseFloat(origSent * exchangeRate);    
				var sent_amount = total_sent.toFixed(2);

				total_received = parseFloat(orgReceived * exchangeRate);    
				var receive_amount = total_received.toFixed(2);

				$('.balance_amount').text('$'+balance_amount);
				$('.total_sent').text('$'+sent_amount);
				$('.total_received').text('$'+receive_amount);

			});
	}

	function original_currency(type){
		
		var balance = $('.currency-convert').attr('data-balance');

		var sent = $('.currency-send').attr('data-sent');

		var received = $('.currency-received').attr('data-received');

		$('div.loader-div').block({
			message: '<h1 class="fs-7 mb-0">Processing</h1>',
		});
		setTimeout(function(){ $('div.loader-div').unblock() },2000)

		if(type=='eth'){

			$('.balance_amount').text(balance+' ETH');
			$('.total_sent').text(sent+' ETH');
			$('.total_received').text(received+' ETH');

		}else{

			$('.balance_amount').text(balance+' BTC');
			$('.total_sent').text(sent+' BTC');
			$('.total_received').text(received+' BTC');

		}
	}

	function draw_network_graph(network_graph_data){
		console.log(network_graph_data);
		Highcharts.addEvent(
			Highcharts.Series,
			'afterSetOptions',
			function (e) {
				var colors = Highcharts.getOptions().colors,
				i = 0,
				nodes = {};

				if (
					this instanceof Highcharts.Series.types.networkgraph &&
					e.options.id === 'lang-tree'
					) {
					e.options.data.forEach(function (link) {

						if (link[0] === 'Account') {
							nodes['Account'] = {
								id: 'Account',
								marker: {
									radius: 20
								}
							};
							nodes[link[1]] = {
								id: link[1],
								marker: {
									radius: 10
								},
								color: colors[i++]
							};
						} else if (nodes[link[0]] && nodes[link[0]].color) {
							nodes[link[1]] = {
								id: link[1],
								color: nodes[link[0]].color
							};
						}
					});

				e.options.nodes = Object.keys(nodes).map(function (id) {
					return nodes[id];
				});
			}
		}
		);

		Highcharts.chart('highchart_network_graph', {
			chart: {
				type: 'networkgraph',
				height: '100%',
				plotBackgroundImage: '{{asset('assets/frontend/images/logo-wm.png')}}',
			},
			credits: {
				text: 'Spyderlab',
				href: 'http://194.59.165.2/'
			},
			lang: {
				noData: "<i class='fa-light fa-ban'></i> No data to display"
			},
			title: {
				text: 'AML On-chain risk trace graph',
				align: 'left'
			},
			subtitle: {
				text: keyword,
				align: 'left'
			},
			plotOptions: {
				networkgraph: {
					keys: ['from', 'to'],
					layoutAlgorithm: {
						enableSimulation: true,
						friction: -0.9
					}
				}
			},
			series: [{
				accessibility: {
					enabled: false
				},
				dataLabels: {
					enabled: true,
					linkFormat: '',
					style: {
						fontSize: '0.8em',
						fontWeight: 'normal'
					}
				},
				id: 'lang-tree',
				data: network_graph_data
			}],
			exporting: {
				chartOptions: {
					plotOptions: {
						series: {
							dataLabels: {
								enabled: true
							}
						},
						networkgraph: {
							layoutAlgorithm: {
								enableSimulation: false,
							}
						}
					}
				}
			}
		});
	}

	function draw_inout_transaction_pie_chart(incoming_txn, outgoing_txn){
		Highcharts.chart('in_out_txn_pie_chart', {
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie',
				plotBackgroundImage: '{{asset('assets/frontend/images/logo-wm.png')}}',
			},
			title: {
				text: 'Incoming/Outgoing Transactions',
				align: 'center'
			},
			exporting: { enabled: false },
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			},
			accessibility: {
				point: {
					valueSuffix: '%'
				}
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: false
					},
					showInLegend: true
				}
			},
			series: [{
				name: 'Transactions',
				colorByPoint: true,
				data: [{
					name: 'Incoming',
					y: incoming_txn,
					sliced: true,
					selected: true
				},  {
					name: 'Outgoing',
					y: outgoing_txn
				}]
			}]
		});
	}

	function draw_transaction_months_column_chart(monthly_txn_chart_data){
		Highcharts.chart('transaction_months_column_chart', {
			chart: {
				type: 'column',
				plotBackgroundImage: '{{asset('assets/frontend/images/logo-wm.png')}}',
			},
			exporting: { enabled: false },
			title: {
				align: 'left',
				text: 'Monthly Transactions'
			},
			accessibility: {
				announceNewData: {
					enabled: true
				}
			},
			xAxis: {
				title: {
					text: 'Months'
				},
				type: 'category'
			},
			yAxis: {
				title: {
					text: 'No. Of Txn'
				}

			},
			legend: {
				enabled: false
			},
			plotOptions: {
				series: {
					borderWidth: 0,
					dataLabels: {
						enabled: true,
						format: '{point.y:f}'
					}
				}
			},

			tooltip: {
				pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:f}</b><br/>'
			},

			series: [
			{
				name: 'Months',
				data: monthly_txn_chart_data
			}
			]
		});
	}

	function get_blockcypher_txn_list(list_type, page){
		if(list_type == 'senders'){
			var ele_id = 'blockcypher-txn-senders';
		}else{
			var ele_id = 'blockcypher-txn-recipients';
		}

		$('#'+ele_id).block({
			message: '<h1 class="fs-7 mb-0">Loading...</h1>',
		});

		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();

		var url = blockcypher_txn_list_url+"?keyword="+keyword+'&list_type='+list_type+'&from_date='+from_date+'&to_date='+to_date;
		page = (typeof page == 'undefined')?'':'&page='+page;
		url = url + page;

		$.ajax({
			headers: {
				'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
			},
			type: "get",
			url: url,
			success: function (result) {
				$('#'+ele_id).html(result);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
			}
		});

		$('#'+ele_id).unblock();
	}

	function get_transaction_network_graph_data(){
		$('#highchart_transaction_network_graph').block({
			message: '<h1 class="fs-7 mb-0">Loading...</h1>',
		});

		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();

		$.ajax({
			headers: {
				'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
			},
			type: "get",
			url: transaction_network_graph_url+"?keyword="+keyword+'&from_date='+from_date+'&to_date='+to_date,
			success: function (result) {
				console.log(result);
				if(result.status == 'success'){
					draw_transaction_network_graph(result.data.nodes, result.data.edges);
				}else{
					draw_transaction_network_graph([]);
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				draw_transaction_network_graph([]);
			}
		});

		$('#highchart_transaction_network_graph').unblock();
	}

	function draw_transaction_network_graph(nodes, edges){
		$('#highchart_transaction_network_graph').block({
			message: '<h1 class="fs-7 mb-0">Loading...</h1>',
		});

		var nodes = new vis.DataSet(nodes);
		var edges = new vis.DataSet(edges);

		// create a network
		var container = document.getElementById("highchart_transaction_network_graph");
		var data = {
			nodes: nodes,
			edges: edges,
		};
		var options = {
			physics:{
				enabled:false,
			}
		};
		var network = new vis.Network(container, data, options);
		network.stabilize(100);

		$('#highchart_transaction_network_graph').unblock();
	}

	function getTxnDetails(type,address,page=null,funType=null){
		$('#transactionModal').modal('show');
		$('#current_searched_address').val(address);
		$('#current_type').val(type);
		
		var url = blockcypher_txn_details+"?keyword="+keyword+'&address='+address+'&type='+type;
		page = (typeof page == 'undefined')?'':'&page='+page;
		url = url + page;

		$.ajax({
			headers: {
				'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
			},
			type: "get",
			url: url,
			success: function (result){
				$('.txn-details').html(result);
			}
		});
	}
</script>


@endsection