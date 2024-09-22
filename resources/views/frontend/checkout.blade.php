@extends('frontend.layouts.app')
@section('styles')
<style type="text/css">
	.error{
		width: 100%;
		margin-top: .25rem;
		font-size: .875em;
		color: #dc3545;
	}
</style>
@endsection
@section('content')
<section class="check-out py-5">
	<div class="container">
		<div class="cheak-out-heading-information text-center">
			<h2 class="cheak-out-heading">Make payment and activate your account</h2>
			<h6 class="cheak-out-description">Enjoy the service of Spyderlab AML </h6>
		</div>
		<div class="check-out-details py-3 mt-5">
			<div class="row">
				<div class="col-md-7">
					<form action="{{route('subscribe')}}" method="post" id="subscribe-form">
						@csrf
						<div class="check-out-card card p-4 mb-3">
							<h5 class="card-title">Choose Your Plan</h5>
							<div class="card-body">
								<label for="plan_name" class="form-label">Select Plan:</label>
								<select id="plan_name" name="plan_id" class="form-select mb-3" onchange="changePlan(this.value)">
									@foreach($crypto_plan as $plan)
									<option value="{{$plan->id}}" {{($record->id == $plan->id) ? 'selected' : ''}} >{{$plan->name}}</option>
									@endforeach
								</select>

								<label for="terms_in_month" class="form-label">Select Terms:</label>
								<select id="terms_in_month" name="terms_in_month" class="form-select mb-3" onchange="changeTerms(this.value)">
									<option value="1">1 month</option>
									<option value="3">3 month</option>
									<option value="6">6 month</option>
									<option value="12">1 year</option>
									<option value="24">2 year</option>
								</select>
							</div>
						</div>

						<div class="check-out-card card p-4 mb-3">
							<div class="gateway">
								<h5 class="card-title">Choose Payment Geteway</h5>
								<div class="card-body">
									<div class="row">

										<div class="col-md-6 gateway-container">
											<input type="radio" id="stripe" name="payment-gateway" value="stripe" onchange="getBitcoinAmount(this.value)" class="d-none">
											<label for="stripe" class="w-100">
												<div class="gateway-icon text-center align-items-center card mb-4"> 
													<img src="{{asset('assets/frontend/images/checkout-icon/stripe.png')}}" alt="Stripe">
												</div>
											</label>
										</div>

										<div class="col-md-6 gateway-container">
											<input type="radio" id="paypal" name="payment-gateway" value="paypal" onchange="getBitcoinAmount(this.value)" class="d-none">
											<label for="paypal" class="w-100">
												<div class="gateway-icon text-center align-items-center card mb-4">    
													<img src="{{asset('assets/frontend/images/checkout-icon/paypal.png')}}" alt="PayPal">                                          
												</div>
											</label>
										</div>
									</div>
								</div>
							</div>
							<hr>
							<div class="coins">
								<h5 class="card-title">Crypto Coins</h5>
								<div class="card-body">
									<div class="row justify-content-center align-items-center">
										
										<div class="col-lg-6 coins-container">
											<input type="radio" id="bitcoin" name="payment-gateway" value="btc" class="d-none" onchange="getBitcoinAmount(this.value)">
											<label for="bitcoin" class="w-100">
												<div class="coins-card card mb-3"> 
													<div class="d-flex">
														<img src="{{asset('assets/frontend/images/checkout-icon/bitcoin.png')}}"  alt="bitcoin">
														<span class="coin-name">Bitcoin</span>
													</div>      
												</div>
											</label>
										</div>

										<div class="col-lg-4 coins-container">
											<input type="radio" id="ethereum" name="payment-gateway" value="eth" class="d-none" onchange="getBitcoinAmount(this.value)">
											<label for="ethereum" class="w-100">
												<div class="coins-card card mb-3">  
													<div class="d-flex">           
														<img src="{{asset('assets/frontend/images/checkout-icon/ethereum.png')}}" alt="ethereum" >
														<span class="coin-name">ethereum</span>     
													</div>                                        
												</div>
											</label>
										</div>
										{{--<div class="col-lg-4 coins-container">
											<input type="radio" id="monero" name="payment-gateway" value="monero" class="d-none">
											<label for="monero" class="w-100">
												<div class="coins-card card mb-3">
													<div class="d-flex"> 
														<img src="{{asset('assets/frontend/images/checkout-icon/monero.png')}}" alt="monero">
														<span class="coin-name">Monero</span> 
													</div>                                              
												</div>
											</label>
										</div>
										<div class="col-lg-4 coins-container">
											<input type="radio" id="litecoin" name="payment-gateway" value="litecoin" class="d-none">
											<label for="litecoin" class="w-100">
												<div class="coins-card card mb-3">
													<div class="d-flex"> 
														<img src="{{asset('assets/frontend/images/checkout-icon/litecoin.png')}}" alt="litecoin">
														<span class="coin-name">Litecoin</span>
													</div>
												</div>
											</label>
										</div>--}}
									</div>
								</div>
							</div>
						</div>
						<div class="check-out-card card p-4 mb-3">
							<h6 class="card-title">Choose Your Plan</h6>
							<div class="card-body">
								<div class="d-flex justify-content-between plan-amount">
									<p>Plan Amount</p>
									<span class="plan_amount">$ {{$record->monthly_price ?? ''}}</span>
								</div>
								<div class="d-flex justify-content-between coupon-discount">
									<p>Discount</p>
									<span class="discount_amount">$ 0</span>
								</div>
								<div class="d-flex justify-content-between my-amount">
									<p>Your Pay</p>
									<span class="payable_amount">$ {{$record->monthly_price ?? ''}}</span>
								</div>
							</div>
						</div>
						<div class="check-out-btn-card">
							<button type="submit" class="btn btn-success check-out-btn w-100">Let,s go Started</button>
						</div>
						<p class="terms-of-use">Lorem ipsum dolor sit amet <strong><a href="{{route('privacy-policy')}}" target="_blank">Terms of Use</a> & <a href="{{route('terms-of-service')}}" target="_blank">Privacy Policy</a></strong></p>
					</form>
				</div>
				<div class="col-md-5">
					<div class="plan-advanteges">
						<div class="advantages-box card mb-2 p-3">
							<div class="d-flex">
								<img src="{{asset('assets/frontend/images/checkout-icon/money.png')}}">
								<div class="card-body">
									<div class="advantages-information">
										<h4 class="card-title">We offer full transparency services</h4>
										{{--<h6 class="card-text"></h6>--}}
									</div>
								</div>
							</div>
						</div>
						<div class="advantages-box card d-flex mb-2 p-3">
							<div class="d-flex">
								<img src="{{asset('assets/frontend/images/checkout-icon/instant.png')}}">
								<div class="card-body">
									<div class="advantages-information">
										<h4 class="card-title">Crypto and fiat payments options</h4>
										{{--<h6 class="card-text">  </h6>--}}
									</div>
								</div>
							</div>
						</div>
						<div class="advantages-box card d-flex mb-2 p-3">
							<div class="d-flex">
								<img src="{{asset('assets/frontend/images/checkout-icon/protect.png')}}">
								<div class="card-body">
									<div class="advantages-information">
										<h4 class="card-title">Life time Money Guarantee</h4>
										{{--<h6 class="card-text">Money back guarantee</h6>--}}
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

@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\ContactUsRequest', '#contact-form'); !!}
<script type="text/javascript">

	function getAmountSummery(plan_id = null,months = null,coin_type = null){
        $.blockUI({ message: 'Please wait...' });
		$.ajax({
			headers:{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			},
			url:'{{route("get-amount-summery")}}',
			method:'post',
			data:{plan_id:plan_id,months:months,coin_type:coin_type},
			success:function(data){
				if(data.status == 'success'){
					$('.plan_amount').html(data.message.total_amount);
					$('.discount_amount').html(data.message.discount_amount);
					$('.payable_amount').html(data.message.total_payable_amount);
					$.unblockUI();
				}else{
					toastr.error(data.message);
					$.unblockUI();
				}
			}
		});
	}

	function changeTerms(months){
		var plan_id = $('#plan_name').val();
		getAmountSummery(plan_id,months);
	}

	function changePlan(plan_id){
		var months = $('#terms_in_month').val();
		getAmountSummery(plan_id,months);
	}

	function getBitcoinAmount(val){
		var plan_id = $('#plan_name').val();
		var months = $('#terms_in_month').val();
		getAmountSummery(plan_id,months,val);
	}

</script>
@endsection