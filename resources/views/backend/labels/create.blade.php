@extends('backend.layouts.app')
@section('styles')
<style>
	.bootstrap-tagsinput{
		display: block;
		width: 100%;
		padding: 0.375rem 0.75rem;
		font-size: .875rem;
		font-weight: 300;
		line-height: 1.5;
		color: rgba(255,255,255,.75);
		background-color: transparent !important;
		background-clip: padding-box;
		border: 1px solid rgba(255,255,255,.3);
		-webkit-appearance: none;
		-moz-appearance: none;
		appearance: none;
		border-radius: 4px;
		transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
	}
	.bootstrap-tagsinput input{
		color: #fff;
	}
	.bootstrap-tagsinput .tag{
		color: #000 !important;
		background: #3cd2a5;
		font-weight: 400;
		padding-left: 2px;
		border-radius: 4px;
	}
</style>
@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active"><a href="{{route('backend.labels.index')}}">LABELS</a></li>
			<li class="breadcrumb-item active">{{strtoupper('Address Labels')}}</li>
		</ul>
		<h1 class="page-header">Add Address Labels</h1>
	</div>
</div>

@include('backend.layouts.partials.alert-messages')

<div class="card">
	<div class="card-body">
		{{ Form::open(array('route' => 'backend.labels.store', 'id'=>'add-labels-form')) }}
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Address: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('address', null, array('class' => 'form-control', 'placeholder' => 'Address', 'autocomplete' => 'off', 'autofocus')) }}
				@error('address')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Labels: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('labels', null, array('class' => 'form-control js-example-tokenizer', 'placeholder' => 'labels', 'autocomplete' => 'off', 'autofocus','data-role'=>"tagsinput")) }}
				@error('labels')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Currency: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::select('currency', ['btc' => 'BTC', 'eth' => 'ETH'],null,array('class'=>'form-select','autocomplete' => 'off', 'autofocus')) }}
				@error('currency')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12 col-md-12 text-end">
				<button type="submit" class="btn btn-primary">Add</button>
				<a href="{{route('backend.labels.index')}}" class="btn btn-secondary">Back</a>
			</div>
		</div>
		{{ Form::close() }}
	</div>
</div>
@endsection

@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\Backend\BlockchainAddressLabelRequest', '#add-labels-form'); !!}

<script type="text/javascript">
	$('.js-example-tokenizer').tagsinput();
</script>
@endsection