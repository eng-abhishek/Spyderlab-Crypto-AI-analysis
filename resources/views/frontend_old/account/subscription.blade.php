@extends('frontend.layouts.app')

@section('og')
<title>{{config('app.name').' - '.'Subscription'}}</title>
<meta name="title" content="{{config('app.name').' - '.'Change password'}}">
<meta name="description" content="{{settings('site')->meta_description ?? ''}}">
<meta name="keywords" content="{{settings('site')->meta_keywords ?? ''}}">
<meta property="og:image" content="{{asset('assets/frontend/images/spyderlab_featured_image.png')}}"/>
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
							<li class="breadcrumb-item active">Subscription</li>
						</ol>
					</nav>
					<h1 class="fs-2 mb-0">Subscription</h1>
				</div>
			</div>
		</div>
	</section>
	<section class="bg-custom-light py-5">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-2">
				   @include('frontend.layouts.partials.profile-sidebar')
				</div>
				<div class="col-lg-10">
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="coin-item">
								<div class="row align-items-center">
									<div class="col-md-12 text-md-start text-center">
										<h2 class="mb-md-0 mb-3"><i class="fa-light fa-calendar-clock"></i>  My Subscription</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="coin-item my-3">
								@if(count($record)>0)
								<div class="row justify-content-center">
									<div class="col-lg-4 col-md-6">
										<div class="account-item">
											<i class="fa-sharp fa-regular fa-user"></i>
											<h3 class="fs-6">Plan Name</h3>
											<h4 class="fs-5 mb-0">{{(!is_null($record[0]->plans) ? $record[0]->plans->name : 'Basic Plan')}}</h4>
										</div>
									</div>
									<div class="col-lg-4 col-md-6">
										<div class="account-item">
											<i class="fa-sharp fa-regular fa-badge-check"></i>
											@if($record[0]->is_active == 'Y')
											<h4 class="fs-5 mb-0 text-success">Active</h4>
											@else
											<h4 class="fs-5 mb-0 text-danger">In Active</h4>
											@endif                                          
										</div>
									</div>
									<div class="col-lg-4 col-md-6">
										<div class="account-item">
											<i class="fa-sharp fa-regular fa-calendar-check"></i>
											<h3 class="fs-6">Started Date</h3>
											<h4 class="fs-5 mb-0"> {{\Carbon\Carbon::parse($record[0]->started_date)->format('Y-m-d H:i A')}}</h4>
										</div>
									</div>
									<div class="col-lg-4 col-md-6">
										<div class="account-item">
											<i class="fa-sharp fa-regular fa-calendar-xmark"></i>
											<h3 class="fs-6">Expired Date</h3>
											<h4 class="fs-5 mb-0">{{\Carbon\Carbon::parse($record[0]->expired_date)->format('Y-m-d H:i A')}}</h4>
										</div>
									</div>
									@if(!is_null($free_plan))
									@else
									<div class="col-lg-4 col-md-6">
										<div class="account-item">
											<i class="fa-sharp fa-regular fa-star"></i>
											<h3 class="fs-6">Subscription Type</h3>
											<h4 class="fs-5 mb-0">
												@if($record[0]->plan_type == 'M')
												Monthly
												@elseif($record[0]->plan_type == 'Y')
												Yearly
												@endif
											</h4>
										</div>
									</div>
									<div class="col-lg-4 col-md-6">
										<div class="account-item">
											<i class="fa-sharp fa-regular fa-money-bills"></i>
											<h3 class="fs-6">Purchase Amount</h3>
											<h4 class="fs-5 mb-0">
												{{$record[0]->purchese_price}}
											</h4>
										</div>
									</div>
									@endif
								</div>
								<div class="row mt-3">
									@if(!is_null($free_plan))
									<div class="col-md-4 mb-md-0 mb-3">
										<a href="{{route('pricing')}}" class="btn btn-main-2 w-100">Upgrade</a>
									</div>
									@else
									<div class="col-md-4 mb-md-0 mb-3">
										<a href="{{route('pricing')}}" class="btn btn-main-2 w-100">Renew</a>
									</div> 
									@if(!is_null($chkUpgrad))
									<div class="col-md-4 mb-md-0 mb-3">
										<a href="{{route('pricing')}}" class="btn btn-main-2 w-100">Upgrade</a>
									</div>
									@endif
									@if($chkDowngrad)
									<div class="col-md-4 mb-md-0 mb-3">
										<a href="{{route('pricing')}}" class="btn btn-main-2 w-100">Downgrade</a>
									</div>
									@endif
									@endif
									
									@else
									<div class="row justify-content-center text-center">
										<div class="col-md-12">
											<div class="no-subscription my-3">
												<img src="{{asset('assets/frontend/images/no-subscription.png')}}" alt="">
												<h3 class="fs-5">No subscription found!</h3>
											</div>                                        
										</div>
										<div class="col-md-6">
											<a href="{{route('pricing')}}" class="btn btn-main-2 w-100">Buy Subscription</a>
										</div>
									</div>
									@endif
								</div>                                    
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>
@endsection