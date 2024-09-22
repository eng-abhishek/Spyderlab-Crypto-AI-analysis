@extends('backend.layouts.app')

@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item">>TELEGRAM</li>
			<li class="breadcrumb-item">PACAKAGE</li>
			<li class="breadcrumb-item active">Edit Telegram Package</li>
		</ul>
		<h1 class="page-header">Edit Telegram Package</h1>
	</div>
</div>

@include('backend.layouts.partials.alert-messages')

<div class="card">
	<div class="card-body">
		
	   {{ Form::model($record, array('route' => ['backend.telegram.package.update', $record->id], 
	   'id'=>'edit-telegram-package-form', 'class' => 'm-form', 'files' => true)) }}
		@method('PUT')

		<div class="row mb-3 py-2">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Name: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Enter package name', 'autocomplete' => 'off', 'autofocus')) }}
				@error('name')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<div class="row mb-3 py-2">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Price In USD: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('price', null, array('class' => 'form-control', 'placeholder' => 'Enter price', 'autocomplete' => 'off', 'autofocus')) }}
				@error('price')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<div class="row mb-3 py-2">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">No of Request: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('no_of_request', null, array('class' => 'form-control', 'placeholder' => 'Enter no of request', 'autocomplete' => 'off', 'autofocus')) }}
				@error('no_of_request')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12 col-md-12 text-end">
				<button type="submit" class="btn btn-primary">Add</button>
				<a href="{{route('backend.telegram.package.index')}}" class="btn btn-secondary">Back</a>
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
{!! JsValidator::formRequest('App\Http\Requests\Backend\TelegramPackageRequest', '#add-tg-package-form'); !!}
@endsection