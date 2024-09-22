@extends('frontend.layouts.account_app')
@section('title')  
<title>{{config('app.name')}} - Subscription</title>
@endsection
@section('content')
<!-- main content -->
<div id="content" class="collapsed">
	<div class="main-content">
		<div class="container">
			<div class="subscription py-4">
				<div class="col-md-12">
					<div class="card subscription-heading">
						<div class="heading py-3 px-3">
							<h2><img src="{{asset('assets/account/images/icons/subscribe-icon.svg')}}" height="50" class="px-2">subscription</h2>
							@include('frontend.layouts.partials.expiry-alert')
						</div>
					</div>
				</div>

				<div class="subscription-details">
					<div class="subscription-main-card card">
						@if(count($record)>0)
						<div class="subscription-information py-4 px-4">
							<div class="row">

								<div class="col-md-4">
									<div class="subscription-information-card card" id="plan-subscription">
										<div class="subscription-information-user py-3 px-3">
											<div class="img-subscription text-center">
												<img src="{{asset('assets/account/images/icons/action-plan.svg')}}" height="45">
											</div>
											<div class="about-subscription text-center">
												<h6>Plan Name</h6>
												<h3>{{(!is_null($record[0]->plans) ? $record[0]->plans->name : 'Basic Plan')}}</h3>
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-4">
									<div class="subscription-information-card card">
										<div class="subscription-information-user py-4 px-3">
											<div class="img-subscription text-center">
												
												@if(available_plan() == 'Expired Sub')
												<img src="{{asset('assets/account/images/icons/bold-expired.png')}}" height="50">
												@elseif($record[0]->is_active == 'Y')
										
												<img src="{{asset('assets/account/images/icons/sucess.svg')}}" height="50">
												@else
											
												<img src="{{asset('assets/account/images/icons/warning.png')}}" height="50">
												@endif

											</div>
											<div class="about-subscription text-center">
												<h6>Status</h6>
												@if(available_plan() == 'Expired Sub')
												<h3 class="text-danger">Expired</h3>
												@elseif($record[0]->is_active == 'Y')
												<h3 class="active">Active</h3>
												@else
												<h3 class="text-danger">In Active</h3>
												@endif

											</div>
										</div>
									</div>
								</div>

								<div class="col-md-4">
									<div class="subscription-information-card card">
										<div class="subscription-information-user py-3 px-3">
											<div class="img-subscription text-center">
												<img src="{{asset('assets/account/images/icons/start-date.svg')}}" height="50">
											</div>
											<div class="about-subscription text-center">
												<h6>Started Date</h6>
												<h3>{{\Carbon\Carbon::parse($record[0]->started_date)->format('Y-m-d H:i A')}}</h3>
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-4">
									<div class="subscription-information-card card">
										<div class="subscription-information-user py-3 px-3">
											<div class="img-subscription text-center">
												<img src="{{asset('assets/account/images/icons/expired.svg')}}" height="50">
											</div>
											<div class="about-subscription text-center">
												<h6>Expired Date</h6>
												<h3>{{\Carbon\Carbon::parse($record[0]->expired_date)->format('Y-m-d H:i A')}}</h3>
											</div>
										</div>
									</div>
								</div>

								@if(!is_null($free_plan))
								@else
								<div class="col-md-4">
									<div class="subscription-information-card card">
										<div class="subscription-information-user py-3 px-3">
											<div class="img-subscription text-center">
												<img src="{{asset('assets/account/images/icons/membership.svg')}}" height="50">
											</div>
											<div class="about-subscription text-center">
												<h6>Subscription Type</h6>
												<h3>
													@if($record[0]->plan_type == 'M')
													Monthly
													@elseif($record[0]->plan_type == 'Y')
													Yearly
													@endif
												</h3>
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-4">
									<div class="subscription-information-card card">
										<div class="subscription-information-user py-3 px-3">
											<div class="img-subscription text-center">
												<img src="{{asset('assets/account/images/icons/wallet.svg')}}" height="45">
											</div>
											<div class="about-subscription text-center">
												<h6>Purchase Amount</h6>
												<h3><i class="fa-solid fa-dollar-sign px-1"></i>{{$record[0]->purchese_price}}</h3>
											</div>
										</div>
									</div>
								</div>
								@endif
							</div>
						</div>

						<hr>
						<!-- subscription-btn -->
						<div class="subscription-button py-3">
							<div class="all-subscription-btn text-center">
								<div class="row">

									@if(!is_null($free_plan))
									<div class="col-md-4">
										<a href="{{route('change-subscription').'?type=upgrade'}}" class="btn btn-subscription">Upgrade</a>
									</div>
									@else
									<div class="col-md-4">
										<a href="{{route('change-subscription').'?type=renew'}}" class="btn btn-subscription">Renew</a>
									</div> 
									@if(!is_null($chkUpgrad))
									<div class="col-md-4">
										<a href="{{route('change-subscription').'?type=upgrade'}}" class="btn btn-subscription">Upgrade</a>
									</div>
									@endif
									@if($chkDowngrad)
									<div class="col-md-4">
										<a href="{{route('change-subscription').'?type=downgrade'}}" class="btn btn-subscription">Downgrade</a>
									</div>
									@endif
									@endif

								</div>
							</div>
						</div>
						@else

						<div class="subscription-information py-4 px-4">
							<div class="row justify-content-center text-center">
								<div class="col-md-12">
									<div class="no-subscription my-3">
										<img src="{{asset('assets/account/images/icons/no-subscription.png')}}" alt="">
										<h4 class="fs-5">No subscription found!</h4>
									</div>                                        
								</div>
								<div class="col-md-6">
									<a href="{{route('pricing')}}" class="btn btn-primary w-100">Buy Subscription</a>
								</div>
							</div>
						</div>
						@endif
					</div>
				</div>
			</div> 
		</div>
	</div>
</div>
@endsection