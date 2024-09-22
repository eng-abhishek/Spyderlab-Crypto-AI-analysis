@extends('frontend.layouts.account_app')

@section('title')  
<title>{{config('app.name')}} - Crypto Analysis</title>
@endsection

@section('styles')
<style>
	.coin-icon-h-50{
		height:40px;
	}
</style>
@endsection
@section('content')
<div id="content" class="collapsed">
	<div class="main-content">
		<div class="container">
			<div class="crypto-analysis">
				<div class="col-md-12">
					<div class="card heading-crypto">
						<div class="heading2">
                         <div class="d-flex py-2">
							<img src="{{asset('assets/account/images/icons/Crypto-analysis.svg')}}" height="40" class="px-2">
							<h3>Crypto Analysis</h3>
							</div>
							@include('frontend.layouts.partials.expiry-alert')
						</div>

					</div>
				</div>
				<div class="tracking">
					<div class="col-md-12">
						<div class="card">
							<div class="search">
								<h4>Risk Analysis, Intelligent Tracking</h4>
								<form action="{{urlencode(route('blockchain-search'))}}" method="GET" class="address-search-form">
									<div class="search-bar d-flex">
										<input type="search" name="keyword" placeholder="Search By Address/ENS/TxnHash" class="keyword"><button class="text" type="submit" class="btn btn-primary">search</button>
									</div>
								</form>
								<h5><img src="{{asset('assets/account/images/icons/Recent-Hot-Event.svg')}}" height="30">Recent Hot Event</h5>
							</div>
						</div>
					</div>
				</div>
				<div class="investigation-favorites">
					<div class="row">
						<div class="col-md-6">
							<div class="card">
								<div class="favourite px-4 py-4">
									<div class="row align-item-center border-bottom pb-3 mb-2 favourite-heading">
										<div class="col-md-6">
											<h3><img src="{{asset('assets/account/images/icons/favourite-anim.svg')}}" height="30">Favorites</h3>
										</div>
										<div class="col-md-6 text-end">
											<a href="{{route('favorites')}}"><button type="button" class="btn btn-success btn-sm btn-favourite">More</button></a>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="table-responsive">
												
												<table>
													<tr>
														<th>Wallet Address</th>
														<th>Note</th>
													</tr>

													@php
													$i=0;
													@endphp
													@forelse($fevourits as $fevourits_data)

													<tr>
														<td data-bs-toggle="tooltip" data-bs-placement="top" title="{{$fevourits_data->address ?? ''}}">
															{{ \Illuminate\Support\Str::limit($fevourits_data->address ?? '', 15, $end='...')}}
														</td>
														

														<td data-bs-toggle="tooltip" data-bs-placement="top" title="{{$fevourits_data->description ?? ''}}">
															{{ \Illuminate\Support\Str::limit($fevourits_data->description ?? '', 15, $end='...')}}

														</td>
													</tr>

													@php
													$i++;
													@endphp
													@empty

													<tr>
														<td colspan="2">Not record found.</td>
													</tr>
													@endforelse

												</table>

											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="card">
								<div class="investigation px-4 py-4">
									<div class="row align-item-center border-bottom pb-3 mb-2 investigation-heading">
										<div class="col-md-6">
											<h3><img src="{{asset('assets/account/images/icons/invest.svg')}}" height="35" class="px-2"> Investigation</h3>

										</div>
										<div class="col-md-6 text-end">
											<a href="{{route('investigation.index')}}"><button type="button" class="btn btn-success btn-sm">More</button></a>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="table-responsive">
												<table>
													<tr>
														<th>Wallet Address</th>
														<th>Created At (UTC)</th>
														<th>Note</th>
													</tr>
													@php
													$j=0;
													@endphp
													@forelse($investigation as $investigation_data)
													
													<tr>
														<td data-bs-toggle="tooltip" data-bs-placement="top" title="{{$investigation_data->address ?? ''}}">{{\Illuminate\Support\Str::limit($investigation_data->address ?? '', 15, $end='...') }}</td>
														<td>{{$investigation_data->created_at ?? ''}}</td>
														<td  data-bs-toggle="tooltip" data-bs-placement="top" title="{{$investigation_data->description ?? ''}}">{{ \Illuminate\Support\Str::limit($investigation_data->description ?? '', 15, $end='...')}}</td>
													</tr>
													
													@php
													$j++;
													@endphp
													@empty

													<tr>
														<td colspan="3">Not record found.</td>
													</tr>
													@endforelse

												</table>
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="unread-alert">
					<div class="col-md-12">
						<div class="card">
							<div class="unread-alert-information py-3 px-3">
								<div class="row align-item-center border-bottom pb-3 mb-2 unread-alert-heading">
									<div class="col-md-6">
										<h3><img src="{{asset('assets/account/images/icons/unread-alert.svg')}}" height="30"> Unread Alert(s)</h3>
									</div>
									<div class="col-md-6 text-end">
										<a href="{{route('alerts')}}"><button type="button" class="btn btn-success btn-sm">More</button></a>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class=table-responsive>
											<table>
												<tr>
													<th>Token</th>
													<th>Time(UTC)</th>
													<th>Txn Has</th>
													<th>Sender - Recipient</th>
													<th>Amount</th>
													<th>TXID</th>
												</tr>
												
												@forelse($alerts as $alerts_data)
												<tr>
													<td>
														<div class="d-flex align-items-center">
															<img src="{{asset('assets/frontend/images/coins/'.strtolower($alerts_data->token ?? '').'.png')}}" alt="{{$alerts_data->token ?? ''}}" class="me-1 coin-sm coin-icon-h-50">
															<span class="lh-1">{{$alerts_data->token ?? ''}}</span>
														</div>
													</td>

													<td>{{$alerts_data->created_at ?? ''}}</td>
													
													<td class="mb-0 text-truncate txn-address" data-bs-toggle="tooltip" data-bs-original-title="{{$alerts_data->txn_has ?? ''}}">{{ \Illuminate\Support\Str::limit($alerts_data->txn_has ?? '', 15, $end='...')}}</td>

													<td class="mb-0 text-truncate txn-address" data-bs-toggle="tooltip" data-bs-original-title="{{$alerts_data->address ?? ''}}">{{ \Illuminate\Support\Str::limit($alerts_data->address ?? '', 15, $end='...')}}</td>

													<td>{{$alerts_data->txn_amount ?? ''}}</td>
													
													<td class="mb-0 text-truncate txn-address" data-bs-toggle="tooltip" data-bs-original-title="{{$alerts_data->txn_id ?? ''}}">{{ \Illuminate\Support\Str::limit($alerts_data->txn_id ?? '', 15, $end='...')}}</td>
													
												</tr>    
												@empty
												<tr>
													<td colspan="6">Not record found.</td>
												</tr>
												@endforelse
											</table>
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
@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\ContactUsRequest', '#contact-form'); !!}
<script type="text/javascript">

	var auth = @json(route('is-authenticated'));
	var id = @json((Auth()->user() != null) ? Auth()->user()->id : '');
	var url = @json((route('blockchain-search')));

	$('.address-search-form').on('submit',function(){
		$.ajax({
			headers:{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			},
			url:auth,
			method:'get',
			success:function(data){
				var keyword = $('.keyword').val();
				var newUrl = url+'?keyword='+keyword;
				location.href = newUrl;
			}
		});    
		return false;
	})

</script>
@endsection