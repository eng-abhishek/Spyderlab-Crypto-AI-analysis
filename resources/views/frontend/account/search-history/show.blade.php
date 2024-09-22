@extends('frontend.layouts.account_app')

@section('title')  
<title>{{config('app.name')}} - Search Result</title>
@endsection

@section('content')
<div id="content" class="collapsed">
	<div class="main-content">
		<div class="container">
			<div class="osint-section py-4">
				<div class="col-md-12">
					<div class="card available-credits">
						<div class="credit d-flex tex-center justify-content-center">
							<h4>Available credits:<span>{{available_credits()}}</span></h4>
							<a href="{{route('pricing')}}"><button class="btn btn-credits mx-3" type="buttton">Buy Credits</button></a>
						</div>
					</div>
				</div>

				<div class="phone-number-details py-4">
					<div class="container mt-4">

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
						$data = json_decode($search_result->result);
						@endphp


						<div class="row">
							<!-- Left side: Image card -->

							<div class="col-md-4">
								<div class="card mb-3 phone-number-info">
									<div class="img-info">

										@if( isset($data->images) && !empty(current($data->images)))
										<img src="{{current($data->images)}}" alt="avatar" class="card-img-top">
										@else
										<img src="{{asset('assets/account/images/osint/user-osint.jpg')}}" alt="avatar">
										@endif

									</div>
									<div class="card-body text-center">
										<h5 class="card-title">{{current((array)$data->names) != '' ? current((array)$data->names) : 'Not Found'}}</h5>
										<p class="card-text">{{$search_result->country->phone_code.$search_result->search_value}}</p>
									</div>
								</div>
							</div>

							<!-- Right side: Other cards -->
							<div class="col-md-8">
								<div class="row">
									<div class="col-md-12 mb-3">
										<div class="card">
											<div class="card-header">
												Images
											</div>
											<div class="card-body">


												@if(isset($data->images) &&  count((array)$data->images) > 0)
												<ul class="list-unstyled d-flex justify-content-center flex-wrap">
													@foreach($data->images as $from => $image)
													<li class="p-3">
														<img src="{{$image}}" class="avatar bg-dark" alt="avatar" title="avatar">
													</li>
													@endforeach
												</ul>
												@else
												<h5 class="card-title">Not found</h5>
												@endif

											</div>
										</div>
									</div>
									<div class="col-md-12 mb-3">
										<div class="card">
											<div class="card-header">
												AKA/Alias
											</div>
											<div class="card-body">


												@if(count((array)$data->names) > 0)
												<ul>
													@foreach($data->names as $from => $name)
													<li>{{$name}}</li>
													@endforeach
												</ul>
												@else
												<h5 class="card-title">Not found</h5>
												@endif

											</div>
										</div>
									</div>
									<div class="col-md-12 mb-3">
										<div class="card">
											<div class="card-header">
												Email
											</div>
											<div class="card-body">


												@if(isset($data->emails) AND count((array)$data->emails) > 0)
												<ul>

													@foreach($data->emails as $from => $email_obj)

													@if( isset($email_obj->breached) && ($email_obj->breached != ''))
													<li>{{$email_obj->email}}<a href="#" class="ms-md-2 ms-0 my-md-0 my-2 btn btn-main-3">Pwned?</a>
														<span class="mx-2">|</span>
														<a target="_blank" href="{{route('advance-search')}}?email={{$email_obj->email}}" class="btn btn-sm btn-secondary">Advance Lookup</a>
													</li>
													@else

													@if(isset($email_obj->email))

													<li><a href="{{route('advance-search')}}?email={{$email_obj->email}}" class="ms-md-2 ms-0 my-md-0 my-2 btn btn-main-3">Pwned?</a>
														<span class="mx-2">|</span>
														<a target="_blank" href="{{route('advance-search')}}?email={{$email_obj->email}}" class="btn btn-sm btn-secondary">Advance Lookup</a></li>
														@else($email_obj)

														<li><a href="{{route('advance-search')}}?email={{$email_obj}}" class="ms-md-2 ms-0 my-md-0 my-2 btn btn-main-3">Pwned?</a>
															<span class="mx-2">|</span>
															<a target="_blank" href="{{route('advance-search')}}?email={{$email_obj}}" class="btn btn-sm btn-secondary">Advance Lookup</a></li>

															@endif

															@endif
															@endforeach
														</ul>
														@else
														<h5 class="card-title">Not found</h5>
														@endif

													</div>
												</div>
											</div>

											<div class="col-md-12 mb-3">
												<div class="card">
													<div class="card-header">
														Address
													</div>
													<div class="card-body">

														@if(count((array)$data->addresses) > 0)
														<ul>
															@foreach($data->addresses as $from => $address)
															<li>{{$address}}</li>
															@endforeach
														</ul>
														@else
														<h5 class="card-title">Not found</h5>
														@endif
													</div>
												</div>
											</div>


											<div class="col-md-12 mb-3">
												<div class="card">
													<div class="card-header">
														CNIC No
													</div>
													<div class="card-body">

														@if(isset($data->cnic) AND count((array)$data->cnic) > 0)
														<ul>
															@foreach($data->cnic as $from => $cnic)
															<li>{{$cnic}}</li>
															@endforeach
														</ul>
														@else
														<h5 class="card-title">Not found</h5>
														@endif
													</div>
												</div>
											</div>


											<div class="col-md-12 mb-3">
												<div class="card">
													<div class="card-header">
														Phone Number. Details
													</div>
													<div class="card-body">

														@if(isset($data->carrier_details) && count((array)$data->carrier_details) > 0)
														@php
														$carrier_details = current($data->carrier_details);
														@endphp
														<ul>
															<li>Country: {{$carrier_details->country_code}}</li>
															<li>Carrier: {{$carrier_details->carrier}}</li>
															<li>Type: {{$carrier_details->phone_type}}</li>
															<li>Network Code: </li>
															<li>Network Name: </li>
														</ul>
														@else
														<h5 class="card-title">Not found</h5>
														@endif

													</div>
												</div>
											</div>
											<div class="col-md-12 mb-3">
												<div class="card">
													<div class="card-header">
														Social Media
													</div>
													<div class="card-body">
														<div class="social-media">
															<h5 class="card-title">Facebook</h5>

															@if( isset($data->facebook) && ($data->facebook != null))
															<ul>
																<li><span class="text-muted">Username :</span> {{$data->facebook->username." - eyecon"}}</li>
																<li><span class="text-muted">Link :</span> <a href="{{$data->facebook->profile_url}}" class="btn btn-main-3" target="_blank">Visit</a> - eyecon</li>
															</ul>
															@else
															<p class="card-text">Not Found</p>
															@endif

														</div>
														<div class="social-media">
															<h5 class="card-title">Twitter</h5>
															<p class="card-text">Not Found</p>
														</div>
														<div class="social-media">
															<h5 class="card-title">Telegram</h5>
															@if( isset($data->telegram) && ($data->telegram != null && $data->telegram->username != ''))
															<ul>
																<li><span class="text-muted">Username :</span> {{$data->telegram->username." - telethon"}}</li>
															</ul>
															@else
															<p class="card-text">Not Found</p>
															@endif
														</div>
														<div class="social-media">
															<h5 class="card-title">WhatsApp</h5>
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