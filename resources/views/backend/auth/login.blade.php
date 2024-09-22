@extends('backend.layouts.auth')

@section('title', 'Login | '.config('app.name'))

@section('styles')
<style type="text/css">
    .invalid-feedback{
        display: block;
    }
</style>
@endsection

@section('content')
<!-- BEGIN login -->
<div class="login">
    <!-- BEGIN login-content -->
    <div class="login-content">
        <h1 class="text-center">Sign In</h1>
        <div class="text-white text-opacity-50 text-center mb-4">
            For your protection, please verify your identity.
        </div>

        @include('backend.layouts.partials.alert-messages')

        {!! Form::open(['route' => 'backend.login', 'id' => 'login-form']) !!}
        <div class="mb-3">
            <label class="form-label">Email Address <span class="text-danger">*</span></label>
            {{ Form::text('email', null, array('class' => 'form-control form-control-lg bg-white bg-opacity-5', 'placeholder' => 'Email Address', 'autocomplete' => 'off', 'autofocus')) }}
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="mb-3">
            <div class="d-flex">
                <label class="form-label">Password <span class="text-danger">*</span></label>
            </div>
            {{ Form::password('password', array('class'=>'form-control form-control-lg bg-white bg-opacity-5', 'placeholder' => 'Password' , 'autocomplete'=>'off') ) }}
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
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
        <div class="mb-3">
            <div class="form-check">
                {{-- <input class="form-check-input" type="checkbox" value="" id="customCheck1" /> --}}
                {{Form::checkbox('remember', true, old('remember') ? 'checked' : '' , array('class' => 'form-check-input', 'id' => 'customCheck1'))}}
                <label class="form-check-label" for="customCheck1">Remember me</label>
            </div>
        </div>
        <button type="submit" class="btn btn-outline-theme btn-lg d-block w-100 fw-500 mb-3">Sign In</button>
        {!! Form::close() !!}
    </div>
    <!-- END login-content -->
</div>
<!-- END login -->
@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\Backend\LoginRequest', '#login-form'); !!}
<script type="text/javascript">
    $(document).ready(function(){
        //Refresh captcha
        $(document).on('click', '.refresh-captcha', function (e) {
            var this_ele = $(this);
            var url = this_ele.data('url');
            this_ele.find('i').addClass('fa-spin');
            $.ajax({
                url: url,
                type: 'get',
                dataType: 'html',
                success: function (result) {
                    this_ele.find('i').removeClass('fa-spin');
                    $('img.captcha-wraper').attr('src', result);
                    $('input[name="captcha"]').val('');
                },
                error: function (data) {
                    this_ele.find('i').removeClass('fa-spin');
                }
            });
        });
    });
</script>
@endsection