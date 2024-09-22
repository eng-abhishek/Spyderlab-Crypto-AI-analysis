@extends('backend.layouts.app')

@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active"><a href="{{route('backend.plans.index')}}">PLANS</a></li>
			<li class="breadcrumb-item active">ADD CREDIT PLAN</li>
		</ul>
		<h1 class="page-header">Add Credit Plan</h1>
	</div>
</div>

@include('backend.layouts.partials.alert-messages')

<div class="card">
	<div class="card-body">
		{{ Form::open(array('route' => 'backend.plans.store', 'id'=>'add-plan-form')) }}
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Name: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Name', 'autocomplete' => 'off', 'autofocus')) }}
				@error('name')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Slug: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('slug', null, array('class' => 'form-control', 'placeholder' => 'Slug', 'autocomplete' => 'off')) }}
				@error('slug')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Credits: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::number('credits', null, array('class' => 'form-control', 'placeholder' => '0', 'autocomplete' => 'off', 'min' => 1, 'step' => '1')) }}
				@error('credits')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Price: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				<div class="input-group flex-nowrap">
					<span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
					{{ Form::number('price', null, array('class' => 'form-control', 'placeholder' => '0', 'autocomplete' => 'off', 'min' => 0, 'step' => '0.01')) }}
				</div>
				@error('price')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 text-end">
				<button type="submit" class="btn btn-primary">Add</button>
				<a href="{{route('backend.plans.index')}}" class="btn btn-secondary">Back</a>
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
{!! JsValidator::formRequest('App\Http\Requests\Backend\PlanRequest', '#add-plan-form'); !!}
<script type="text/javascript">
	$(document).ready(function(){
		$('input[name="name"]').keyup(function(){
			$('input[name="slug"]').val(slugify($(this).val()));
		});
	});
</script>
@endsection