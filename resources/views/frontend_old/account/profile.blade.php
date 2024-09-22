@extends('frontend.layouts.app')

@section('og')
<title>{{config('app.name').' - '.'Profile'}}</title>
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
							<li class="breadcrumb-item active">Profile</li>
						</ol>
					</nav>
					<h1 class="fs-2 mb-0">Profile</h1>
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
										<h2 class="mb-md-0 mb-3"><i class="fa-light fa-user-pen"></i> Edit Profile</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="coin-item my-3">
								{{ Form::model($record, array('route' => 'account.profile.update', 'method' => 'post', 'class'=>'mt-3', 'id'=>'update-profile-form', 'files' => true)) }}
								<div class="row mb-3">
									<div class="col-md-12">
										<label for="" class="form-label">Name: <span class="text-danger">*</span></label>
										{{ Form::text('name', null, array('class' => 'form-control', 'id' => 'name', 'placeholder' => 'Enter name', 'autocomplete' => 'off', 'autofocus')) }}
										@error('name')
										<span class="invalid-feedback">{{ $message }}</span>
										@enderror
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-md-12">
										<label for="" class="form-label">Username: <span class="text-danger">*</span></label>

										{{ Form::text('username', null, array('class' => 'form-control', 'id' => 'username', 'placeholder' => 'Enter username')) }}
										@error('username')
										<span class="invalid-feedback">{{ $message }}</span>
										@enderror

									</div>
								</div>
								{{--<div class="row mb-3">
									<div class="col-md-12">
										<label for="" class="form-label">Phone: <span class="text-danger">*</span></label>

										{{ Form::text('mobile', null, array('class' => 'form-control', 'id' => 'mobile', 'placeholder' => 'Enter phone number', 'autocomplete' => 'off')) }}
										@error('mobile')
										<span class="invalid-feedback">{{ $message }}</span>
										@enderror

									</div>
								</div>--}}
								<div class="row mb-3">
									<div class="col-md-12">
										<label for="" class="form-label">Email: <span class="text-danger">*</span></label>
										{{ Form::text('email', null, array('class' => 'form-control', 'id' => 'email', 'placeholder' => 'Enter email', 'autocomplete' => 'off')) }}
										@error('email')
										<span class="invalid-feedback">{{ $message }}</span>
										@enderror
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12 text-center">
										<input type="submit" name="" id="" class="btn btn-main btn-lg w-100 fw-bold" value="Save">
									</div>
								</div>
								{!! Form::close() !!}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	@if(session()->has('status'))
	<div class="toast-container position-fixed bottom-0 end-0 p-3">
		<div class="toast align-items-center text-bg-{{session('status')}} border-0 fade show" role="alert" aria-live="assertive" aria-atomic="true">
			<div class="d-flex">
				<div class="toast-body">
					{{session('message')}}
				</div>
				<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
			</div>
		</div>
	</div>
	@endif
</main>
@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\UpdateProfileRequest', '#update-profile-form'); !!}
@endsection