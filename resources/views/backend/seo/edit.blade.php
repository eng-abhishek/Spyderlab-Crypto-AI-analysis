@extends('backend.layouts.app')

@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active"><a href="{{route('backend.seo.index')}}">SEO</a></li>
			<li class="breadcrumb-item active">EDIT SEO</li>
		</ul>
		<h1 class="page-header">Edit Seo</h1>
	</div>
</div>

@include('backend.layouts.partials.alert-messages')

<div class="card">
	<div class="card-body">
		{{ Form::model($record, array('route' => ['backend.seo.update', $record->id], 'id'=>'edit-seo-form', 'class' => 'm-form','files'=>true)) }}
		@method('PUT')

		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Slug: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('slug', null, array('class' => 'form-control', 'placeholder' => 'Slug', 'autocomplete' => 'off','readonly')) }}
				@error('slug')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Title: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Title', 'autocomplete' => 'off', 'autofocus')) }}
				@error('title')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Meta Title: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				<div class="input-group flex-nowrap">
			
                    {{ Form::text('meta_title', null, array('class' => 'form-control', 'placeholder' => 'Meta Title', 'autocomplete' => 'off', 'autofocus')) }}

				</div>
				@error('meta_title')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

        <div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Meta Keyword: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				<div class="input-group flex-nowrap">
				{{ Form::text('meta_keyword', null, array('class' => 'form-control', 'placeholder' => 'Meta keyword', 'autocomplete' => 'off', 'autofocus')) }}
				</div>
				@error('meta_keyword')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>
		
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Meta Description: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				<div class="input-group flex-nowrap">
					<textarea name="meta_des" class="form-control" cols="20" rows="5">{!! $record->meta_des !!}</textarea>
				</div>
				@error('meta_des')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Featured Image: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				<div class="input-group flex-nowrap">
					{{ Form::file('featured_image', ['class'=>'form-control m-input', 'data-preview' => '#view-featured-image']) }}
				</div>
				<span class="m-form__help">Dimensions : 1280*720</span>
				@error('featured_image')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
				<div class="image-block">
					<img id="view-featured-image" src="{{getNormalImage('featured_image',$record->featured_image)}}" style="margin-top:10px;max-height: 150px;width: auto;">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12 col-md-12 text-end">
				<button type="submit" class="btn btn-primary">Save</button>
				<a href="{{route('backend.seo.index')}}" class="btn btn-secondary">Back</a>
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
{!! JsValidator::formRequest('App\Http\Requests\Backend\SEORequest','#edit-seo-form'); !!}
<script type="text/javascript">
	      $(function(){

  /* Preview Image */
		$('input[name="featured_image"]').change(function(e) {
			var preview = $(this).data('preview');
			var file = $(this).get(0).files[0];

			if(file){
				var reader = new FileReader();

				reader.onload = function(){
					$(preview).attr("src", reader.result).show();
				}

				reader.readAsDataURL(file);
			}	
		});

	      })
</script>
@endsection