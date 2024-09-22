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
/*	.cart_graph{
		border: 1px solid;
		border-color: #ddd
		}*/
		#receiver_container {
			height: 500px;
			width: auto;
			border: 1px solid lightgray;
			background-image: url("{{asset('assets/frontend/images/logo-wm.png')}}");
			background-repeat: no-repeat;
			background-size: 550px auto;
			background-position: center;
			background-color: #fff;
		}

		#sender_container{
			height: 500px;
			width: auto;
			border: 1px solid lightgray;
			background-image: url("{{asset('assets/frontend/images/logo-wm.png')}}");
			background-repeat: no-repeat;
			background-size: 550px auto;
			background-position: center;
			background-color: #fff;
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
													@if(!empty($currency))
													<img src="{{asset('assets/frontend/images/coins/'.strtolower($currency).'.png')}}" alt="" class="me-md-3 me-auto ms-auto mb-md-0 mb-3 coin-symbol">
													@endif
													<div class="flex-grow-1 text-md-start text-center">
														<h2 class="">{{isset($currency) ? $currency : ''}}</h2> 
														<h3 class="text-break">
															@if(!empty($address))
															<text class="key_address">{{$address}}</text>
															@endif
															<a href="javascript:void(0)" onclick="copyToClipboard('.key_address')"><i class="fa-regular fa-copy mx-1"></i></a>
															<a href="#" data-bs-toggle="modal" data-bs-target="#flagModal"></a>
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
												@if($credit == 1)
												<img src="{{asset('assets/frontend/images/icons/aml-safe.jpg')}}" alt="" class="mb-2">
												@elseif($credit == 2)
												<img src="{{asset('assets/frontend/images/icons/aml-risk.jpg')}}" alt="" class="mb-2">
												@elseif($credit == 3)
												<img src="{{asset('assets/frontend/images/icons/aml-warning.jpg')}}" alt="" class="mb-2">
												@endif
											</div>
										</div>

										<div class="col-lg-7 col-md-12 my-3">
											<div class="coin-item loader-div">
												<div class="d-flex justify-content-md-between justify-content-center flex-md-row flex-column text-md-start text-center">
													<div>
														<h3 class="d-inline-block mb-0">Overview</h3>
														<div class="btn-group rounded-pill overflow-hidden">

															@if(strtolower($currency)== 'btc')
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
			<div class="coin-item h-50">
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
		</div>

		<!--- Second Section ------->

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
					<div class="row justify-content-center alig-items-center">

						<div class="col-lg-6">
							<div class="cart_graph mt-3 p-3">
								<button type="button" onclick="open_in_fullscreen_receiver()" class="btn btn-main-2 rounded-0 mt-1"><i class="fa-light fa-arrows-maximize"></i> View Fullscreen</button>
								<div class="text-center mt-3">
									<div id="receiver_container" class="receiver_tree_loader"></div>	
								</div>
								<div id="receiver_tree_graph_pagination">
								</div>
							</div>
							<div class="cart_graph mt-3 p-3">
								<button type="button" onclick="open_in_fullscreen_sender()" class="btn btn-main-2 rounded-0 mt-1"><i class="fa-light fa-arrows-maximize"></i> View Fullscreen</button>
								<div class="text-center mt-3">
									<div id="sender_container" class="sender_tree_loader"></div>
								</div>
								<div id="sender_tree_graph_pagination">
								</div>
							</div>
						</div>

						<div class="col-lg-6 my-3">
							<div class="bg-custom-light p-3 rounded-3 mt-3">
								<h3 class="fs-5">Analysis of sender common transaction</h3>
								<div class="d-flex">

									<p class="text-truncate mb-0 key_address_sender">{{$address}}</p>
									<a href="javascript:void(0)" onclick="copyToClipboard('.key_address_sender')"><i class="fa-regular fa-copy mx-1"></i></a>
									
								</div>
								<div class="card">
									<div class="card-body" id="receiver_common_txn">
										<!-- ajax -->
									</div>
								</div>
								<h3 class="fs-5 mt-3">Analysis of recipient common transaction</h3>
								<div class="d-flex">
									<p class="text-truncate mb-0 key_address_receiver">{{$address}}</p>
									<a href="javascript:void(0)" onclick="copyToClipboard('.key_address_receiver')"><i class="fa-regular fa-copy mx-1"></i></a>
								</div>

								<div class="card mt-3">
									<div class="card-body" id="sender_common_txn">
										<!-- ajax -->
									</div>
								</div>
							</div>
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
<input type="text" id="updated_address" hidden="">
</main>

@section('scripts')

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/treemap.js"></script>
<script src="https://code.highcharts.com/modules/treegraph.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script type="text/javascript">

	var address = @json($address);
	var receiver_url = @json(route("investigation.get-receiver-tree-graph"));
	var receiver_common_txn_url = @json(route("investigation.get-receiver-common-txn"));
	var sender_url = @json(route("investigation.get-sender-tree-graph"));
	var sender_common_txn_url = @json(route("investigation.get-sender-common-txn"));

	$(document).ready(function(){

		getReceiverGraph(address);
		getSenderGraph(address);
		getReceiverCommonTxn(address);
		getSenderCommonTxn(address);

		$('.loader').on('click',function(){
			$('div.loader-div').block({
				message: '<p class="fs-7 mb-0 text-white">Processing</p>',
			}); 
			setTimeout(function(){ $('div.loader-div').unblock() },2000)
		})

		$(document).on('click', '#receiver_tree_graph_pagination .pagination a', function(event){
			event.preventDefault();

			var page = $(this).attr('href').split('page=')[1];
			url = receiver_url;

			if($('#updated_address').val()){
				var address = $('#updated_address').val();
			}else{
				var address = @json($address);
			}

			getReceiverGraph(address,url,page);
		});

		$(document).on('click', '#sender_tree_graph_pagination .pagination a', function(event){
			event.preventDefault(); 
			var page = $(this).attr('href').split('page=')[1];
			url = sender_url;

			if($('#updated_address').val()){
				var address = $('#updated_address').val();
			}else{
				var address = @json($address);
			}

			getSenderGraph(address,url,page);
		});

		$(document).on('click', '#receiver_common_txn .pagination a', function(event){
			event.preventDefault(); 
			var page = $(this).attr('href').split('page=')[1];
			getReceiverCommonTxn(address,page);
		});

		$(document).on('click', '#sender_common_txn .pagination a', function(event){
			event.preventDefault(); 
			var page = $(this).attr('href').split('page=')[1];
			getSenderCommonTxn(address,page);
		});

	});

	Highcharts.addEvent(Highcharts.seriesTypes.treegraph.prototype, 'click', function(proceed) {
		this.points.forEach(point => {
			point.toggleCollapse = function() {};
		});
	});

	var receiver_tree_chart = Highcharts.chart('receiver_container', {
		chart: {
			plotBackgroundImage: '{{asset('assets/frontend/images/logo-wm.png')}}',
			spacingBottom: 15,
			marginRight: 80
		},
		title: {
			text: null,
		},
		series: [
		{
			type: 'treegraph',
			allowDrillToNode: false,
			keys: ['parent', 'id', 'level'],
			clip: false,
			allowPointSelect: false,
            // data:data_receiver,
            collapseButton: {
            	enabled: false
            },
            showInLegend: false,
            events: {
            	click: function (event) {
            		var node = event.point;
            		// console.log(node.id);
            		getReceiverGraph(node.id);
            		getSenderGraph(node.id);
            	}
            },
            marker: {
            	symbol: "url({{asset('assets/frontend/images/arrow_right.png')}})"
            },
            dataLabels: {
            	align: 'left',
            	pointFormat: '{point.name}',
            	style: {
            		color: '#000000',
            		textOutline: '3px #ffffff',
            		whiteSpace: 'nowrap'
            	},
            	x: 26,
            	crop: false,
            	overflow: 'none'
            }
        }
        ]
    });

	/*--------------------------------*/

	var sender_tree_chart = Highcharts.chart('sender_container', {
		chart: {
			inverted: true,
    // height: 850,
    // width:850,
    plotBackgroundImage: '{{asset('assets/frontend/images/logo-wm.png')}}',
    spacingBottom: 30,
    marginRight: 0
},

title: {
	text: null,
},
series: [
{
	type: 'treegraph',
	allowDrillToNode: false,
	keys: ['parent', 'id', 'level'],
	clip: false,
	allowPointSelect: false,
            //data:data_sender,
            collapseButton: {
            	enabled: false
            },
            showInLegend: false,
            events: {
            	click: function (event) {
            		var node = event.point;
            		getReceiverGraph(node.id);
            		getSenderGraph(node.id);
            		console.log(node.id);
            	}
            },
            marker: {
            	symbol: "url({{asset('assets/frontend/images/arrow_right.png')}})"
            },
            dataLabels: {
            	align: 'left',
            	pointFormat: '{point.name}',
            	style: {
            		color: '#000000',
            		textOutline: '3px #ffffff',
            		whiteSpace: 'nowrap'
            	},
            	x: 24,
            	crop: false,
            	overflow: 'none'
            }
        }
        ]
    });

	function getReceiverGraph(address,url='',page=''){

		$('div.receiver_tree_loader').block({
			message: '<p class="fs-7 mb-0 text-white">Processing</p>',
		});

		if(url!='' && page!=''){
			url = url+'?&keyword='+address+'&page='+page;
		}else{
			url = '{{route("investigation.get-receiver-tree-graph")}}'+'?&keyword='+address;
		}
		
		$.ajax({
			url:url,
			type: 'GET',
			success: function (response) {
				if(response.status == 'success'){
					$('div.receiver_tree_loader').unblock();
					receiver_tree_chart.series[0].setData(response.data_receiver);
            //console.log(response.data_receiver);
            $('#updated_address').val(response.address);
            
            $('#receiver_tree_graph_pagination').html(response.html);
        }else{
        	$('div.receiver_tree_loader').unblock();
        	$('.toast-container').removeClass('d-none');
        	$('.toster-bg').addClass('bg-danger text-white');
        	$('.toster-ajax-message').html(response.message);
        	//toastr.error(response.message);
        }
    },
    error: function (error) {
    	console.error('Error fetching data:', error);
    	$('div.receiver_tree_loader').unblock();
    }
});
	}

	function getSenderGraph(address,url='',page=''){

		$('div.sender_tree_loader').block({
			message: '<p class="fs-7 mb-0 text-white">Processing</p>',
		});

		if(url!='' && page!=''){
			url = url+'?&keyword='+address+'&page='+page;
		}else{
			url = '{{route("investigation.get-sender-tree-graph")}}'+'?&keyword='+address;
		}

		$.ajax({
			url:url,
			type: 'GET',
			success: function (response) {
        	// console.log(response);
        	if(response.status == 'success'){
        		$('div.sender_tree_loader').unblock();
        		sender_tree_chart.series[0].setData(response.data_sender);
        		$('#sender_tree_graph_pagination').html(response.html);
        		$('#updated_address').val(response.address);
        	}else{
        		$('div.sender_tree_loader').unblock();
        		$('.toast-container').removeClass('d-none');
        		$('.toster-bg').addClass('bg-danger text-white');
        		$('.toast-container').removeClass('d-none');
        		$('.toster-ajax-message').html(response.message);
        	}

        },
        error: function (error) {
        	$('div.sender_tree_loader').unblock();
        	console.error('Error fetching data:', error);
        }
    });
	}

	function open_in_fullscreen_receiver() {
		var elem = document.getElementById("receiver_container");
		if (elem.requestFullscreen) {
			elem.requestFullscreen();
		} else if (elem.webkitRequestFullscreen) { /* Safari */
			elem.webkitRequestFullscreen();
		} else if (elem.msRequestFullscreen) { /* IE11 */
			elem.msRequestFullscreen();
		}
	}

	function open_in_fullscreen_sender() {
		var elem = document.getElementById("sender_container");
		if (elem.requestFullscreen) {
			elem.requestFullscreen();
		} else if (elem.webkitRequestFullscreen) { /* Safari */
			elem.webkitRequestFullscreen();
		} else if (elem.msRequestFullscreen) { /* IE11 */
			elem.msRequestFullscreen();
		}
	}

	function getReceiverCommonTxn(address,page=''){

		if(page!=''){
			url = receiver_common_txn_url+'?&address='+address+'&page='+page;
		}else{
			url = receiver_common_txn_url+'?&address='+address;
		}
		
		$.ajax({
			url:url,
			type: 'GET',
			success: function (response) {
				console.log(response);
				$('#receiver_common_txn').html(response);
			},
			error: function (error) {
				console.error('Error fetching data:', error);
			}
		});
	}

	function getSenderCommonTxn(address,page=''){

		if(page!=''){
			url = sender_common_txn_url+'?&address='+address+'&page='+page;
		}else{
			url = sender_common_txn_url+'?&address='+address;
		}
		
		$.ajax({
			url:url,
			type: 'GET',
			success: function (response) {
				console.log(response);
				$('#sender_common_txn').html(response);
			},
			error: function (error) {
				console.error('Error fetching data:', error);
			}
		});
	}

	function original_currency(type){
		
		var balance = $('.currency-convert').attr('data-balance');

		var sent = $('.currency-send').attr('data-sent');

		var received = $('.currency-received').attr('data-received');

		$('div.loader-div').block({
			message: '<p class="fs-7 mb-0 text-white">Processing</p>',
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

	function btc_to_usd(){

		var or_balance = $('.currency-convert').attr('data-balance');

		var or_sent = $('.currency-send').attr('data-sent');

		var or_received = $('.currency-received').attr('data-received');

		$('div.loader-div').block({
			message: '<p class="fs-7 mb-0 text-white">Processing</p>',
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
			message: '<p class="fs-7 mb-0 text-white">Processing</p>',
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
</script>
@endsection
@endsection