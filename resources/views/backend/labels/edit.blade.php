@extends('backend.layouts.app')
@section('styles')
<style type="text/css">
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
			<li class="breadcrumb-item"><a href="index.html">DASHBOARD</a></li>
			<li class="breadcrumb-item active"><a href="{{route('backend.labels.index')}}">LABELS</a></li>
			<li class="breadcrumb-item active">{{strtoupper(' Address Labels')}}</li>
		</ul>
		<h1 class="page-header">Edit Address Labels</h1>
	</div>
</div>

@include('backend.layouts.partials.alert-messages')

<div class="card">
	<div class="card-body">
		<form method="post" id="edit-labels-form" action="{{route('backend.labels.update',$record->id)}}">
			@method('PUT')
			@csrf
			<div class="row mb-3">
				<div class="col-lg-3 col-md-4">
					<label class="form-label" for="">Address: <span class="text-danger">*</span></label>
				</div>
				<div class="col-lg-9 col-md-8">
					<input type="text" name="address" value="{{$record->address}}" class="form-control">

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
					<input type="text" name="labels" value="{{$record->labels}}" class="form-control" class="js-example-tokenizer" data-role="tagsinput">
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
					<select name="currency" class="form-select">
						<option {{$record->currency == 'btc' ? 'selected' : ''}} value="btc">BTC</option>
						<option {{$record->currency == 'eth' ? 'selected' : ''}} value="eth">ETH</option>
					</select>
					@error('currency')
					<div class="invalid-feedback d-block">{{ $message }}</div>
					@enderror
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12 col-md-12 text-end">
					<button type="submit" class="btn btn-primary">Save</button>
					<a href="{{route('backend.labels.index')}}" class="btn btn-secondary">Back</a>
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
{!! JsValidator::formRequest('App\Http\Requests\Backend\BlockchainAddressLabelRequest', '#add-labels-form'); !!}
<script type="text/javascript">
	$('.js-example-tokenizer').tagsinput();
</script>
@endsection