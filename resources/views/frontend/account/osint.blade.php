@extends('frontend.layouts.account_app')

@section('title')  
<title>{{config('app.name')}} - Search</title>
@endsection

@section('content')

<div id="content" class="collapsed">
	<div class="main-content">
		<div class="container">
			<div class="osint-section py-4">
				<div class="col-md-12">
					<div class="card heading-osint">
						<div class="heading3 d-flex">
							<h3><i class="fa fa-search fa-1x"></i> Search</h3>
						</div>
					</div>
				</div>
				<!-- case variations universal Ai -->
				<div class="ai-details-card">
					<div class="container">
						<div class="ai-information-card">
							<div class="row">
								<div class="col-md-6">
									<h6><b>CASE VARIATIONS</b></h6>
									<div class="card">
										<div class="case-variations py-4 px-2">
											<div class="row">
												<div class="col-md-6">
													<div class="osint-graph">
														<img src="{{asset('assets/account/images/osint/pie-chart-demo.svg')}}" height="150">
													</div>

												</div>

												<div class="col-md-6">
													<ul class="py-3">
														<li>Extortion </li>
														<li>Fake profile  </li>
														<li> AI generated  </li>
														<li>Scam </li>
														<li>Crypto Fraud</li>
													</ul>
												</div>

											</div>

										</div>

									</div>
								</div>
								<div class="col-md-6">
									<h6><b>UNIVERSAL AI</b></h6>
									<div class="card universa">
										<div class="universal-ai py-4 px-4">
											<div class="row">
												<div class="col-md-4">
													<div class="logo">
														<img src="{{asset('assets/frontend/images/logo.png')}}">
													</div>

												</div>

												<div class="col-md-8">
													<form>
														<div class="mb-3 universal-ai-form">
															<label for="example" class="form-label"></label>
															<input type="text" class="form-control" id="example" aria-describedby="">
														</div>
														<button type="submit" class="btn btn-primary">Search</button>

													</form>

												</div>

											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-12">
					<div class="card available-credits">
						<div class="credit d-flex tex-center justify-content-center">
							<h4>Available credits:<span>{{available_credits()}}</span></h4>
							<a href="{{route('pricing')}}"><button class="btn btn-credits mx-3" type="buttton">Buy Credits</button></a>
						</div>
					</div>
				</div>

				<div class="search-osint">

					<div class="search-information">
						<div class="row">
							<div class="col-md-3">
								<div class="card email" onclick="toggleEmailInfo()">
									<img src="{{asset('assets/account/images/osint/message-osint.svg')}}" alt="Email">
									<h6>Email Lookup</h6>
								</div>
							</div>
							<div class="col-md-3">
								<div class="card phone-number" onclick="togglePhoneNumberInfo()">
									<img src="{{asset('assets/account/images/osint/phone-osint.svg')}}" alt="Phone Number">
									<h6>Phone Number Lookup</h6>
								</div>
							</div>
							<div class="col-md-3">
								<div class="card social-network-search-engine" onclick="togglesocialnetworkInfo()">
									<img src="{{asset('assets/account/images/osint/social-network-osint.svg')}}" alt="Phone Number">
									<h6>Social Network Lookup</h6>
								</div>
							</div>
							<div class="col-md-3">
								<div class="card username-osint" onclick="toggleusernameInfo()">
									<img src="{{asset('assets/account/images/osint/username-osint.svg')}}" alt="Phone Number">
									<h6>Username OSINT</h6>
								</div>
							</div>  
						</div>

						<!-- Phone Number Information -->
						<div class="phone-number-information">

							<form action="{{route('search.submit')}}" method="post" class="mt-3 search-by-phone">
								@csrf
								<input type="hidden" name="search_by" value="phone">
								<div class="row">

									<div class="col-md-3">
										<div class="number">
											<select name="country_code" id="country_code" class="form-select py-3" aria-label="Default select example">

												@foreach($countries as $code => $phone_code)
												<option value="{{$code}}" {{($country_code == $code)?'selected="selected"':''}}>{{$code}} ({{$phone_code}})</option>
												@endforeach

											</select>
										</div>
									</div>

									<div class="col-md-9">
										<div class="number-search">
											<div class="input-group mb-3">
												<input type="hidden" name="search_by" value="phone">
												<input type="text" id="search" class="form-control py-3" placeholder="Search Phone Number" aria-label="Search Phone Number" aria-describedby="basic-addon2" name="phone_number" value="{{$phone_number}}">
												@error('phone_number')
												<span class="invalid-feedback d-block">{{$message}}</span>
												@enderror
												<button type="submit" class="btn input-group-text" id="basic-addon2"><i class="fa fa-search"></i></button>
											</div>
										</div>
									</div>



								</div>
							</form>
						</div>

						<!-- Email Information -->
						<div class="email-information">
							<div class="row">
								<div class="col-md-9">

									<form action="{{route('search.submit')}}" method="post" class="mt-3 search-by-email">
										@csrf
										<input type="hidden" name="search_by" value="email">

										<div class="email-search">
											<div class="input-group mb-3">

												<input type="search" id="search" class="form-control py-3" placeholder="Search Email" name="email" aria-label="Search Email" aria-describedby="basic-addon2" value="{{$email ?? ''}}">

												<button type="submit" class="btn input-group-text" id="basic-addon2"><i class="fa fa-search"></i></button>
											</div>
										</div>
									</form>

								</div>
							</div>
						</div>

					</div>
				</div> 


				<div class="phone-number-details py-4">
					<div class="container mt-4">

						@if(!is_null($details_by_phone) && isset($details_by_phone))


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
										<p class="card-text">{{$countries[$country_code].$phone_number}}</p>
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
								@endif
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

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