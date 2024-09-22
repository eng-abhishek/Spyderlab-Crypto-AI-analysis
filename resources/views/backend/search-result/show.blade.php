@extends('backend.layouts.app')
@section('styles')
<style type="text/css">
	.invalid-feedback{
		display: block;
	}
	.result-area .avatar{
		width: 120px;
		height: 120px;
		border-radius: 50%;
		object-fit: cover;
		padding: 2px;
	}
	.result-area h4{
		font-size: 18px;
		font-weight: 400;
	}
	.border-spyder{
		border: 1px solid #575962;
	}
	.result-image img{
		width: 160px;
		height: 160px;
		object-fit: cover;
		border-radius: 50%;
		margin-bottom: 16px;
	}
	.result-details .card{
		background: transparent;
		border-color: #575962;
	}
	.result-details .card-header{
		background: transparent;
		border-color: #575962;
	}
	.result-details img{
		width: 100px;
		height: 100px;
		object-fit: cover;
		border-radius: 50%;
	}
	.result-details ul{
		margin-bottom: 0;
	}
	.result-details .text-muted{
		color: #979797 !important;
	}
</style>
@endsection

@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active">HISTORY</li>
			<li class="breadcrumb-item active">DETAILS</li>
		</ul>                    
		<h1 class="page-header">
			@if($record->search_key == 'phone')
			Search History : {{$record->country->phone_code.$record->search_value}}
			@else
			Search History : {{$record->search_value}}
			@endif
		</h1>
	</div>
	<div class="ms-auto">
		<form action="{{route('backend.search-results.get-latest-data', $record->id)}}" method="post">
			@csrf
			<a href="javascript:;" class="btn btn-outline-theme" id="update_result_data"> Update</a>
		</form>
	</div>
</div>

@include('backend.layouts.partials.alert-messages')

<div class="row justify-content-center align-items-center py-3">
	<div class="col-xxl-12 col-xl-12 col-lg-12 mb-3">
		<div class="result-area">
			
			@if($record->status_code != '200' || is_null($record->result))
			<!-- No result start-->
			<div class="row justify-content-center">
				<div class="col-xl-4 col-lg-5 col-md-6 text-center">
					<div class="no-result">
						<img src="{{ asset('assets/backend/images/no-result.png')}}" alt="">
						<h3>No results found!</h3>
					</div>
				</div>
			</div>
			<!-- No result end-->
			
			@else

			@php
			$result = json_decode($record->result);
			@endphp
			<div class="row justify-content-between align-items-start">
				<div class="col-md-4">
					<div class="card mb-3">
						<div class="card-body">
							<div class="text-center">
								<div class="result-image">
									<img src="{{current($result->images)}}" alt="avatar">
								</div>
								<h4 class="text-break">{{current((array)$result->names) != '' ? current((array)$result->names) : 'Not Found'}}</h4>
								@if($record->search_key == 'phone')
								<h4 class="text-break">{{$record->country->phone_code.$record->search_value}}</h4>
								@else
								<h4 class="text-break">{{$record->search_value}}</h4>
								@endif
							</div>
						</div>
						<div class="card-arrow">
							<div class="card-arrow-top-left"></div>
							<div class="card-arrow-top-right"></div>
							<div class="card-arrow-bottom-left"></div>
							<div class="card-arrow-bottom-right"></div>
						</div>
					</div>                                
				</div>
				<div class="col-md-8">
					<div class="result-details mb-3">                                        
						<div class="card rounded-0 mb-3">
							<div class="card-header rounded-0">
								Images
							</div>
							<div class="card-body">
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
							<div class="card-arrow">
								<div class="card-arrow-top-left"></div>
								<div class="card-arrow-top-right"></div>
								<div class="card-arrow-bottom-left"></div>
								<div class="card-arrow-bottom-right"></div>
							</div>
						</div>
						<div class="card rounded-0 mb-3">
							<div class="card-header rounded-0">
								AKA / Alias
							</div>
							<div class="card-body">
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
							<div class="card-arrow">
								<div class="card-arrow-top-left"></div>
								<div class="card-arrow-top-right"></div>
								<div class="card-arrow-bottom-left"></div>
								<div class="card-arrow-bottom-right"></div>
							</div>
						</div>

						<div class="card rounded-0 mb-3">
							<div class="card-header rounded-0">
								Email
							</div>
							<div class="card-body">
								@if(count((array)$result->emails) > 0)
								<ul>
									{{-- <li>johndoe@gmail.com <a href="#" class="ms-2 fs-6">Pwned?</a> | <a href="#" class="fs-6">Advance Lookup</a></li> --}}
									@foreach($result->emails as $from => $email_obj)
									@if($email_obj->breached != '')
									<li>{{$email_obj->email." (".$email_obj->breached.")"}} <a target="_blank" href="{{route('advance-search')}}?email={{$email_obj->email}}" class="fs-6">Advance Lookup</a></li>
									@else
									<li>{{$email_obj->email}} <a target="_blank" href="{{route('advance-search')}}?email={{$email_obj->email}}" class="fs-6">Advance Lookup</a></li>
									@endif
									@endforeach
								</ul>
								@else
								<span>Not found</span>
								@endif
							</div>
							<div class="card-arrow">
								<div class="card-arrow-top-left"></div>
								<div class="card-arrow-top-right"></div>
								<div class="card-arrow-bottom-left"></div>
								<div class="card-arrow-bottom-right"></div>
							</div>
						</div>
						<div class="card rounded-0 mb-3">
							<div class="card-header rounded-0">
								Address
							</div>
							<div class="card-body">
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
							<div class="card-arrow">
								<div class="card-arrow-top-left"></div>
								<div class="card-arrow-top-right"></div>
								<div class="card-arrow-bottom-left"></div>
								<div class="card-arrow-bottom-right"></div>
							</div>
						</div>
						<div class="card rounded-0 mb-3">
							<div class="card-header rounded-0">
								Phone No. Details
							</div>
							<div class="card-body">
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
							<div class="card-arrow">
								<div class="card-arrow-top-left"></div>
								<div class="card-arrow-top-right"></div>
								<div class="card-arrow-bottom-left"></div>
								<div class="card-arrow-bottom-right"></div>
							</div>
						</div>
						<div class="card rounded-0 mb-3">
							<div class="card-header rounded-0">
								Social Media
							</div>
							<div class="card-body">
								<div class="d-flex justify-content-between align-items-start my-3">
									<div>
										<h4>Facebook</h4>
										@if($result->facebook != null)
										<ul>
											<li><span class="text-muted">Username:</span> {{$result->facebook->username." - eyecon"}}</li>
											<li><span class="text-muted">Link:</span> <a href="{{$result->facebook->profile_url}}" target="_blank">Visit</a> - eyecon</li>
										</ul>
										@else
										<span>Not found</span>
										@endif
									</div>
								</div>
								<hr>
								<div class="my-3">
									<h4>Twitter</h4>
									{{-- <ul>
										<li><span class="text-muted">Handle:</span> johndoe</li>
										<li><span class="text-muted">Link:</span> <a href="#">Visit</a></li>
									</ul> --}}
									<span>Not found</span>
								</div>
								<hr>
								<div class="my-3">
									<h4>Telegram</h4>
									{{-- <ul>
										<li><span class="text-muted">Username:</span> johndoe</li>
										<li><span class="text-muted">Link:</span> <a href="#">Visit</a></li>
									</ul> --}}
									<span>Not found</span>
								</div>
								<hr>
								<div class="my-3">
									<h4>Whatsapp</h4>
									{{-- <ul>
										<li><span class="text-muted">Status:</span> Active</li>
									</ul> --}}
									<span>Not found</span>
								</div>
							</div>
							<div class="card-arrow">
								<div class="card-arrow-top-left"></div>
								<div class="card-arrow-top-right"></div>
								<div class="card-arrow-bottom-left"></div>
								<div class="card-arrow-bottom-right"></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			@endif
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$('#update_result_data').click(function(){
			$(this).parents('form').submit();
		});
	});
</script>
@endsection