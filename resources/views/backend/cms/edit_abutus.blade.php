@extends('backend.layouts.app')

@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active"><a href="{{route('backend.cms.index')}}">CMS</a></li>
			<li class="breadcrumb-item active">CMS</li>
		</ul>
		<h1 class="page-header">CMS Edit About-us</h1>
	</div>
</div>

@include('backend.layouts.partials.alert-messages')

<div class="card">
	<div class="card-body">
		{{ Form::model($record, array('route' => ['backend.cms.update', $record->id], 'id' => 'edit-cms-form')) }}
		@method('PUT')

		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Slug: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('slug', null, array('class' => 'form-control', 'placeholder' => 'Slug', 'autocomplete' => 'off','readonly', 'autofocus')) }}
				@error('slug')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">About spyderlab: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				
				{{ Form::textarea('about_spyderlab', isset($about_us->about_spyderlab) ? $about_us->about_spyderlab : '', array('class' => 'form-control', 'placeholder' => 'Description here..', 'autocomplete' => 'off', 'autofocus')) }}
				@error('about_spyderlab')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror

				@error('about_spyderlab')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Origins & Team: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::textarea('origins_and_team', isset($about_us->origins_and_team) ? $about_us->origins_and_team : '', array('class' => 'form-control', 'placeholder' => 'Description here..', 'autocomplete' => 'off', 'autofocus')) }}
				@error('origins_and_team')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Developments: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::textarea('developments', isset($about_us->developments) ? $about_us->developments : '', array('class' => 'form-control', 'placeholder' => 'Description here..', 'autocomplete' => 'off', 'autofocus')) }}
				@error('developments')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12 col-md-12 text-end">
				<button type="submit" class="btn btn-primary">Add</button>
				<a href="{{route('backend.cms.index')}}" class="btn btn-secondary">Back</a>
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
{!! JsValidator::formRequest('App\Http\Requests\Backend\BlogCategoryRequest', '#add-cms-form'); !!}
@endsection