@extends('backend.layouts.app')

@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active"><a href="{{route('backend.partners.index')}}">Partners</a></li>
			<li class="breadcrumb-item active">ADD Partners</li>
		</ul>
		<h1 class="page-header">Add Partners</h1>
	</div>
</div>

@include('backend.layouts.partials.alert-messages')

<div class="card">
	<div class="card-body">
		
		{{ Form::open(array('route' => 'backend.partners.store', 'id'=>'add-partners-form', 'class' => 'm-form', 'files' => true)) }}

		<div class="row mb-3 py-2">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Redirect Url: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('url', null, array('class' => 'form-control', 'placeholder' => 'Url', 'autocomplete' => 'off', 'autofocus')) }}
				@error('url')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<div class="row mb-3 py-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Image: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::file('image', ['class'=>'form-control m-input', 'data-preview' => '#view-featured-image']) }}
				<span class="m-form__help">Dimensions : 1280*720</span>
				@error('image')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
				<div class="image-block">
					<img id="view-featured-image" src="" style="display:none;margin-top:10px;max-height: 150px;width: auto;">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12 col-md-12 text-end">
				<button type="submit" class="btn btn-primary">Add</button>
				<a href="{{route('backend.partners.index')}}" class="btn btn-secondary">Back</a>
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
{!! JsValidator::formRequest('App\Http\Requests\Backend\PartnersRequest', '#add-partners-form'); !!}
@endsection