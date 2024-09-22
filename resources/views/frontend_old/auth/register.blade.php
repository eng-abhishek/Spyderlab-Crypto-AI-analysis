@extends('frontend.layouts.app')

@section('og')
<title>{{config('app.name').' - '.'Register'}}</title>
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
							<li class="breadcrumb-item active">Sign Up</li>
						</ol>
					</nav>
					<h1 class="fs-2 mb-0">Sign Up</h1>
				</div>
			</div>
		</div>
	</section>
	<section class="bg-custom-light py-5">
		<div class="container-xl container-fluid">
			<div class="row justify-content-center align-items-center">
				<div class="col-lg-6 col-md-6">
					<div class="form-wrap">
						<h2 class="fs-4 text-center">Create your account</h2>
						<p class="text-center">Disclaimer: This service is strictly for law enforcement agencies/officers use only.</p>
						{!! Form::open(['route' => 'register', 'id' => 'register-form' ,'class'=>'mt-3']) !!}
						<div class="row mb-3">
							<div class="col-lg-12">
								<label for="name" class="form-label">Name: <span class="text-danger">*</span></label>
								{{ Form::text('name', null, array('id' => 'name', 'class' => 'form-control', 'placeholder' => 'Enter name', 'autocomplete' => 'off', 'autofocus')) }}
								@error('name')
								<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-lg-12">
								<label for="username" class="form-label">Username: <span class="text-danger">*</span></label>

								{{ Form::text('username', null, array('id' => 'username', 'class' => 'form-control', 'placeholder' => 'Enter username', 'autocomplete' => 'off')) }}
								@error('username')
								<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-lg-12">
								<label for="email" class="form-label">Email: <span class="text-danger">*</span></label>

								{{ Form::text('email', null, array('id' => 'email', 'class' => 'form-control', 'placeholder' => 'Enter email', 'autocomplete' => 'off')) }}
								@error('email')
								<span class="invalid-feedback">{{ $message }}</span>
								@enderror

							</div>
						</div>
						{{--<div class="row mb-3">
							<div class="col-lg-12">
								<label for="mobile" class="form-label">Phone Number: <span class="text-danger">*</span></label>
								{{ Form::text('mobile', null, array('id' => 'mobile', 'class' => 'form-control', 'placeholder' => 'Enter phone number', 'autocomplete' => 'off')) }}
								@error('mobile')
								<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>--}}
						<div class="row mb-3">
							<div class="col-lg-12">
								<label for="password" class="form-label">Password: <span class="text-danger">*</span></label>
								{{ Form::password('password', array('id' => 'password', 'class'=>'form-control', 'placeholder' => 'Enter Password' , 'autocomplete'=>'off') ) }}
								@error('password')
								<span class="invalid-feedback">{{ $message }}</span>
								@enderror

							</div>
						</div>
						<div class="row mb-3">
							<div class="col-lg-12">
								<label for="password_confirmation" class="form-label">Confirm Password: <span class="text-danger">*</span></label>
								{{ Form::password('password_confirmation', array('id' => 'password_confirmation', 'class'=>'form-control', 'placeholder' => 'Re-enter password' , 'autocomplete'=>'off') ) }}
								@error('password_confirmation')
								<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="mb-3">
							<div class="row">
							{{--<div class="col-2">                                
									<label class="form-label">Captcha <span class="text-danger">*</span></label>
								</div>--}}
								<div class="col-5">
									{!! NoCaptcha::renderJs() !!}
									{!! NoCaptcha::display(['data-type'=>'image']) !!}
								</div>
								@error('g-recaptcha-response')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<button type="submit" class="btn btn-main btn-lg w-100 fw-bold">Signup</button>
							</div>
						</div>
						{!! Form::close() !!}
					</div>
					<div class="my-3 text-center">
						<p class="fw-bold">Aleady have an account? <a href="{{route('login')}}" class="custom-link">Login</a></p>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>
@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\RegisterRequest', '#register-form'); !!}
@endsection
