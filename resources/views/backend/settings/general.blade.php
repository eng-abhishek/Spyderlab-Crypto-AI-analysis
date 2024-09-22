@extends('backend.layouts.app')
@section('styles')
<link href="{{asset('assets/backend/plugins/tagify/tagify.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active">GENERAL SETTINGS</li>
		</ul>
		<h1 class="page-header">General Settings</h1>
	</div>
</div>

@include('backend.layouts.partials.alert-messages')

<div class="card mb-3">
	<div class="card-header">
		<h4>Site Meta</h4>
	</div>
	<div class="card-body">
		{{ Form::open(array('route' => ['backend.settings.update', ['page' => 'general', 'key' => 'site']], 'id'=>'site-setting-form')) }}
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Title: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('title', $settings['site']['title'] ?? null, array('class' => 'form-control', 'placeholder' => 'Title', 'autocomplete' => 'off')) }}
				@error('title')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Meta title: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('meta_title', $settings['site']['meta_title'] ?? null, array('class' => 'form-control', 'placeholder' => 'Meta title', 'autocomplete' => 'off', 'maxlength' => 80, 'id' => 'meta_title', 'data-progressbar' => '#meta-title-progressbar')) }}
				<div class="progress mt-3">
					<div id="meta-title-progressbar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="80"></div>
				</div>
				@error('meta_title')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Meta Description: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{!! Form::textarea('meta_description', $settings['site']['meta_description'] ?? null, ['class'=>'form-control', 'placeholder' => 'Meta description', 'rows' => 3, 'cols' => 50, 'maxlength' => 200, 'id' => 'meta_description', 'data-progressbar' => '#meta-description-progressbar']) !!}
				<div class="progress mt-3">
					<div id="meta-description-progressbar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="200"></div>
				</div>
				@error('meta_description')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Meta Keyword: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{!! Form::textarea('meta_keywords', $settings['site']['meta_keywords'] ?? null, ['class'=>'form-control', 'id' => 'meta_keywords', 'placeholder' => 'Meta keyword', 'rows' => 3, 'cols' => 50]) !!}
				<div class="form-text">Note : Add comma seperated keyword....</div>
				@error('meta_keywords')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<h4>KYC Setting</h4>
		<hr>
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Do you want to make KYC mandatory? : <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				<div class="form-check form-switch">
					<input type="checkbox" name="kyc_mandatory" {{ (isset($settings['site']['kyc_mandatory']) AND $settings['site']['kyc_mandatory'] == 'Y') ? 'checked':''}} class="is_active form-check-input" id="customSwitch1" data-id="">
					<label class="form-check-label" for="customSwitch1"></label>
				</div>
			</div>
		</div>

		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Activation Popup: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				<div class="form-check form-switch">
					<input type="checkbox" name="activation_popup" {{ (isset($settings['site']['activation_popup']) AND $settings['site']['activation_popup'] == 'Y') ? 'checked':''}} class="is_active form-check-input" id="customSwitch1" data-id="">
					<label class="form-check-label" for="customSwitch1"></label>
				</div>
				@error('meta_keywords')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-12 col-md-12 text-end">
				<button type="submit" class="btn btn-primary">Save</button>
			</div>
		</div>
		{{ Form::close() }}
	</div>
	<div class="card-arrow">
		<div class="card-arrow-top-left"></div>
		<div class="card-arrow-top-right"></div>
		<div class="card-arrow-bottom-left"></div>
		<div class="card-arrow-bottom-right"></div>
	</div>
</div>

<div class="card">
	<div class="card-header">
		<h4>Crypto Analysis</h4>
	</div>
	<div class="card-body">
		{{ Form::open(array('route' => ['backend.settings.update', ['page' => 'general', 'key' => 'crypto']], 'id'=>'crypto-analysis-form', 'class' => 'm-form')) }}
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Crypto Analysis Url: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				<div class="input-group">
					<span class="input-group-text">{{url('/').'/'}}</span>
					{{ Form::text('crypto_url', $settings['crypto']['crypto_url'] ?? null, array('class' => 'form-control', 'placeholder' => 'Crypto url', 'autocomplete' => 'off')) }}
				</div>
				<div class="form-text">Note : Allowed only alphabets and numbers.</div>
				@error('crypto_url')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 text-end">
				<button type="submit" class="btn btn-primary">Save</button>
			</div>
		</div>
		{{ Form::close() }}
	</div>
	<div class="card-arrow">
		<div class="card-arrow-top-left"></div>
		<div class="card-arrow-top-right"></div>
		<div class="card-arrow-bottom-left"></div>
		<div class="card-arrow-bottom-right"></div>
	</div>
</div>

<div class="card">
	<div class="card-header">
		<h4>Admin</h4>
	</div>
	<div class="card-body">
		{{ Form::open(array('route' => ['backend.settings.update', ['page' => 'general', 'key' => 'admin']], 'id'=>'admin-setting-form', 'class' => 'm-form')) }}
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Admin Url: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				<div class="input-group">
					<span class="input-group-text">{{url('/').'/'}}</span>
					{{ Form::text('admin_url', $settings['admin']['admin_url'] ?? null, array('class' => 'form-control', 'placeholder' => 'Admin url', 'autocomplete' => 'off')) }}
				</div>
				<div class="form-text">Note : Allowed only alphabets and numbers.</div>
				@error('admin_url')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 text-end">
				<button type="submit" class="btn btn-primary">Save</button>
			</div>
		</div>
		{{ Form::close() }}
	</div>
	<div class="card-arrow">
		<div class="card-arrow-top-left"></div>
		<div class="card-arrow-top-right"></div>
		<div class="card-arrow-bottom-left"></div>
		<div class="card-arrow-bottom-right"></div>
	</div>
</div>



@endsection

@section('scripts')
<script src="{{asset('assets/backend/plugins/tagify/tagify.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/backend/plugins/tagify/tagify.polyfills.min.js')}}" type="text/javascript"></script>
{!! JsValidator::formRequest('App\Http\Requests\Backend\SiteSettingRequest', '#site-setting-form'); !!}
{!! JsValidator::formRequest('App\Http\Requests\Backend\AdminSettingRequest', '#admin-setting-form'); !!}

{!! JsValidator::formRequest('App\Http\Requests\Backend\CryptoSettingRequest', '#crypto-analysis-form'); !!}

<script type="text/javascript">
	$(document).ready(function(){
		$('#meta_title').on('change keydown keyup', function(){
			progressbar($(this));
		});

		$('#meta_description').on('change keydown keyup', function(){
			progressbar($(this));
		});

		$('#meta_title').keyup();
		$('#meta_description').keyup();

		$('#admin-setting-form, #site-setting-form').on('keyup keypress', function(e) {
			var keyCode = e.keyCode || e.which;
			if (keyCode === 13) { 
				e.preventDefault();
				return false;
			}
		});

		new Tagify($('#meta_keywords')[0]);

	});
</script>
@endsection