@extends('frontend.layouts.app')

@section('og')
<title>{{config('app.name').' - '.'Login'}}</title>
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
                            <li class="breadcrumb-item active">Login</li>
                        </ol>
                    </nav>
                    <h1 class="fs-2 mb-0">Login</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-custom-light py-5">
        <div class="container-xl container-fluid">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-5 col-md-6">
                    <div class="form-wrap">
                        <h2 class="fs-4 text-center">Log into your account</h2>
                        {!! Form::open(['route' => 'login', 'id' => 'login-form', 'class' => 'mt-3']) !!}
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <label for="username" class="form-label">Username : <span class="text-danger">*</span></label>
                                <div class="position-relative">
                                    <span class="icon-login icon-username"></span>
                                    {{ Form::text('username', null, array('id' => 'username', 'class' => 'form-control is-valid', 'placeholder' => 'Enter username', 'autocomplete' => 'off', 'autofocus')) }}
                                </div>
                                @error('username')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-5">
                                        <label for="pass" class="form-label">Password : <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-7 text-end">
                                        <a href="{{route('password.request')}}" title="Forgot password?" class="custom-link fs-7">Forgot password?</a>
                                    </div>
                                </div>
                                <div class="position-relative">
                                    <span class="icon-login icon-username"></span>
                                    {{ Form::password('password', array('id' => 'password', 'class'=>'form-control', 'placeholder' => 'Enter password' , 'autocomplete'=>'off') ) }}
                                </div>
                                @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                            {{--<label for="captcha" class="form-label">Captcha : <span class="text-danger">*</span></label>--}}
                                <div class="d-flex">
                                    <div class="position-relative  flex-grow-1">
                                      {!! NoCaptcha::renderJs() !!}
                                      {!! NoCaptcha::display(['data-type'=>'image']) !!}
                                    </div>
                                </div>
                                @error('g-recaptcha-response')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <div class="form-check">
                                    {{Form::checkbox('remember', true, old('remember') ? 'checked' : '' , ['id' => 'remember', 'class' => 'form-check-input mt-0'])}}
                                    <label class="form-check-label" for="remember">Remember me for 60 days</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <button class="btn btn-main btn-lg w-100 fw-bold">Login</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="my-3 text-center">
                        <p class="fw-bold">Don't have account? <a href="{{route('register')}}" class="custom-link">Sign up</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\LoginRequest', '#login-form'); !!}
<script>
</script>
@endsection