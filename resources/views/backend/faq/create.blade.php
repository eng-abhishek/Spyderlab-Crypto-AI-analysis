@extends('backend.layouts.app')
@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active"><a href="{{route('backend.ads.index')}}">Faq</a></li>
			<li class="breadcrumb-item active">ADD Faq</li>
		</ul>
		<h1 class="page-header">Add Faq</h1>
	</div>
</div>

@include('backend.layouts.partials.alert-messages')

<div class="card">
	<div class="card-body">
		
		{{ Form::open(array('route' => 'backend.faq.store', 'id'=>'add-faq-form', 'class' => 'm-form', 'files' => true)) }}

		<div class="row mb-3 py-2">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Title: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Enter title', 'autocomplete' => 'off', 'autofocus')) }}
				@error('title')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<div class="form-group m-form__group row mb-3">
			<label class="col-lg-3 col-form-label">Description:</label>
			<div class="col-lg-9">
				{!! Form::textarea('description',null,['class'=>'form-control m-input', 'rows' => 10, 'cols' => 40]) !!}
				@error('description')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12 col-md-12 text-end">
				<button type="submit" class="btn btn-primary">Add</button>
				<a href="{{route('backend.faq.index')}}" class="btn btn-secondary">Back</a>
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
{!! JsValidator::formRequest('App\Http\Requests\Backend\FaqRequest', '#add-faq-form'); !!}
@endsection