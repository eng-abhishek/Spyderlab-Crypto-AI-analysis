@extends('frontend.layouts.app')

@section('og')
<title>{{config('app.name').' - '.'Change password'}}</title>
<meta name="title" content="{{config('app.name').' - '.'Change password'}}">
<meta name="description" content="{{settings('site')->meta_description ?? ''}}">
<meta name="keywords" content="{{settings('site')->meta_keywords ?? ''}}">
<meta property="og:image" content="{{asset('assets/frontend/images/spyderlab_featured_image.png')}}" />
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
							<li class="breadcrumb-item active">Account</li>
						</ol>
					</nav>
					<h1 class="fs-2 mb-0">Account</h1>
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
										<h2 class="mb-md-0 mb-3"><i class="fa-light fa-user-circle"></i> My Account</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="coin-item my-3">
								<div class="mb-3 px-3">
									<h3>Username</h3>
									<p class="mb-0 text-break">{{$record->username}}</p>
								</div>
								<div class="mb-3 px-3">
									<h3>Mobile</h3>
									<p class="mb-0 text-break">{{$record->mobile}}</p>
								</div>
								<div class="mb-3 px-3">
									<h3>Current Plan</h3>
									<div class="d-flex align-items-lg-center align-items-start flex-lg-row flex-column">
										@if($record->plan_name)
									    <p class="mb-0">{{$record->plan_name}}</p>
										<a href="{{route('pricing')}}" class="mx-lg-3 mx-0 my-lg-0 my-3 custom-link">
											@if($record->plan_slug == $top_plan->slug)
											<i class="fa-light fa fa-exchange me-1"></i> Change
											@else
											<i class="fa-light fa-up-from-line me-1"></i> Upgrade
											@endif
										</a>
										@else
                                        <p class="mb-0">You do`t have any plan</p>
										<a href="{{route('pricing')}}" class="mx-lg-3 mx-0 my-lg-0 my-3 custom-link"><i class="fa-light fa-up-from-line me-1"></i> Buy Now</a>
										@endif
									</div>
								</div>
								<div class="mb-3 px-3">
									<h3>Status</h3>
									@if($record->is_active == 'Y')
									<p class="mb-0 text-break">Enabled</p>
									@else
									<p class="mb-0 text-break">Disabled</p>
									@endif
								</div>
								<div class="mb-3 px-3">
									<h3>Total Credit(s)</h3>
									<div class="d-flex align-items-lg-center align-items-start flex-lg-row flex-column">
										<p class="mb-0">{{available_credits()}}</p>
										<a href="{{route('pricing')}}" class="mx-lg-3 mx-0 my-lg-0 my-3 custom-link"><i class="fa-light fa-up-from-line me-1"></i> Buy Credits</a>
									</div>
								</div>
								<div class="mb-3 px-3">
									<h3>Expire Date</h3>
									<p class="mb-0 text-break">{{$record->sub_exp_date}}</p>
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