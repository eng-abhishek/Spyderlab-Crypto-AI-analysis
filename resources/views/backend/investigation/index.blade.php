@extends('backend.layouts.app')
@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active"><a href="{{route('backend.investigation.index')}}">INVESTIGATION</a></li>
			<li class="breadcrumb-item active">Investigation</li>
		</ul>
		<h1 class="page-header">Investigation</h1>
	</div>
</div>

@include('backend.layouts.partials.alert-messages')

<div class="card">
	<div class="card-body">
		<form method="GET" action="{{route('backend.investigation.index')}}" id="add-investigation-form">
			<div class="row mb-3">
				<div class="col-lg-3 col-md-4">
					<label class="form-label" for="">Enter Address: <span class="text-danger">*</span></label>
				</div>
				<div class="col-lg-9 col-md-8">
					<div class="input-group flex-nowrap">
						{{ Form::text('keyword',null,array('class' => 'form-control', 'placeholder' => 'Enter address', 'autocomplete' => 'off', 'autofocus')) }}
					</div>
					@error('keyword')
					<div class="invalid-feedback d-block">{{ $message }}</div>
					@enderror
				</div> 
			</div>
			<div class="row mb-3">
				<div class="col-lg-3 col-md-4">
					<label class="form-label" for="">Select Token: <span class="text-danger">*</span></label>
				</div>
				<div class="col-lg-9 col-md-8">
					<div class="input-group flex-nowrap">
						{{ Form::select('token',[''=>'Select Token','BTC'=>'BTC','ETH'=>'ETH'],null,array('class' => 'form-select', 'autocomplete' => 'off', 'autofocus')) }}
						@error('token')
						<div class="invalid-feedback d-block">{{ $message }}</div>
						@enderror
					</div>
					@error('token')
					<div class="invalid-feedback d-block">{{ $message }}</div>
					@enderror
				</div> 
			</div>
			
			<div class="row">
				<div class="col-lg-12 col-md-12 text-end">
					<button type="submit" class="btn btn-primary">Add</button>
					<a href="{{route('backend.investigation.index')}}" class="btn btn-secondary">Back</a>
				</div>
			</div>
		</form>
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
{!! JsValidator::formRequest('App\Http\Requests\Backend\InvestigationRequest', '#add-investigation-form'); !!}
@endsection