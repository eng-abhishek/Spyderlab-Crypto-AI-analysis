@extends('backend.layouts.app')
@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active">{{strtoupper('Wallet Address')}}</li>
		</ul>
		<h1 class="page-header">Add</h1>
	</div>
</div>

@include('backend.layouts.partials.alert-messages')

<div class="card">
	<div class="card-body">
		{{ Form::open(array('route' => 'backend.wallet-addresses.store', 'id' => 'add-wallet-address-form', 'files' => true)) }}
		
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="name">Name: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('name', null, array('id' => 'name', 'class' => 'form-control', 'placeholder' => 'Name', 'autocomplete' => 'off', 'autofocus')) }}
				@error('name')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="image">Image: </label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::file('image', array('id' => 'image', 'class' => 'form-control')) }}
				<span> Note: Please select an image with square resolution for best result!</span>
				<div class="image-block">
					<img id="view-image" src="" class="d-none" style="margin-top:10px;height: 50px;">
				</div>
				@error('image')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="token">Token: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::select('token', config('constants.available_coins'), null, array('id' => 'token', 'class' => 'form-select', 'autocomplete' => 'off')) }}
				@error('token')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="address">Wallet Address: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('address', null, array('id' => 'address', 'class' => 'form-control', 'placeholder' => 'Address', 'autocomplete' => 'off')) }}
				@error('address')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12 col-md-12 text-end">
				<button type="submit" class="btn btn-primary">Add</button>
				<a href="{{route('backend.wallet-addresses.index')}}" class="btn btn-secondary">Back</a>
			</div>
		</div>
		{{ Form::close() }}
	</div>
</div>
@endsection

@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\Backend\WalletAddressRequest', '#add-wallet-address-form'); !!}

<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('change', '#image', function(){
			preview_image();
		});
	});

	function preview_image(){
		var file = $('#image').get(0).files[0];
		var ext = $('#image').val().split('.').pop().toLowerCase();	
		if(file && $.inArray(ext, ['gif','png','jpg','jpeg']) != -1){
			var reader = new FileReader(); 
			reader.onload = function(){
				$("#view-image").removeClass('d-none');
				$("#view-image").attr("src", reader.result);
			}
			reader.readAsDataURL(file);
		}
		else{
			$("#view-image").addClass('shake border border-danger');
			setTimeout(function(){
				$("#view-image").removeClass('shake border border-danger');
			}, 1000);
			$('#image').val('');
		}
	}
</script>
@endsection