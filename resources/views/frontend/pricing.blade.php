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
      @if(!auth()->user())
      <section class="pricing-login">
        <div class="container justify-content-center">
            <div class="card pricing-login-card my-3">
            <div class="pricing-login-details py-4">
                <h2 class="py-2">Signup to get Free Credits.</h2>
                <div class="btn-login-details text-center pt-4">
                    <a href="{{route('register')}}"><button class="btn btn-login">Signup</button></a>
                </div>
            </div>
            </div>
        </div>
      </section>
      @endif

<!-- Crypto Track prcing -->
<section class="crypto-track-pricing">
	<div class="container">
		<div class="crypto-track-pricing-details py-5">
			<div class="crypto-track-pricing-details-heading py-3">
				<h5>Choose your Plan</h5>
				<h2>Crypto Track pricing</h2>
				<div class="d-flex justify-content-center">
					<label class="form-check-label px-2">MONTHLY</label>
					<div class="form-check form-switch">
						<input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
						<label class="form-check-label" for="flexSwitchCheckDefault">YEARLY</label>
					</div>
				</div>
			</div>

			<!--------- monthly plan ---------->
			<div class="row py-5 crypto-plan-monthly">

				@forelse($plans as $key => $plansData)
				<div class="col-md-3">
					<div class="card crypto-track-pricing-card">
						<div class="price-crypto-track-pricing crypto-pricing-bg-{{$key+1}}">
							<h5>{{$plansData->name}}</h5>

							@if(($plansData->is_free == 'Y'))
							<h6></h6>
							@else
							<h6><i class="fa-solid fa-dollar-sign"></i> {{convertCurrency('INR','USD',round(($plansData->monthly_price*12),2)) }} per year</h6>
							@endif

							@if(($plansData->is_free == 'Y'))
							<h3><i class="fa-solid fa-dollar-sign"></i> {{convertCurrency('INR','USD',$plansData->monthly_price)}}<span>/{{$plansData->duration}}Days</span></h3>
							@else
							<h3><i class="fa-solid fa-dollar-sign"></i> {{convertCurrency('INR','USD',$plansData->monthly_price)}} <span>/Month</span></h3>
							@endif

						</div>
						<div class="crypto-track-pricing-features">
							<ul>
								@php 
								$feature = json_decode($plansData->feature);
								@endphp

								@foreach($feature as $featureData)
								<li><i class="fa fa-check"></i> {{$featureData->feature}}</li>
								@endforeach
							</ul>
							<div class="btn py-3">
								@if(($plansData->is_free == 'Y') AND (!is_null(auth()->user())) )
								@if($check_free_user < 1)
								<a href="{{route('buy.subscription',$plansData->slug)}}"><button class="btn btn-price">Buy Now</button></a>
								@endif
								@else
								@if(($plansData->is_free == 'Y'))
								<a href="{{route('register')}}"><button class="btn btn-price">Signup Now</button></a>
								@else
                                <a href="{{route('purchase').'?plan='.$plansData->slug}}"><button class="btn btn-price">Buy Now</button></a>
								@endif
								@endif
							</div>
						</div>
					</div>
				</div>
				@empty
				@endforelse
			</div>
			<!--------- end monthly plan ---------->


			<!--------- yearly plan ---------->

			<div class="row py-5 crypto-plan-yearly d-none">

				@forelse($plans as $key => $plansData)
				<div class="col-md-3">
					<div class="card crypto-track-pricing-card">
						<div class="price-crypto-track-pricing crypto-pricing-bg-{{$key+1}}">
							<h5>{{$plansData->name}}</h5>

							@if(($plansData->is_free == 'Y'))

							<h6></h6>
							@else

							<h6><i class="fa-solid fa-dollar-sign"></i>  {{convertCurrency('INR','USD',round(($plansData->monthly_price),2))}} per month</h6>
							@endif

							@if(($plansData->is_free == 'Y'))
							<h3><i class="fa-solid fa-dollar-sign"></i> {{convertCurrency('INR','USD',$plansData->monthly_price*12)}}<span>/{{$plansData->duration}}Days</span></h3>
							@else
							<h3><i class="fa-solid fa-dollar-sign"></i> {{convertCurrency('INR','USD',$plansData->monthly_price*12)}} <span>/Year</span></h3>
							@endif

						</div>
						<div class="crypto-track-pricing-features">
							<ul>
								@php 
								$feature = json_decode($plansData->feature);
								@endphp

								@foreach($feature as $featureData)
								<li><i class="fa fa-check"></i> {{$featureData->feature}}</li>
								@endforeach
							</ul>
							<div class="btn py-3">
								@if(($plansData->is_free == 'Y') AND (!is_null(auth()->user())) )
								@if($check_free_user < 1)
								<a href="{{route('buy.subscription',$plansData->slug)}}"><button class="btn btn-price">Buy Now</button></a>
								@endif
								@else
								@if(($plansData->is_free == 'Y'))
								<a href="{{route('register')}}"><button class="btn btn-price">Signup Now</button></a>
								@else
								<a href="{{route('purchase').'?plan='.$plansData->slug}}"><button class="btn btn-price">Buy Now</button></a>
								@endif
								@endif
							</div>
						</div>
					</div>
				</div>
				@empty
				@endforelse
			</div>
			<!--------- end yearly plan ---------->
		</div>
	</div>
</section>
@endsection

@section('scripts')
<script type="text/javascript">
	$('#flexSwitchCheckDefault').on('click',function(){

		if ($("#flexSwitchCheckDefault").is(":checked")) {

			$('.crypto-plan-yearly').removeClass('d-none');
			$('.crypto-plan-monthly').addClass('d-none');

		}else{

			$('.crypto-plan-yearly').addClass('d-none');
			$('.crypto-plan-monthly').removeClass('d-none');
		}
	})
</script>
@endsection