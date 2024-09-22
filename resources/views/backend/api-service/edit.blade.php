@extends('backend.layouts.app')

@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="index.html">DASHBOARD</a></li>
			<li class="breadcrumb-item active"><a href="{{route('backend.api-services.index')}}">API SERVICES</a></li>
			<li class="breadcrumb-item active">{{strtoupper($record->name)}}</li>
		</ul>
		<h1 class="page-header">{{$record->name}}</h1>
	</div>
</div>

@include('backend.layouts.partials.alert-messages')

<div class="card">
	<div class="card-body">
		{{ Form::model($record, array('route' => ['backend.api-services.update', $record->id], 'id'=>'edit-api-service-form', 'files' => true)) }}
		@method('PUT')
		
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Name: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				<p class="form-control">{{$record->name}}</p>
			</div>
		</div>

		@if($record->slug == 'truecaller')
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Auth Key (json file): <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::file('credentials[authkey]', ['class'=>'form-control m-input']) }}
				@error('credentials.authkey')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
				@if(isset($record->credentials['authkey']) && $record->credentials['authkey'] != '')
				<a target="_blank" href="{{route('backend.get-file', ['path' => 'api-services', 'filename' => $record->credentials['authkey'], 'disk' => 'local'])}}">View Authkey</a>
				@endif
			</div>
		</div>

		@elseif($record->slug == 'numverify')
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Api Key: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('credentials[apikey]', null, array('class' => 'form-control', 'placeholder' => 'Api Key', 'autocomplete' => 'off', 'autofocus')) }}
				@error('credentials.apikey')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		@elseif($record->slug == 'facebook')
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">E-Auth (eyecon): <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('credentials[e_auth]', null, array('class' => 'form-control', 'placeholder' => 'E-Auth', 'autocomplete' => 'off', 'autofocus')) }}
				@error('credentials.e_auth')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">E-Auth-V (eyecon): <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('credentials[e_auth_v]', null, array('class' => 'form-control', 'placeholder' => 'E-Auth-V', 'autocomplete' => 'off')) }}
				@error('credentials.e_auth_v')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">E-Auth-C (eyecon): <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('credentials[e_auth_c]', null, array('class' => 'form-control', 'placeholder' => 'E-Auth-C', 'autocomplete' => 'off')) }}
				@error('credentials.e_auth_c')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">E-Auth-K (eyecon): <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('credentials[e_auth_k]', null, array('class' => 'form-control', 'placeholder' => 'E-Auth-K', 'autocomplete' => 'off')) }}
				@error('credentials.e_auth_k')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		@elseif($record->slug == 'twitter')
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Authorization: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('credentials[authorization]', null, array('class' => 'form-control', 'placeholder' => 'Bearer Token', 'autocomplete' => 'off', 'autofocus')) }}
				<div class="form-text">Ex. Bearer abcdefg123...</div>
				@error('credentials.authorization')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		@elseif($record->slug == 'have-i-been-pwned')
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Api Key: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('credentials[apikey]', null, array('class' => 'form-control', 'placeholder' => 'Api Key', 'autocomplete' => 'off', 'autofocus')) }}
				@error('credentials.apikey')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		@elseif($record->slug == 'whatsapp')
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">WA Instance: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('credentials[wa_instance]', null, array('class' => 'form-control', 'placeholder' => 'WA Instance', 'autocomplete' => 'off', 'autofocus')) }}
				@error('credentials.wa_instance')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Api Key: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('credentials[apikey]', null, array('class' => 'form-control', 'placeholder' => 'Api Key', 'autocomplete' => 'off')) }}
				@error('credentials.apikey')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		@elseif($record->slug == 'telegram')
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Api ID: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('credentials[api_id]', null, array('class' => 'form-control', 'placeholder' => 'Api ID', 'autocomplete' => 'off', 'autofocus')) }}
				@error('credentials.api_id')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Api Hash: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('credentials[api_hash]', null, array('class' => 'form-control', 'placeholder' => 'Api Hash', 'autocomplete' => 'off')) }}
				@error('credentials.api_hash')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Phone Number: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('credentials[phone_number]', null, array('class' => 'form-control', 'placeholder' => 'Phone Number', 'autocomplete' => 'off')) }}
				<div class="form-text">Note : Enter phone with country code Ex. +91xxxxxxxxxx</div>
				@error('credentials.phone_number')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<hr>
		<div class="row mb-3">
			{{-- <div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Login Script (Server): </label>
			</div> --}}
			<div class="col-lg-9 col-md-8">
				<div class="form-text">For login to telegram osint tool, Open terminal and run following command</div>
				<p>python3 /var/www/html/laravel-osint/app/Libraries/Telegram/Auth.py</p>
			</div>
		</div>

		@elseif($record->slug == 'chainsight')
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Api Key: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('credentials[apikey]', null, array('class' => 'form-control', 'placeholder' => 'Api Key', 'autocomplete' => 'off', 'autofocus')) }}
				@error('credentials.apikey')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		@endif

		<div class="row">
			<div class="col-lg-12 col-md-12 text-end">
				<button type="submit" class="btn btn-primary">Save</button>
				<a href="{{route('backend.api-services.index')}}" class="btn btn-secondary">Back</a>
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
{!! JsValidator::formRequest('App\Http\Requests\Backend\ApiServiceRequest', '#edit-api-service-form'); !!}
@endsection