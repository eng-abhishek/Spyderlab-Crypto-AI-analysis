@extends('frontend.layouts.app')

@section('og')
<title>{{config('app.name').' - '.'Reset Password'}}</title>
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
							<li class="breadcrumb-item active">Reset Password</li>
						</ol>
					</nav>
					<h1 class="fs-2 mb-0">Reset Password</h1>
				</div>
			</div>
		</div>
	</section>
	<section class="py-5">
		<div class="container-xl container-fluid">
			<div class="row justify-content-center align-items-center">
				<div class="col-lg-5 col-md-6">
					<div class="form-wrap">
						<h2 class="fs-4 text-center">Reset password</h2>
						<p class="text-center">Enter new password to reset.</p>
						{!! Form::open(['route' => 'password.update', 'id' => 'reset-password-form','class'=>'mt-3']) !!}
						
						{{Form::hidden('token', $token)}}

						{{Form::hidden('email', $email)}}
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

						<div class="row">
							<div class="col-lg-12">
								<input type="submit" class="btn btn-main btn-lg w-100 fw-bold" value="Reset">
							</div>
						</div>
						{!! Form::close() !!}
					</div>
					<div class="my-3 text-center">
						<p class="fw-bold">Already have an account? <a href="{{route('login')}}" class="custom-link">Login</a></p>
					</div>
				</div>
			</div>
		</div>
	</section>
	@error('email')
	<div class="toast-container position-fixed bottom-0 end-0 p-3">
		<div class="toast align-items-center text-bg-danger border-0 fade show" role="alert" aria-live="assertive" aria-atomic="true">
			<div class="d-flex">
				<div class="toast-body">
					{{$message}}
				</div>
				<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
			</div>
		</div>
	</div>
</main>
@endif
@endsection
@section('scripts')
@endsection