@extends('backend.layouts.app')

@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active"><a href="{{route('backend.cms.index')}}">CMS</a></li>
			<li class="breadcrumb-item active">CMS</li>
		</ul>
		<h1 class="page-header">CMS Edit Partner</h1>
	</div>
</div>

@include('backend.layouts.partials.alert-messages')

<div class="card">
	<div class="card-body">
	{{ Form::model($record, array('route' => ['backend.cms.update', $record->id], 'id' => 'edit-cms-form','files' => true)) }}
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


<!-----------   partner 01 ------------>
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Image: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
                {{ Form::file('image', ['class'=>'form-control m-input']) }}
				@error('about_spyderlab')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Url: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('url', null, array('class' => 'form-control', 'placeholder' => 'Enter url here..', 'autocomplete' => 'off', 'autofocus')) }}
				@error('url')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>
<!-----------   end partner 01 ------------>

<!-----------   partner 02 ------------>
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Image: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
                {{ Form::file('image', ['class'=>'form-control m-input']) }}
				@error('about_spyderlab')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Url: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('url', null, array('class' => 'form-control', 'placeholder' => 'Enter url here..', 'autocomplete' => 'off', 'autofocus')) }}
				@error('url')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>
<!-----------   end partner 01 ------------>

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