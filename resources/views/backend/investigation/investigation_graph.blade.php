@extends('backend.layouts.app')
@section('styles')
<style>
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
		width: 450px;
		border: 1px solid lightgray;
		background-image: url("{{asset('assets/frontend/images/logo-wm.png')}}");
		background-repeat: no-repeat;
		background-size: 550px auto;
		background-position: center;
		background-color: #fff;
	}
	.address-analysis {
		font-size: 14px;
		position: relative;
		padding-left: 16px;
		margin-bottom: 0;
		margin-block: 4px;
	}
	.address-analysis::before{
		content: '';
		position: absolute;
		top: 50%;
		left: 0;
		transform: translateY(-50%);
		width: 6px;
		height: 6px;
		border-radius: 50%;
		display: block;
		background: #fff;
	}
	.address-info{
		margin-block: 12px;
	}
	.address-info h4{
		font-size: 12px;
		font-weight: 400;
		color: #d3d3d3;
		margin-bottom: 0;
		border-left: 2px solid #d3d3d3;
		padding-left: 6px;
		padding-block: 4px;
		background-color: #3e4649;
	}
	.address-info h5{
		font-size: 12px;
		font-weight: 400;
		border-left: 2px solid #fff;
		padding-left: 6px;
		padding-block: 4px;
		color: #fff;
		margin-bottom: 0;
		background-color: #49555b;
	}
	.coin-item .coin-symbol{
		width: 60px;
		height: 60px;
		border-radius: 50%;
	}
	.coin-item h2{
		font-size: 20px;
	}
	.coin-item h2 span{
		color: #8f8f8f;
		padding-left: 6px;
		border-left: 1px solid #8f8f8f;
	}
	.coin-item h3{
		font-size: 16px;
	}
	.coin-item h3 i{
		color: #8f8f8f;
	}
	.txn-address {
		max-width: 200px;
	}
	.gas-fee {
		max-width: 300px;
	}
	.address-vitals h5{
		font-size: 14px;
	}
	.address-vitals p{
		font-size: 12px;
		font-weight: 400;
		margin-bottom: 0;
	}
</style>
@endsection
@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active">Investigation</li>
			<li class="breadcrumb-item active">Graph</li>
		</ul>                    
	</div>
</div>
@include('backend.layouts.partials.alert-messages')
<!-- BEGIN #content -->
<div class="row">
	<div class="col-lg-8 col-md-12">
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="coin-item">
							<div class="d-flex justify-content-between align-items-center flex-md-row flex-column">
								@if(isset($currency))
								<img src="{{asset('assets/frontend/images/coins/'.$currency.'.png')}}" alt="" class="me-md-3 me-auto ms-auto mb-md-0 mb-3 coin-symbol">
								@endif
								<div class="flex-grow-1 text-md-start text-center">
									<h2>{{$currency}}</h2>
									<h3 class="text-break">
										<font class="top_address">{{$address}}</font>
										<a href="javascript:void(0)" onclick="copyToClipboard('.top_address')"><i class="fa-regular fa-copy mx-1"></i></a>
									</h3>
								</div>
							</div>
						</div>
					</div>
					<div class="card-arrow">
						<div class="card-arrow-top-left"></div>
						<div class="card-arrow-top-right"></div>
						<div class="card-arrow-bottom-left"></div>
						<div class="card-arrow-bottom-right"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-5 col-md-12 my-3">
				<div class="card">
					<div class="card-body">
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
					<div class="card-arrow">
						<div class="card-arrow-top-left"></div>
						<div class="card-arrow-top-right"></div>
						<div class="card-arrow-bottom-left"></div>
						<div class="card-arrow-bottom-right"></div>
					</div>
				</div>
			</div>

			<div class="col-lg-7 col-md-12 my-3">
				<div class="card loader-div">
					<div class="card-body">
						<div class="coin-item">
							<div class="d-flex justify-content-md-between justify-content-center flex-md-row flex-column text-md-start text-center">
								<div>
									<h3 class="d-inline-block mb-0">Overview</h3>
									<div class="btn-group btn-group-sm">

										@if($blockcypher['address_details']->currency == 'btc')
										<a class="btn btn-main-3 btn-sm" onclick="original_currency('btc')"><i class="fa-regular fa-bitcoin-sign"></i></a>
										<a onclick="btc_to_usd()" class="btn btn-main-3 btn-sm"><i class="fa-regular fa-dollar-sign"></i></a>
										@else
										<a class="btn btn-main-3 btn-sm" onclick="original_currency('eth')"><i class="fa-brands fa-ethereum"></i></a>
										<a onclick="eth_to_usd()" class="btn btn-main-3 btn-sm"><i class="fa-regular fa-dollar-sign"></i></a>
										@endif

									</div>
								</div>                                        
								<p class="fs-7 mb-0">Data Updated 1 min(s) ago <a href="#" class="custom-link loader"><i class="fa-regular fa-refresh"></i></a></p>
							</div>
							<div class="row mt-3">
								<div class="col-md-6">
									<div class="address-info">
										<h4>Balance</h4>
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
								<h5 class="balance_amount">{{$balance}}</h5>
								<div data-balance="{{$original_balance}}" class="d-none currency-convert"></div>
							</div>
							<div class="address-info">
								<h4>First Seen (UTC)</h4>
								<h5>{{gmdate('M d, Y, h:i A', strtotime($blockcypher['address_details']->first_seen_at))}}</h5>
							</div>
							<div class="address-info">
								<h4>Total Received</h4>
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
						<h5 class="total_received">{{$total_received}}</h5>
						<div data-received="{{$or_total_received}}" class="d-none currency-received"></div>
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
				<h5 class="total_sent">{{$total_sent}}</h5>
				<div data-sent="{{$or_total_sent}}" class="d-none currency-send"></div>
			</div>
			<div class="address-info">
				<h4>Outgoing Txn</h4>
				<h5>{{$blockcypher['address_details']->outgoing_txn}}</h5>
			</div>
		</div>
	</div>
</div>
</div>
<div class="card-arrow">
	<div class="card-arrow-top-left"></div>
	<div class="card-arrow-top-right"></div>
	<div class="card-arrow-bottom-left"></div>
	<div class="card-arrow-bottom-right"></div>
</div>
</div>
</div>

</div>
</div>
<div class="col-lg-4 col-md-12">
	<div class="card h-50">
		<div class="card-body">
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
		</div>
		<div class="card-arrow">
			<div class="card-arrow-top-left"></div>
			<div class="card-arrow-top-right"></div>
			<div class="card-arrow-bottom-left"></div>
			<div class="card-arrow-bottom-right"></div>
		</div>
	</div>
</div>
</div>
<div class="row mt-3">
	<div class="col-lg-12 col-md-12">
		<div class="card">
			<div class="card-body">
				<div class="coin-item my-3">
					<div class="d-flex justify-content-between align-items-center flex-column flex-md-row">
						<h3 class="fs-5 mb-md-0 mb-3">
							Transaction Graph
							<i class="fa-regular fa-info-circle"></i>
						</h3>
						{{--<a href="#" class="btn btn-dark btn-sm">New Investigation <span class="badge bg-danger">PRO</span></a>--}}
					</div>
					{{--<p class="text-secondary"><small><i class="fa-regular fa-lightbulb me-2"></i> Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque, quis.</small></p>--}}
					<!-- Chart Start -->
					<div class="row justify-content-center">
						<div class="col-lg-6 my-3">
							<div class="card">
								<div class="card-body">
									<button type="button" onclick="open_in_fullscreen_receiver()" class="btn btn-outline-success"><i class="fa-light fa-arrows-maximize"></i> View Fullscreen</button>
									<div class="text-center mt-3">
										<div id="receiver_container" class="receiver_tree_loader"></div>	
									</div>
									<div id="receiver_tree_graph_pagination">
									</div>
								</div>
								<div class="card-arrow">
									<div class="card-arrow-top-left"></div>
									<div class="card-arrow-top-right"></div>
									<div class="card-arrow-bottom-left"></div>
									<div class="card-arrow-bottom-right"></div>
								</div>
							</div>

							<div class="card mt-3">
								<div class="card-body">

									<button type="button" onclick="open_in_fullscreen_sender()" class="btn btn-outline-success"><i class="fa-light fa-arrows-maximize"></i>View Fullscreen</button>
									<div class="text-center mt-3">
										<div id="sender_container" class="sender_tree_loader"></div>
										<div id="sender_tree_graph_pagination">
										</div>
									</div>
								</div>
								<div class="card-arrow">
									<div class="card-arrow-top-left"></div>
									<div class="card-arrow-top-right"></div>
									<div class="card-arrow-bottom-left"></div>
									<div class="card-arrow-bottom-right"></div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 my-3">
							<div class="card mt-3">
								<div class="card-body">
									<h3 class="fs-5">Analysis of sender common transaction</h3>
									<div class="d-flex">
										<p class="text-truncate mb-0 key_address_sender">{{$address}}</p>
										<a href="javascript:void(0)" onclick="copyToClipboard('.key_address_sender')"><i class="fa-regular fa-copy mx-1"></i></a>
									</div>
									
									<div class="card mt-3">
										<div class="card-body" id="receiver_common_txn">
										</div>
										<div class="card-arrow">
											<div class="card-arrow-top-left"></div>
											<div class="card-arrow-top-right"></div>
											<div class="card-arrow-bottom-left"></div>
											<div class="card-arrow-bottom-right"></div>
										</div>
									</div>

									<h3 class="fs-5 mt-3">Analysis of recipient common transaction</h3>
									<div class="d-flex">
										<p class="text-truncate mb-0 key_address_receiver">{{$address}}</p>
										<a href="javascript:void(0)" onclick="copyToClipboard('.key_address_receiver')"><i class="fa-regular fa-copy mx-1"></i></a>
									</div>

									<div class="card mt-3">
										<div class="card-body" id="sender_common_txn">
											
										</div>
										<div class="card-arrow">
											<div class="card-arrow-top-left"></div>
											<div class="card-arrow-top-right"></div>
											<div class="card-arrow-bottom-left"></div>
											<div class="card-arrow-bottom-right"></div>
										</div>
									</div>
								</div>
								<div class="card-arrow">
									<div class="card-arrow-top-left"></div>
									<div class="card-arrow-top-right"></div>
									<div class="card-arrow-bottom-left"></div>
									<div class="card-arrow-bottom-right"></div>
								</div>
							</div>
						</div>
					</div>
				</div>                
			</div>
			<div class="card-arrow">
				<div class="card-arrow-top-left"></div>
				<div class="card-arrow-top-right"></div>
				<div class="card-arrow-bottom-left"></div>
				<div class="card-arrow-bottom-right"></div>
			</div>
		</div>
	</div>
</div>
<input type="text" id="updated_address" hidden="">
<!-- END #content -->
@section('scripts')

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/treemap.js"></script>
<script src="https://code.highcharts.com/modules/treegraph.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script type="text/javascript">

	var address = @json($address);
	var receiver_url = @json(route("backend.investigation.get-receiver-tree-graph"));
	var receiver_common_txn_url = @json(route("backend.investigation.get-receiver-common-txn"));
	var sender_url = @json(route("backend.investigation.get-sender-tree-graph"));
	var sender_common_txn_url = @json(route("backend.investigation.get-sender-common-txn"));

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
            		console.log(node.id);
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
			url = '{{route("backend.investigation.get-receiver-tree-graph")}}'+'?&keyword='+address;
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
        	toastr.error(response.message);
        }
    },
    error: function (error) {
    	console.error('Error fetching data:', error);
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
			url = '{{route("backend.investigation.get-sender-tree-graph")}}'+'?&keyword='+address;
		}

		$.ajax({
        // url:'{{route("backend.investigation.get-sender-tree-graph")}}',
        url:url,
        type: 'GET',
        success: function (response) {
        	//console.log(response);
            // inverse_tree_chart.series[0].setData(response);
            if(response.status == 'success'){
            //console.log(response);
            $('div.sender_tree_loader').unblock();
            sender_tree_chart.series[0].setData(response.data_sender);
            $('#sender_tree_graph_pagination').html(response.html);
            $('#updated_address').val(response.address);

            // console.log(response.data_receiver);
        }else{
        	toastr.error(response.message);
        		$('div.sender_tree_loader').unblock();
        }

    },
    error: function (error) {
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