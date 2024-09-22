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
	['title' => 'Search']
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
								<li class="breadcrumb-item active">Search</li>
							</ol>
						</nav>
						<h1 class="fs-2 mb-0">Search</h1>
					</div>
				</div>
			</div>
		</section>
		<section class="py-3 bg-custom-dark">            
			<div class="container-xl container-fluid">
				<div class="row justify-content-center align-items-center text-center">
					<div class="col-lg-12 col-md-12">
						<p class="mb-0">Available Credits: {{available_credits()}} <span class="divider"></span><a href="{{route('pricing')}}" class="btn btn-outline-light btn-sm btn-spyder rounded-0">Buy Credits</a></p>
					</div>
				</div>
			</div>           
		</section>
		
		<section class="bg-custom-light py-5">
			<div class="container-xl container-fluid">
				<div class="row justify-content-center align-items-center">
					<div class="col-lg-10 col-md-12">
						<h2 class="fs-4 text-center">Search by Phone Number / Email</h2>
						<div class="search-wrap py-3">
							<div class="row justify-content-center text-center">
								<div class="col-lg-6 col-md-6 mb-md-0 mb-3">
									<div class="search-by">
										<input type="radio" name="search_by" id="search_by_phone" class="d-none search-radio" value="phone" checked>
										<label for="search_by_phone">
											<span class="phone-number"></span>
											<h3>Phone Number</h3>
										</label>
									</div>
								</div>
								<div class="col-lg-6 col-md-6">
									<div class="search-by">
										<input type="radio" name="search_by" id="search_by_email" class="d-none search-radio" value="email">
										<label for="search_by_email">
											<span class="email-id"></span>
											<h3>Email ID</h3>
										</label>
									</div>
								</div>
							</div>
							<div class="row justify-content-center">
								<div class="col-lg-12 col-md-12">
									<form action="{{route('search.submit')}}" method="post" class="mt-3 search-by-phone">
										@csrf
										<input type="hidden" name="search_by" value="phone">
										<div class="d-flex flex-md-row flex-column">
											<select name="country_code" id="country_code" class="form-select select-search me-md-2 me-0 mb-md-0 mb-3 w-auto">
												@foreach($countries as $code => $phone_code)
												<option value="{{$code}}" {{($country_code == $code)?'selected="selected"':''}}>{{$code}} ({{$phone_code}})</option>
												@endforeach
											</select>
											<div class="search-bar flex-grow-1">
												<input id="search" class="form-control" placeholder="Enter phone number" name="phone_number" type="search" value="{{$phone_number}}">
												<button class="btn btn-main btn-search" type="submit"></button>
											</div>
										</div>
										@error('phone_number')
										<span class="invalid-feedback d-block">{{$message}}</span>
										@enderror
									</form>
									<form action="{{route('search.submit')}}" method="post" class="mt-3 search-by-email d-none">
										@csrf
										<input type="hidden" name="search_by" value="email">
										<div class="search-bar">
											<input id="search" class="form-control" placeholder="Enter email id" name="email" type="search" value="{{$email ?? ''}}">
											<button class="btn btn-main btn-search" type="submit"></button>
										</div>
										@error('email')
										<span class="invalid-feedback d-block">{{$message}}</span>
										@enderror
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				@if(!is_null($details_by_phone) && isset($details_by_phone))
				<div class="row justify-content-center mt-3">
					<div class="col-lg-12 col-md-12">
						<div class="result-area">
							@if($details_by_phone->status_code != '200' || is_null($details_by_phone->data))
							<div class="row justify-content-center text-center mt-3">
								<div class="col-lg-10 col-md-12">
									<div class="no-result">
										<img src="{{asset('assets/frontend/images/no-result.png')}}" alt="">
										<h3 class="fs-5">No results found!</h3>
									</div>
								</div>
							</div>
							@else
							@php
							$data = $details_by_phone->data;
							@endphp

							<div class="row">
								<div class="col-lg-3 col-md-4">
									<div class="sticky-top">
										<div class="profile-main bg-custom-dark text-center">         
											@if( isset($data->images) && !empty(current($data->images)))
											<img src="{{current($data->images)}}" alt="avatar">
											@else
											<img src="{{asset('assets/frontend/images/default-user.jpg')}}" alt="avatar">
											@endif

											<div class="p-2">
												<h3>{{current((array)$data->names) != '' ? current((array)$data->names) : 'Not Found'}}</h3>
												<h3 class="mb-0">{{$countries[$country_code].$phone_number}}</h3>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-9 col-md-8">
									<div class="search-result-item mb-3">
										<div class="search-result-head">
											<h3 class="mb-0">Images</h3>
										</div>
										<div class="search-result-content">
											@if(isset($data->images) &&  count((array)$data->images) > 0)
											<ul class="list-unstyled d-flex justify-content-center flex-wrap">
												@foreach($data->images as $from => $image)
												<li class="p-3">
													<img src="{{$image}}" class="avatar bg-dark" alt="avatar" title="avatar">
												</li>
												@endforeach
											</ul>
											@else
											<span>Not found</span>
											@endif

										</div>
									</div>
									<div class="search-result-item mb-3">
										<div class="search-result-head">
											<h3 class="mb-0">AKA / Alias</h3>
										</div>
										<div class="search-result-content">
											@if(count((array)$data->names) > 0)
											<ul>
												@foreach($data->names as $from => $name)
												<li>{{$name}}</li>
												@endforeach
											</ul>
											@else
											<span>Not found</span>
											@endif
										</div>
									</div>
									<div class="search-result-item mb-3">
										<div class="search-result-head">
											<h3 class="mb-0">Email</h3>
										</div>
										<div class="search-result-content">
											
											@if(isset($data->emails) AND count((array)$data->emails) > 0)
											<ul>

												@foreach($data->emails as $from => $email_obj)

												@if( isset($email_obj->breached) && ($email_obj->breached != ''))
												<li>{{$email_obj->email}}<a href="#" class="ms-md-2 ms-0 my-md-0 my-2 btn btn-main-3">Pwned?</a>
													<span class="mx-2">|</span>
													<a target="_blank" href="{{route('advance-search')}}?email={{$email_obj->email}}" class="btn btn-main-3">Advance Lookup</a>
												</li>
												@else
												
												@if(isset($email_obj->email))

												<li><a href="{{route('advance-search')}}?email={{$email_obj->email}}" class="ms-md-2 ms-0 my-md-0 my-2 btn btn-main-3">Pwned?</a>
													<span class="mx-2">|</span>
													<a target="_blank" href="{{route('advance-search')}}?email={{$email_obj->email}}" class="btn btn-main-3">Advance Lookup</a></li>
													@else($email_obj)

													<li><a href="{{route('advance-search')}}?email={{$email_obj}}" class="ms-md-2 ms-0 my-md-0 my-2 btn btn-main-3">Pwned?</a>
														<span class="mx-2">|</span>
														<a target="_blank" href="{{route('advance-search')}}?email={{$email_obj}}" class="btn btn-main-3">Advance Lookup</a></li>

														@endif

														@endif
														@endforeach
													</ul>
													@else
													<span>Not found</span>
													@endif
												</div>
											</div>
											<div class="search-result-item mb-3">
												<div class="search-result-head">
													<h3 class="mb-0">Address</h3>
												</div>
												<div class="search-result-content">
													@if(count((array)$data->addresses) > 0)
													<ul>
														@foreach($data->addresses as $from => $address)
														<li>{{$address}}</li>
														@endforeach
													</ul>
													@else
													<span>Not found</span>
													@endif
												</div>
											</div>

			                                <div class="search-result-item mb-3">
												<div class="search-result-head">
													<h3 class="mb-0">CNIC No</h3>
												</div>
												<div class="search-result-content">
													@if(isset($data->cnic) AND count((array)$data->cnic) > 0)
													<ul>
														@foreach($data->cnic as $from => $cnic)
														<li>{{$cnic}}</li>
														@endforeach
													</ul>
													@else
													<span>Not found</span>
													@endif
												</div>
											</div>

											<div class="search-result-item mb-3">
												<div class="search-result-head">
													<h3 class="mb-0">Phone No. Details</h3>
												</div>
												<div class="search-result-content">

													@if(isset($data->carrier_details) && count((array)$data->carrier_details) > 0)
													@php
													$carrier_details = current($data->carrier_details);
													@endphp
													<ul>
														<li><span class="text-muted">Country:</span> {{$carrier_details->country_code}}</li>
														<li><span class="text-muted">Carrier:</span> {{$carrier_details->carrier}}</li>
														<li><span class="text-muted">Type:</span> {{$carrier_details->phone_type}}</li>
														<li><span class="text-muted">Network Code:</span> </li>
														<li><span class="text-muted">Network Name:</span> </li>
													</ul>
													@else
													<span>Not found</span>
													@endif
												</div>
											</div>
											<div class="search-result-item mb-3">
												<div class="search-result-head">
													<h3 class="mb-0">Social Media</h3>
												</div>
												<div class="search-result-content">
													<div>
														<h4 class="fs-6">Facebook</h4>
														@if( isset($data->facebook) && ($data->facebook != null))
														<ul>
															<li><span class="text-muted">Username :</span> {{$data->facebook->username." - eyecon"}}</li>
															<li><span class="text-muted">Link :</span> <a href="{{$data->facebook->profile_url}}" class="btn btn-main-3" target="_blank">Visit</a> - eyecon</li>
														</ul>
														@else
														<span>Not found</span>
														@endif
													</div>
													<hr>
													<div class="mt-3">
														<h4 class="fs-6">Twitter</h4>
														<span>Not found</span>
													</div>
													<hr>
													<div class="mt-3">
														<h4 class="fs-6">Telegram</h4>
														@if( isset($data->telegram) && ($data->telegram != null && $data->telegram->username != ''))
														<ul>
															<li><span class="text-muted">Username :</span> {{$data->telegram->username." - telethon"}}</li>
														</ul>
														@else
														<span>Not found</span>
														@endif
													</div>
													<hr>
													<div class="mt-3">
														<h4 class="fs-6">WhatsApp</h4>
														@if( isset($data->telegram) && ($data->whatsapp != null))
														<ul>
															<li><span class="text-muted">Status :</span> {{($data->whatsapp->whatsapp_exist)?'Active':'In-Active'}}</li>
															@if($data->whatsapp->contact_info != null)
															<li><span class="text-muted">Name :</span> {{($data->whatsapp->contact_info->name != '') ? $data->whatsapp->contact_info->name." - green-api" : ''}}</li>
															<li><span class="text-muted">Email :</span> {{($data->whatsapp->contact_info->email != '') ? $data->whatsapp->contact_info->email." - green-api" : ''}}</li>
															@endif

														</ul>
														@else
														<span>Not found</span>
														@endif
													</div>
												</div>
											</div>
										</div>
									</div>
									@endif
								</div>
							</div>
						</div>
						@endif
					</div>
				</section>
				@include('frontend.layouts.partials.alert-message')
			</main>
			@endsection
			@section('scripts')
			<script>
				$(document).ready(function(){
					if("{{count($errors) > 0 && $errors->has('email')}}"){
						$('#search_by_email').click();
					}
				});
			</script>
			@endsection