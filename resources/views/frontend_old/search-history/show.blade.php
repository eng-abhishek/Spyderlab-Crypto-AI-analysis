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
							<li class="breadcrumb-item active">Search Result</li>
						</ol>
					</nav>
					<h1 class="fs-2 mb-0">Search Result</h1>
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
			<div class="row justify-content-center">
				<div class="col-lg-12 col-md-12">
					<div class="result-area">
						@if($search_result->status_code != '200' || is_null($search_result->result))
						<!-- No result start-->
						<div class="row justify-content-center text-center mt-3">
							<div class="col-lg-10 col-md-12">
								<div class="no-result">
									<img src="{{asset('assets/frontend/images/no-result.png')}}" alt="">
									<h3 class="fs-5">No results found!</h3>
								</div>
							</div>
						</div>
						<!-- No result end-->
						@else
						@php
						$result = json_decode($search_result->result);
						@endphp
						<div class="row">
							<div class="col-lg-3 col-md-4">
								<div class="sticky-top">
									<div class="profile-main bg-custom-dark text-center">
										@if(!empty(current($result->images)))
										<img src="{{current($result->images)}}" alt="avatar">
										@else
										<img src="{{asset('assets/frontend/images/default-user.jpg')}}" alt="avatar">
										@endif
										<div class="p-2">
											<h3>{{current((array)$result->names) != '' ? current((array)$result->names) : 'Not Found'}}</h3>

											@if($search_result->search_key == 'phone')
											<h4 class="mb-0">{{$search_result->country->phone_code.$search_result->search_value}}</h4>
											@else
											<h4 class="mb-0">{{$search_result->search_value}}</h4>
											@endif
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
										@if(count((array)$result->images) > 0)

										<ul class="list-unstyled d-flex justify-content-center flex-wrap">
											@foreach($result->images as $from => $image)
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

										@if(count((array)$result->names) > 0)
										<ul>
											@foreach($result->names as $from => $name)
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

										@if(count((array)$result->emails) > 0)
										<ul>

											@foreach($result->emails as $from => $email_obj)

											@if($email_obj->breached != '')
											<li>{{$email_obj->email}}
												<a href="#" class="ms-md-2 ms-0 my-md-0 my-2 btn btn-main-3">Pwned?</a>
												<span class="mx-2">|</span>
												<a target="_blank" href="{{route('advance-search')}}?email={{$email_obj->email}}" class="btn btn-main-3">Advance Lookup</a></li>

												@else

												<li>{{$email_obj->email}}
													<a href="#" class="ms-md-2 ms-0 my-md-0 my-2 btn btn-main-3">Pwned?</a>
													<span class="mx-2">|</span>
													<a target="_blank" href="{{route('advance-search')}}?email={{$email_obj->email}}" class="btn btn-main-3">Advance Lookup</a></li>
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


												@if(count((array)$result->addresses) > 0)
												<ul>
													@foreach($result->addresses as $from => $address)
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
												<h3 class="mb-0">Phone No. Details</h3>
											</div>
											<div class="search-result-content">


												@if(count((array)$result->carrier_details) > 0)
												@php
												$carrier_details = current($result->carrier_details);
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
													@if($result->facebook != null)

													<ul>
														<li><span class="text-muted">Username:</span> {{$result->facebook->username." - eyecon"}}</li>
														<li><span class="text-muted">Link:</span> <a href="{{$result->facebook->profile_url}}" target="_blank">Visit</a> - eyecon</li>
													</ul>

													@else
													<span>Not found</span>
													@endif
												</div>
												<hr>
												<div class="mt-3">
													<h4 class="fs-6">Twitter</h4>
													{{--<ul>
														<li><span class="text-muted">Handle:</span> johndoe</li>
														<li><span class="text-muted">Link:</span> <a href="#" class="btn btn-main-3">Visit</a></li>
													</ul>--}}
													<span>Not found</span>
												</div>
												<hr>
												<div class="mt-3">
													<h4 class="fs-6">Telegram</h4>
													{{--<ul>
														<li><span class="text-muted">Username:</span> johndoe</li>
														<li><span class="text-muted">Link:</span> <a href="#" class="btn btn-main-3">Visit</a></li>--}}
														<span>Not found</span>
													</ul>
												</div>
												<hr>
												<div class="mt-3">
													<h4 class="fs-6">WhatsApp</h4>
													{{--<ul>
														<li><span class="text-muted">Status:</span> Active</li>
													</ul>--}}
													<span>Not found</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							@endif

						</div>
					</div>
				</div>
			</section>
		</main>
		@if(session()->has('status'))
		<div class="toast-container position-fixed bottom-0 end-0 p-3">
			<div class="toast align-items-center text-bg-{{session('status')}} border-0 fade show" role="alert" aria-live="assertive" aria-atomic="true">
				<div class="d-flex">
					<div class="toast-body">
						{!! session('message') !!}
					</div>
					<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
				</div>
			</div>
		</div>
		@endif

		@endsection

		@section('scripts')
		<script type="text/javascript">
			$(document).ready(function(){
				$('#update_result_data').click(function(){

					Swal.fire({ 
						title: "Are you sure you want to get latest details?",
						text: "It requires 1 credit.",
						type: "warning",
						showCancelButton: true,
						confirmButtonText: "Yes, Update it!"
					}).then(function (e) {
						if(e.value){
							$('#update_result_form').submit();		
						}
					})
				});
			});
		</script>
		@endsection