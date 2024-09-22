@extends('frontend.layouts.app')
@section('content')
<main>
	<section class="section-home py-5">
		<div class="container-xl container-fluid">
			<div class="row justify-content-center text-center">
				<div class="col-lg-12">
					<nav>
						<ol class="breadcrumb justify-content-center mb-3 text-light">
							<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
							<li class="breadcrumb-item active">Forgot Password</li>
						</ol>
					</nav>
					<h1 class="fs-2 mb-0">Forgot Password</h1>
				</div>
			</div>
		</div>
	</section>
	<section class="bg-custom-light py-5">
		<div class="container-xl container-fluid">
			<div class="row justify-content-center align-items-center">
				<div class="col-lg-5 col-md-6">
					<div class="form-wrap">
						<h2 class="fs-4 text-center">Forgot Password?</h2>
						<p class="text-center">Enter your Email to reset Password.</p>
						{!! Form::open(['route' => 'password.email', 'id' => 'forgot-password-form']) !!}
						<div class="row mb-3">
							<div class="col-lg-12">
								<label for="email" class="form-label">Email: <span class="text-danger">*</span></label>         
								{{ Form::text('email', null, array('id' => 'email', 'class' => 'form-control', 'placeholder' => 'Enter email', 'autocomplete' => 'off')) }}
								@error('email')
								<span class="invalid-feedback">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<input type="submit" class="btn btn-main btn-lg w-100 fw-bold" value="{{ __('Send Password Reset Link') }}">
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
	@if(session('status'))
	<div class="toast-container position-fixed bottom-0 end-0 p-3">
		<div class="toast align-items-center text-bg-success border-0 fade show" role="alert" aria-live="assertive" aria-atomic="true">
			<div class="d-flex">
				<div class="toast-body">
					{{session('status')}}
				</div>
				<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
			</div>
		</div>
	</div>
	@endif
</main>
@endsection
@section('scripts')

@endsection