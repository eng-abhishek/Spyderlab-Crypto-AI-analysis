@extends('backend.layouts.app')

@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active"><a href="{{route('backend.crypto-plans.index')}}">PLANS</a></li>
			<li class="breadcrumb-item active">EDIT CRYPTO PLAN</li>
		</ul>
		<h1 class="page-header">Edit Crypto Plan</h1>
	</div>
</div>

@include('backend.layouts.partials.alert-messages')

<div class="card">
	<div class="card-body">
		{{ Form::model($record, array('route' => ['backend.crypto-plans.update', $record->id], 'id' => 'edit-plan-form')) }}
		@method('PUT')
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
				<label class="form-label" for="">Is Free Plan: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				<input type="text" name="is_free" class="form-control" value="{{ (($record->is_free == 'Y') ? 'Yes' : 'No' )}}" readonly="">
				@error('is_free')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

        @if($record->is_free == 'Y')

        <div class="row mb-3" id="duration_days">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Durations (In Days): <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				<div class="input-group flex-nowrap">
					<span class="input-group-text"><i class="fas fa-lg fa-fw me-2 fa-clock"></i></span>
					{{ Form::number('duration', null, array('class' => 'form-control duration_days', 'placeholder' => '0', 'autocomplete' => 'off', 'min' => 0, 'step' => '0.01')) }}
				</div>
				@error('duration')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

        @else
         <div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Price (monthly price): <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				<div class="input-group flex-nowrap">
					<span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
					{{ Form::number('monthly_price', null, array('class' => 'form-control', 'placeholder' => '0', 'autocomplete' => 'off', 'min' => 0, 'step' => '0.01')) }}
				</div>
				@error('price')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

	 {{--<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Yearly Price: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				<div class="input-group flex-nowrap">
					<span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
					{{ Form::number('yearly_price', null, array('class' => 'form-control', 'placeholder' => '0', 'autocomplete' => 'off', 'min' => 0, 'step' => '0.01')) }}
				</div>
				@error('price')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>--}}
        @endif
		{{--<div class="row mb-3" id="monthly_price">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Monthly Price: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				<div class="input-group flex-nowrap">
					<span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
					{{ Form::number('monthly_price', null, array('class' => 'form-control monthly_price', 'placeholder' => '0', 'autocomplete' => 'off', 'min' => 0, 'step' => '0.01')) }}
				</div>
				@error('price')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<div class="row mb-3" id="yearly_price">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Yearly Price: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				<div class="input-group flex-nowrap">
					<span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
					{{ Form::number('yearly_price', null, array('class' => 'form-control yearly_price', 'placeholder' => '0', 'autocomplete' => 'off', 'min' => 0, 'step' => '0.01')) }}
				</div>
				@error('price')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>--}}

		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Description: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				<div class="input-group flex-nowrap">
					<textarea name="description" class="form-control" cols="20" rows="5">{!! $record->description !!}</textarea>
				</div>
				@error('description')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<div id="repeater" class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label">Feature: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				<div data-repeater-list="feature">

					@if(!empty($feature))

					@foreach($feature as $key => $otherFeatureVal)

					<div data-repeater-item>						
						<div class="input-group mb-3">
							<input type="text" class="form-control" id="inputFeature" value="{{$otherFeatureVal->feature}}" name="feature[{{ $key }}][feature]" placeholder="Feature">
							<div>
								<button type="button"  data-repeater-delete="" class="btn btn-danger remove-btn"><i class="fa-regular fa-trash-can"></i></button>
							</div>
						</div>
						@error('feature')
						<div class="invalid-feedback d-block">{{ $message }}</div>
						@enderror
					</div>
					@endforeach
					@else
					<div data-repeater-item>						
						<div class="input-group mb-3">
							<input type="text" class="form-control" id="inputFeature" name="feature" placeholder="Feature">
							<div>
								<button type="button"  data-repeater-delete="" class="btn btn-danger remove-btn"><i class="fa-regular fa-trash-can"></i></button>
							</div>
						</div>
						@error('feature')
						<div class="invalid-feedback d-block">{{ $message }}</div>
						@enderror
					</div>
					@endif
				</div>
				<div class="col-lg-12 col-md-12 text-end">
					<button type="button" class="btn btn-outline-theme mb-3" data-repeater-create>Add More Feature</button>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12 col-md-12 text-end">
				<button type="submit" class="btn btn-primary">Save</button>
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
{!! JsValidator::formRequest('App\Http\Requests\Backend\CryptoPlanRequest', '#edit-plan-form'); !!}
<script type="text/javascript">
	var is_free = @json($record->is_free);

	$(document).ready(function(){

    if(is_free == 'Y'){
    
    $('#yearly_price').hide();
    $('#monthly_price').hide();
	$('.yearly_price').attr('disabled','disabled');
	$('.monthly_price').attr('disabled','disabled');

	}else{
    
    $('#yearly_price').show();
    $('#monthly_price').show();
	$('.yearly_price').removeAttr('disabled');
	$('.monthly_price').removeAttr('disabled');

	}

		$('input[name="name"]').keyup(function(){
			$('input[name="slug"]').val(slugify($(this).val()));
		});
	});

	$('#repeater').repeater({
		isFirstItemUndeletable: true,
		//initEmpty:{{empty($feature)?'true':'false'}},
		initEmpty:false,
		show: function() {
			$(this).slideDown();                               
		}
	});

	$('.is_freeplan').on('change',function(){

	if( ($('.is_freeplan').val() == 'Y') ){
    
    $('#yearly_price').hide();
    $('#monthly_price').hide();
	$('.yearly_price').attr('disabled','disabled');
	$('.monthly_price').attr('disabled','disabled');

	}else{
    
    $('#yearly_price').show();
    $('#monthly_price').show();
	$('.yearly_price').removeAttr('disabled');
	$('.monthly_price').removeAttr('disabled');

	}
	})

</script>
@endsection