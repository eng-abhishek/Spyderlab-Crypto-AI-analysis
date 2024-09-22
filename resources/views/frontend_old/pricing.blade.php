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
{!! organization_jsonld() !!}
{!! breadcrumbs_jsonld([
    ['url' => route('home'), 'title' => 'Home'],
    ['title' => 'Pricing']
]) 
!!}
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
							<li class="breadcrumb-item active">Pricing</li>
						</ol>
					</nav>
					<h1 class="fs-2 mb-0">Pricing</h1>
				</div>
			</div>
		</div>
	</section>
	<section class="bg-custom-light py-5">
		<div class="container-xl container-fluid">
			<div class="row justify-content-center align-items-center text-center">
				<div class="col-md-12">
					<h2 class="fs-5">Choose your Plan</h2>
					<h3 class="fs-3">OSINT & DarkWeb Intelligence pricing</h3>
				</div>
			</div>
			<div class="row my-3 text-center">

				@php
				$index = 0;
				@endphp
				@forelse($plans as $plan)
				@php
				$index++;
				@endphp
				<div class="col-md-4 mb-md-0 mb-3">
					<div class="product-pricing pricing-{{$index}}">
						<h4>{{$plan->name}}</h4>
						<h5><i class="fa-thin fa-coin-vertical"></i> {{$plan->credits}} Credits</h5>
						<h6><i class="fa-light fa-inr"></i>{{$plan->price}}</h6>
						<a href="{{route('contact-us')}}" class="btn btn-buy">Buy Credits</a>
					</div>
				</div>
				@empty
				<span>There is no active plan.</span>
				@endforelse

			</div>
			<div class="row text-center mt-3">
				<div class="col-lg-12">
					<p class="fst-italic">*prices inclusive of 18% GST</p>
					<p class="fst-italic">*All credits are valid for 6 months from date of purchase</p>
				</div>
			</div>
		</div>
	</section>
	@if(is_null(auth()->user()))
	<section class="bg-custom-dark py-5">
		<div class="container-xl container-fluid">
			<div class="row justify-content-center align-items-center text-center">
				<div class="col-md-12">
					<h2>Login to get Free Credits.</h2>
					<a href="{{route('login')}}" class="btn btn-main btn-lg px-5 mt-3 rounded-pill">Login</a>
				</div>
			</div>
		</div>
	</section>
	@endif
	<section class="bg-custom-light py-5">
		<div class="container-xl container-fluid">
			<div class="row justify-content-center align-items-center text-center mb-3">
				<div class="col-md-12">
					<h2 class="fs-5">Choose your Plan</h2>
				{{--<h3 class="fs-3">Take a look at our exclusive range of pricing!</h3>--}}
				    <h3 class="fs-3">Crypto Track prcing</h3>
				</div>
			</div>
			<div class="row my-3">
				<div class="col-lg-12 col-md-12 mb-5 text-center">
					<div class="d-flex justify-content-center align-items-center">
						<label class="form-check-label fs-5 fw-bold text-uppercase" for="period">Monthly</label>
						<div class="form-check form-switch ps-0">
							<input class="form-check-input mx-2 mt-0 form-switch-lg" type="checkbox" role="switch" id="period" checked="">
						</div>                                    
						<label class="form-check-label fs-5 fw-bold text-uppercase" for="period">Yearly</label>                                    
					</div>
				</div>

				<div class="crypto-plan col-lg-12"></div>
			</div>
		</div>
	</section>
	@include('frontend.layouts.partials.alert-message')
</main>
@endsection
@section('scripts')
<script type="text/javascript">
	$(function(){
		getCryptoPlan('Y');
	})

	$('#period').on('change',function(){
		
		if($('#period').is(':checked',true)){
			var type = "Y";
		}else{
			var type = "M";
		}
		getCryptoPlan(type);
	})

	function getCryptoPlan(type){
		
		$.ajax({
			url:'{{route("get-crypto-plan")}}',
			headers:{
				'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			},
			method:'post',
			data:{type:type},
			success:function(data){
				$('.crypto-plan').html(data);
			}
		});
	}
</script>
@endsection