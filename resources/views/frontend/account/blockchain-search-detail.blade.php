@extends('frontend.layouts.account_app')

@section('styles')
<style type="text/css">
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
	#blockcypher-txn-senders{
        height:500px;
	}
	#blockcypher-txn-recipients{
        height:500px;
	}
	.alm_report{
		font-size:15px;
	}
</style>
@endsection

@section('title')  
<title>{{config('app.name')}} - Blockchain Search Detail</title>
@endsection

@section('content')
<!-- main content -->
<div id="content" class="collapsed">
	<div class="main-content">
		<div class="container">
			<div class="crypto-details py-4">
				<div class="col-md-12">
					<div class="card crypto-details-heading">
						<div class="heading d-flex py-3 px-3">
							 <h2><img src="{{asset('assets/account/images/icons/crypto-tracking.svg')}}" height="40" class="px-2">Details</h2>
						</div>
					</div>
				</div>
				<div class="details">
					<div class="row">

						<div class="col-md-8">
							<div class="card card-btc py-4 px-3">
								<div class="row">
									<div class="col-md-2 px-2">
										@if(!empty($chainsight->chain) && isset($blockcypher['address_details']->currency))
										<img src="{{asset('assets/frontend/images/coins/'.$blockcypher['address_details']->currency.'.png')}}">
										@endif
									</div>

									<div class="col-md-10">
										<div class="btc-information py-2">
											<h3>{{isset($blockcypher['address_details']->currency) ? strtoupper($blockcypher['address_details']->currency) : ''}}</h3>

											@if(!empty($chainsight->address))

											<h5><text class="key_address">{{$chainsight->address}}</text> 	<a href="javascript:void(0)" onclick="copyToClipboard('.key_address')"><i class="text-black fa-solid fa-copy fa-1x mx-2"></i></a>
												<span data-bs-toggle="modal" data-bs-target="#flagModal"><i class="fa-solid fa-flag mx-1"></i></span>
											</h5>

											@endif
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-4">
							<div class="card card-ai-detect py-3 px-1 align-items-center">
							<h3> <img src="{{asset('assets/account//images/icons/ai-spyder.svg')}}" class="px-2">Spyderlab AI detect</h3>

								@if(count($new_array_labels)>0)
								<h5 class="mb-2">This account is related to</h5>
								<div class="justify-content-center">
									@foreach($new_array_labels as $key=>$labelsData)
									<span class="badge rounded-pill bg-danger">{{ $labelsData }}</span>
									@endforeach
								</div>
								@else
								<div class="text-center">
									<img src="{{asset('assets/frontend_new/image/frown.png')}}" alt="" class="mb-2 coin-symbol">
									<h5>Not Found</h5>
								</div>
								@endif
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<div class="card aml-risk-score py-3 px-1 align-items-center">
								<h3>AML Risk Score<img src="{{asset('assets/account/images/icons/aml-score.svg')}}" height="30" class="px-2"></h3>	
								<div id="aml-risk-score-chart"></div>
							    
							    <span class="alm_report">
                                 Download AML Report
								<a href="{{route('blockchain-search').'?keyword='.$keyword.'&result_no='.$result_no.'&download-report=true'}}">
								<i class="fa-solid fa-download text-danger"></i>
								</a>							    	
							    </span>

                          {{--<div class="score-grap">
                              <img src="{{asset('assets/account/images/score.png')}} ">
                            </div>--}}
							</div>
						</div>
						<div class="col-md-5">
							<div class="card crypto-overview py-3 px-3">
								<div class="crypto-overview-heading d-flex justify-content-md-between justify-content-center flex-md-row flex-column text-md-start text-center">
									<h3>Overview</h3>
									<div class="btn-group rounded-pill">

										@if($blockcypher['address_details']->currency == 'btc')
										<a class="btn btn-main-3 btn-sm" onclick="original_currency('btc')"><i class="fa-solid fa-bitcoin-sign"></i></a>

										<a onclick="btc_to_usd()" class="btn btn-main-3 btn-sm"><i class="fa-solid fa-dollar"></i></a>
										@else
										<a class="btn btn-main-3 btn-sm" onclick="original_currency('eth')"><i class="fa-brands fa-ethereum"></i></a>

										<a onclick="eth_to_usd()" class="btn btn-main-3 btn-sm"><i class="fa-solid fa-dollar"></i></a>
										@endif

									</div>
									<p>Data Updated 1 min(s) ago <i class="fa-solid fa-arrows-rotate mx-2"></i></p>
								</div>

								<div class="row py-2 loader-div">
									@if(isset($blockcypher['address_details']))
									<div class="col-md-6">
										<div class="address-info">

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


									<h4>Balance</h4>
									<h5> <font class="balance_amount">{{$balance}}</font>
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
@if(Auth::user())
<div class="col-md-4">
	<div class="card crypto-favorites py-3 px-3">
		<h3><img src="{{asset('assets/frontend/images/icons/favourite-anim.svg')}}" height="40">Favorites</h3>
	

		<form class="py-4">
			<label for="" class="form-label">Private Note: </label>
			<textarea name="user_notes" id="user_notes" rows="10" class="form-control" placeholder="Adding Note Here">{!! $user_notes !!}</textarea>
			<input type="text" name="coin_type" class="coin_type" hidden value="{{(isset($blockcypher['address_details']->currency)) ? $blockcypher['address_details']->currency : ''}}">
			<div class="form-text">* Only you can see this note</div>
		</form>

	</div>
</div>
@endif
</div>

<!-- Tranaction Action Analysis -->
<div class="col-md-12">
	<div class="card Tranaction-Action-Analysis px-3 py-3">
		<div class="heading-Tranaction-Action-Analysis">
			<h3><img src="{{asset('assets/account/images/icons/transaction-action.svg')}}" height="50" class="px-2">Transaction Action Analysis</h3>
		</div>
		<div class="graph-Tranaction-Action-Analysis">
			<figure class="highcharts-figure">
				<div id="in_out_txn_pie_chart"></div>
			</figure>
		</div>
	</div>
</div>

<div class="col-md-12">
	<div class="card Address-Profile-Analysis px-3 py-3">
		<div class="heading-Address-Profile-Analysis">
<h3><img src="{{asset('assets/account/images/icons/address-profile.svg')}}" height="40" class="px-2">Address Profile Analysis</h3>

			<div class="address-analysis">
				<h5  id="add_profile_analisis">{{$chainsight->address}}

					<a href="javascript:void(0)" onclick="copyToClipboard('#add_profile_analisis')" class="text-secondary"><i class="fa-solid fa-copy fa-1x mx-2"></i></a></h5>
				</div>
			</div>
			<div class="related-events align-items-center text-center">
				<h4 class="py-2"><i class="fa-solid fa-route mx-2 rounded-circle"></i>Related Events</h4>
				<div class="row align-items-center justify-content-center py-3">
					<div class="col-md-3">
						<div class="vital-address">
							<h5>{{ (in_array('theft',$array_labels) ? '1' : '0')}}</h5>
							<h4>Thef</h4>
						</div>

					</div>
					<div class="col-md-3">
						<div class="vital-address">
							<h5>{{ (in_array('phishing',$array_labels) ? '1' : '0')}}</h5>
							<h4>Phishing</h4>
						</div>
					</div>
					<div class="col-md-3">
						<div class="vital-address">
							<h5>{{ ( (in_array('ransom',$array_labels) || in_array('ransomware',$array_labels) ) ? '1' : '0')}}</h5>
							<h4>Ransom</h4>

						</div>
					</div>
					<div class="col-md-3">
						<div class="vital-address">
							<h5>{{ ($array_flip_count > 0) ? '1' : '0'}}</h5>
							<h4>Darknet Market</h4>

						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

	<div class="col-md-12">
		<div class="card Transaction-Time-Analysis px-3 py-3">
			<div class="heading-Transaction-Time-Analysis">
            <h3><img src="{{asset('assets/account/images/icons/transaction-time.svg')}}" height="40" class="px-2">Transaction Time Analysis</h3>

				<div class="Time-Analysis text-center">

					<figure class="highcharts-figure">
						<div id="transaction_months_column_chart"></div>
					</figure>

				</div>
			</div>
		</div>
	</div>

	<div class="col-md-12">
		<div class="card Transaction Graph px-3 py-3">
			<div class="Transaction-Graph-heading">
				<h3><img src="{{asset('assets/account/images/icons/transaction-graph.svg')}}" height="35" class="px-2">Transaction Graph</h3>
			</div>
			<div class="row">

				<div class="col-md-6">
					<div class="graph-information">
						<button class="btn btn-view-screen" onclick="open_in_fullscreen()">View Fullscreen</button>
						    <div class="graph my-3">
							<div id="highchart_transaction_network_graph"></div>
						   </div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="card Transaction-form px-4 py-4">
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
					<div class="card analysis-table px-4 py-4">
						<h4>Analysis</h4>
						<div class="card analysis-table-details px-2 py-3" id="blockcypher-txn-senders">
							<!-- ajax -->
						</div>

						<div class="card analysis-table-details px-2 py-3" id="blockcypher-txn-recipients">

						</div>
					</div>

				</div>
			</div>
		</div>
	</div>


	<div class="col-md-12">
		<div class="card py-3 px-2">
			<div class="aml-trace-risk-heading">
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


<!-- Modal -->
<div class="modal fade" id="flagModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
		 
		<h5 class="modal-title" id="exampleModalLabel">Report</h5>
        <span data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-close fa-2x"></i></span>
			</div>
			<div class="modal-body">

				<div class="card card-title-coin-modal py-2 px-2">
					<div class="coin-item mb-3 py-2">
						<div class="d-flex justify-content-between align-items-center flex-md-row flex-column">
							@if(!empty($chainsight->chain) && isset($blockcypher['address_details']->currency)) 

							<img src="{{asset('assets/frontend/images/coins/'.$blockcypher['address_details']->currency.'.png')}}" alt="" class="me-md-3 me-auto ms-auto mb-md-0 mb-3 coin-symbol">
							@endif

							<div class="flex-grow-1 text-md-start text-center">
								@if(!empty($chainsight->address))
								<h3 class="text-break">{{$chainsight->address}}</h3>
								@endif
								<h4 class="mb-0"><small>@if($total_flag > 0) {{$total_flag}} Report @else No Report @endif</small></h4>
							</div>
						</div>
					</div>
				</div>

				<div class="card card-body-coin-modal py-2 px-2">

					<div class="form-wrap px-3 py-3">                             

						<form action="{{route('flag')}}" method="POST" id="addressReport">
							@csrf
							<div class="row mb-3">
								<div class="col-lg-3">
									<label for="" class="form-label">Report: </label>
								</div>

								<div class="col-lg-9">
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="report_type" id="inlineRadio1" value="Phishing" checked="">
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

									<textarea name="description" id="description" rows="9" class="form-control" placeholder="Please enter the desctiption"></textarea>
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
									<button type="submit" class="btn btn-primary">Report</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3 ajax-alert-box d-none" style="z-index: 1100;top:88%;left: 72%;">
    <div id="successToast" class="toast align-items-center text-white toster-bg border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
               <div class="toast-body toster-ajax-message">

			   </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\FlagRequest', '#addressReport'); !!}

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/networkgraph.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/modules/no-data-to-display.js"></script>
<script src="{{asset('assets/frontend/js/vis-network.min.js')}}"></script>

<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>


<script type="text/javascript">
	var network_graph_url = @json(route('blockchain-search.network-graph'));
	var blockcypher_txn_list_url = @json(route('blockchain-search.blockcypher-txn-list'));
	var transaction_network_graph_url = @json(route('blockchain-search.transaction-network-graph'));
	var blockcypher_txn_details = @json(route('blockchain-search.blockcypher-txn-details'));
	var keyword = @json($keyword);
	var anti_fraud_credit = @json($chainsight->anti_fraud->credit);

	/* For aml risk score chart */
	if(anti_fraud_credit == 1){
		var aml_risk_score = 0.5;
	}else if(anti_fraud_credit == 2){
		var aml_risk_score = 1.5;
	}else{
		var aml_risk_score = 2.5;
	}

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
				message: '<h3 class="fs-7 mb-0">Processing</h3>',
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
					$('.toster-bg').addClass('bg-'+result.status);
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
        //  if (elem.mozRequestFullScreen) { 
        //      elem.mozRequestFullScreen(); 
        //  } else { 
        //      elem.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT); 
        //  } 
        // } else { 
        //  if (document.mozCancelFullScreen) { 
        //      document.mozCancelFullScreen(); 
        //  } else { 
        //      document.webkitCancelFullScreen();
        //  } 
        // }
    }

    function btc_to_usd(){

    	var or_balance = $('.currency-convert').attr('data-balance');

    	var or_sent = $('.currency-send').attr('data-sent');

    	var or_received = $('.currency-received').attr('data-received');

    	$('div.loader-div').block({
    		message: '<h3 class="fs-7 mb-0">Processing</h3>',
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
    		message: '<h3 class="fs-7 mb-0">Processing</h3>',
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
    		message: '<h3 class="fs-7 mb-0">Processing</h3>',
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
    			href: 'https://www.spyderlab.org/'
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
    		credits: {
    			text: 'Spyderlab',
    			href: 'https://www.spyderlab.org/'
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
    		credits: {
    			text: 'Spyderlab',
    			href: 'https://www.spyderlab.org/'
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
    		message: '<h3 class="fs-7 mb-0">Loading...</h3>',
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
    			$('#'+ele_id).unblock();
    		},
    		error: function (jqXHR, textStatus, errorThrown) {
    		
    		}
    	});

    }

    function get_transaction_network_graph_data(){
    	$('#highchart_transaction_network_graph').block({
    		message: '<h3 class="fs-7 mb-0">Loading...</h3>',
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
<script src="{{asset('assets/account/js/amchart-guage.js')}}"></script>
@endsection