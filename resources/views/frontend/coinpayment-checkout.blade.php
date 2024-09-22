@extends('frontend.layouts.app')
@section('content')
<section class="check-out py-5">
	<div class="container">
		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-sm-8">
				<section class="crypto-checkout py-5">
					<div class="container">
						<h4 class="crypto-checkout-heading py-2">Checkout</h4>
						<div class="crypto-checkout-details justify-content-center align-items-center">
							@if($coinpayment_status == 'pending')
							<div class="crypto-checkout-warp">
								<div class="crypto-qr py-3">
									<div class="row">
										<div class="col-lg-12">
											<div class="text-center">
												<img src="{{$transaction->coinpayment_qrcode_url}}" alt="" class="img-fluid payment-qr">
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3 py-3">
										<p class="small text-muted lh-1 pb-2 mb-0">Amount Remaining</p>
										@if($transaction->currency_type == 'crypto')
										<h4 class="fs-6 mb-0"><a href="#" class="link-custom">{{$transaction->final_price_in_crypto}} {{$transaction->currency}}</a></h4>
										@else
										<h4 class="fs-6 mb-0"><a href="#" class="link-custom">{{$transaction->final_price}} {{$transaction->currency}}</a></h4>
										@endif
									</div>
									<div class="col-lg-7 py-3">
										<p class="small text-muted lh-1 pb-2 mb-0">Address</p>
										<div class="address-wrap">
											<h4 class="fs-6 text-break mb-0">{{$transaction->coinpayment_address}}</h4>
										</div>
									</div>
									<div class="col-lg-2 py-3 text-lg-end text-start">
										<p class="small text-muted lh-1 pb-2 mb-0">Time Left</p>
										<h4 class="fs-6 mb-0" id="time_remaining">{{$time_remaining}}</h4>
									</div>
								</div>
								<div class="row py-3">
									<div class="col-lg-12">
										<h4 class="fs-6">Make sure to send enough to cover any coin transaction fees!</h4>
										<p>Payment ID: {{$transaction->transaction_id}}</p>

									</div>
								</div>
							</div>
							@elseif($coinpayment_status == 'timeout')

							<div class="row mb-5 justify-content-center ">
								<div class="col-lg-8">
									<div class="custom-wrap">
										<div class="row py-3">
											<div class="col-lg-12 text-center">
												<h2 class="text-danger fs-4">Timed Out</h2>
												<p class="mb-0">This payment has timed out either due to lack of confirms before the time limit or due to not sending enough funds. If you have sent any funds you will receive an email to claim them within 8 hours of them confirming.</p>
											</div>
										</div>
										<hr>
										<div class="row py-3">
											<div class="col-lg-12">
												<p>If submitting a support ticket after tha 8 hour window make sure to include the following information:</p>
												<ol class="mb-0 text-break">
													<li>The transaction ID: {{$transaction->transaction_id}}</li>
													<li>Apayment address to send the funds to.</li>
												</ol>
											</div>
										</div>
									</div>
								</div>
							</div>
							@endif
						</div>
					</div>
				</section>
			</div>
			<div class="col-sm-2"></div>
		</div>
	</div>
</section>
@endsection
@section('scripts')
<script type="text/javascript">
	var coinpayment_expired_at = @json($transaction->coinpayment_expired_at);

	$(document).ready(function(){
		setInterval(function () {
			location.reload();
		}, 60000);

		var countDownDate = new Date(coinpayment_expired_at).getTime();

		var x = setInterval(function() {

			var now = new Date().getTime();

			var distance = countDownDate - now;

			// var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString();
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)).toString();
			var seconds = Math.floor((distance % (1000 * 60)) / 1000).toString();

			hours = (hours.length == 1) ? "0"+hours : hours;
			minutes = (minutes.length == 1) ? "0"+minutes : minutes;
			seconds = (seconds.length == 1) ? "0"+seconds : seconds;
			
			$('#time_remaining').text(hours+":"+minutes+":"+seconds);

		}, 1000);
	});
</script>
@endsection