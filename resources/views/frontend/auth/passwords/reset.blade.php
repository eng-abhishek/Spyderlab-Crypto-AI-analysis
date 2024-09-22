@extends('frontend.layouts.app')

@section('og')
<title>{{config('app.name').' - '.'Reset'}}</title>
<meta name="title" content="{{config('app.name').' - '.'Change password'}}">
<meta name="description" content="{{settings('site')->meta_description ?? ''}}">
<meta name="keywords" content="{{settings('site')->meta_keywords ?? ''}}">
<meta property="og:image" content="{{asset('assets/frontend/images/spyderlab_featured_image.png')}}" />
@endsection
@section('styles')
<style type="text/css">
.error{
    width: 100%;
    margin-top: .25rem;
    font-size: .875em;
    color: #dc3545;
}
</style>
@endsection
@section('content')
<!-- Reset password modal -->
<div style="height: 500px"></div>
<!-- Modal -->
<div class="modal fade" id="resetpassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Forgot Password?</h5>
				{{--<span data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-close fa-2x"></i></span>--}}
			</div>
			<div class="modal-body">
				{!! Form::open(['route' => 'password.update', 'id' => 'reset-password-form','class'=>'mt-3']) !!}
				{{Form::hidden('token', $token)}}

				{{Form::hidden('email', $email)}}
				<label for="new-password">Password:<span class="required">*</span></label>
				{{ Form::password('password', array('id' => 'new-password', 'class'=>'form-control', 'placeholder' => 'Enter your password' , 'autocomplete'=>'off') ) }}
				@error('password')
				<span class="invalid-feedback">{{ $message }}</span>
				@enderror

				<label for="confirm-password">Confirm Password:<span class="required">*</span></label>
				{{ Form::password('password_confirmation', array('id' => 'confirm-password', 'class'=>'form-control', 'placeholder' => 'Confirm your password' , 'autocomplete'=>'off') ) }}
				@error('password_confirmation')
				<span class="invalid-feedback">{{ $message }}</span>
				@enderror

				
                 <label for="captcha">Captcha:<span class="required">*</span></label>
                 {!! NoCaptcha::renderJs() !!}
                 {!! NoCaptcha::display(['data-type'=>'image']) !!}
                 @error('g-recaptcha-response')
                 <span class="error">{{ $message }}</span>               
                 @enderror

			</div>
			<div class="modal-footer">
				<a href="{{route('login')}}" class="btn btn-secondary">Go to Login</a>
				<button type="submit" class="btn btn-primary">Reset</button>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\ResetPasswordRequest', '#reset-password-form'); !!}
<script type="text/javascript">
	$(document).ready( function(){
		$('#resetpassword').modal('show');
	});
</script>
@endsection