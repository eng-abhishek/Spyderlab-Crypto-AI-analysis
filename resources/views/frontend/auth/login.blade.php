@extends('frontend.layouts.app')

@section('og')
<title>{{config('app.name').' - '.'Login'}}</title>
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

<!-- login -->
<section class="login">
	<div class="login-details container">
		<div class="login-card">
			<div class="button-container">
				<button id="signInBtn" class="{{(Route::currentRouteName() == 'login')?'active':''}}">Sign In</button>
				<button id="signUpBtn" class="{{(Route::currentRouteName() == 'register')?'active':''}}">Sign Up</button>
			</div>

			<!------- SignIn Form ----->

			<div id="signInForm" class="form-container {{(Route::currentRouteName() == 'login')?'active':''}}">

				<div class="user text-center"><i class="fa-regular fa-user fa-2x"></i></div>
				<h2>Log into your account</h2>
				{!! Form::open(['route' => 'login', 'id' => 'login-form', 'class' => 'mt-3']) !!}

		
                          <div class="email-section">
                                <label for="email">Email:<span class="required">*</span></label>
                                <div class="email-group">

                                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                                    @error('email')
					                <span id="email_msg" class="invalid-feedback">{{ $message }}</span>
					                @enderror
                                    <div class="range text-center align-items-center">
                                    <input type="range" class="range-slider" id="showPasswordButton" name="rangeInput" min="0" max="100" value="0">
                                    <label for="showPasswordButton" class="form-label">Slide for Next Step</label>
                                    </div>
                                </div>
                                <div class="error d-none" id="emailError"></div>
                            </div>


				<div class="password-container">
					<label for="password">Password:<span class="required">*</span></label>                        
					{{ Form::password('password', array('id' => 'password', 'placeholder' => 'Enter password' , 'autocomplete'=>'off') ) }}
					@error('password')
					<span class="invalid-feedback">{{ $message }}</span>
					@enderror
				</div>

                <div class="captcha-container">
				<label for="captcha">Captcha:<span class="required">*</span></label>
				{!! NoCaptcha::renderJs() !!}
				{!! NoCaptcha::display(['data-type'=>'image']) !!}

				@error('g-recaptcha-response')
				<span class="error">{{ $message }}</span>               
				@enderror
				</div>

				<div class="login-button">
					<div style="text-align: left; margin-top: 10px;" class="d-flex">
						{{Form::checkbox('remember', true, old('remember') ? 'checked' : '' , ['id' => 'remember-me'])}}
						<label for="remember-me">Remember Me For 60 Days</label>
					</div>
					<button type="submit">Login</button>
				</div>
                 {!! Form::close() !!}
				<div class="meta-mask py-1 text-center">
					<p>OR</p>
					<div class="card meta-mask-section-card">
						<div class="meta-masking d-flex py-1 px-3 justify-content-center">
							<a href="#" onclick="web3Login();"><img src="{{asset('assets/frontend/images/MetaMask_Fox.png')}}" class="px-1" alt="MetaMask">MetaMask</a>
						</div>
						<div class="connect-wallet d-flex py-1 px-3 justify-content-center">
							<a href="#"><img src="{{asset('assets/frontend/images/WalletConnect-Logo.png')}}" class="px-1" alt="Connect Wallet">ConnectWallet</a>
						</div>
					</div>
				</div>

				<div class="social-login py-1 text-center">
					<p>OR</p>
					<div class="icon d-flex text-center justify-content-center">
						<a href="{{route('auth.github')}}" class="social-icon"><i class="fab fa-github"></i></a>
					    <a href="{{route('google.redirect')}}" class="social-icon"><i class="fab fa-google"></i></a>
						
				    {{--
                        <a href="{{route('facebook.redirect')}}" class="social-icon"><i class="fab fa-facebook-f"></i></a>
				    	<a href="#" class="social-icon"><i class="fab fa-apple"></i></a>
						<a href="#" class="social-icon"><i class="fab fa-github"></i></a>
						
						<a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
						<a href="#" class="social-icon"><i class="fab fa-microsoft"></i></a>--}}
					
					</div>
				</div>

				<div class="forgot-password">
					<a href="#" data-bs-toggle="modal" data-bs-target="#forgotpassword">Forgot Password?</a>
				</div>
			</div>


			<!---- Signup Form --->

			<div id="signUpForm" class="form-container {{(Route::currentRouteName() == 'register')?'active':''}}">
				<div class="user text-center"><i class="fa-regular fa-user fa-2x"></i></div>
				<h2>Create a new account</h2>
				{!! Form::open(['route' => 'register', 'id' => 'register-form' ,'class'=>'mt-3']) !!}


				<div class="email-container">
					<label for="email">Email:<span class="required">*</span></label>
					<input type="email" id="email" name="email" placeholder="Enter your Email" required>
					@error('email')
					<span class="invalid-feedback">{{ $message }}</span>
					@enderror
					<div class="range text-center align-items-center">
						<input type="range" class="range-slider" id="showPasswordButtonsignup" name="rangeInput" min="0" max="100" value="0">
						<label for="showPasswordButtonsignup" class="form-label">Slide for Next Step</label>
					</div>
					<div id="emailErrorSignup" class="error d-none"></div>
				</div>

				<div class="other-container">
					<label for="new-username">Username:<span class="required">*</span></label>
					<input type="text" id="new-username" name="username" placeholder="Enter your username" required>
					@error('username')
					<span class="invalid-feedback">{{ $message }}</span>
					@enderror


					<label for="new-password">Password:<span class="required">*</span></label>
					<input type="password" id="new-password" name="password" placeholder="Enter your password" required>

					@error('password')
					<span class="invalid-feedback">{{ $message }}</span>
					@enderror

					<label for="confirm-password">Confirm Password:<span class="required">*</span></label>
					<input type="password" id="confirm-password" name="password_confirmation" placeholder="Confirm your password" required>


					<label for="captcha">Captcha:<span class="required">*</span></label>
					{!! NoCaptcha::renderJs() !!}
					{!! NoCaptcha::display(['data-type'=>'image']) !!}
					@error('g-recaptcha-response')
					<span class="error">{{ $message }}</span>               
					@enderror

				</div>
				<div class="sign-up">
					<button type="submit">Sign Up</button>
				</div>

				{!! Form::close() !!}
			</div>

		</div>
	</div>
</section>

<!-- forgot password modal -->
<!-- Modal -->

<div class="modal fade" id="forgotpassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">

		<div class="modal-content">
			{!! Form::open(['route' => 'password.email', 'id' => 'forgot-password-form']) !!}            
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Forgot Password?</h5>
				<span data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-close fa-2x"></i></span>
			</div>
			<div class="modal-body">

				<label for="email">Email:<span class="required">*</span></label>
				{{ Form::text('email', null, array('id' => 'email', 'class' => 'form-control', 'placeholder' => 'Enter Valid Email Id', 'autocomplete' => 'off')) }}
				@error('email')
				<span class="invalid-feedback">{{ $message }}</span>
				@enderror

				<label for="captcha" class="py-2">Captcha:<span class="required">*</span></label>
				{!! NoCaptcha::renderJs() !!}
				{!! NoCaptcha::display(['data-type'=>'image']) !!}
				@error('g-recaptcha-response')
				<span class="error">{{ $message }}</span>               
				@enderror

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Send Password Reset Link</button>
			</div>
			{!! Form::close() !!}
		</div>

	</div>
</div>


@endsection

@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\LoginRequest', '#login-form'); !!}
{!! JsValidator::formRequest('App\Http\Requests\RegisterRequest', '#register-form'); !!}
{!! JsValidator::formRequest('App\Http\Requests\ForgotPasswordRequest', '#forgot-password-form'); !!}

<script src="https://cdn.ethers.io/lib/ethers-5.2.umd.min.js"></script>

<script type="text/javascript">
	async function web3Login() {
		if (!window.ethereum) {
			alert('MetaMask not detected. Please install MetaMask first.');
			return;
		}

		const provider = new ethers.providers.Web3Provider(window.ethereum);

		var message = '';

		$.ajax({
			type: "get",
			url: "{{url('/web3-login-message')}}",
			async : false,
			success: function (result) {
				if (result.status == 'success') {
					message = result.message;
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
			}
		});

		await provider.send("eth_requestAccounts", []);
		const address = await provider.getSigner().getAddress();
		const signature = await provider.getSigner().signMessage(message);

		$.ajax({
			headers: {
				'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
			},
			type: "post",
			data:{'address' : address, 'signature' : signature},
			url: "{{url('/web3-login-verify')}}",
			success: function (result) {
				if (result.status == 'success') {
					location.href = result.redirect_to;
				}else{
					alert(result.message);
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
			}
		});
	}
</script>
@endsection