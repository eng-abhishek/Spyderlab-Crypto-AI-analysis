@extends('backend.layouts.app')

@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active"><a href="{{route('backend.user-credits.index')}}">USER CREDITS</a></li>
			<li class="breadcrumb-item active">ADD CREDITS</li>
		</ul>
		<h1 class="page-header">Add Credits</h1>
	</div>
</div>

@include('backend.layouts.partials.alert-messages')

<div class="card">
	<div class="card-body">
		{{ Form::open(array('route' => 'backend.user-credits.store', 'id' => 'add-user-credit-form')) }}
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">User: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::select('user_id', $users->prepend('Select user', ''), null, array('class' => 'form-select m-select2', 'autofocus')) }}
				@error('user_id')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Plan: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				<select name="plan_id" id="plan_id", class="form-select m-select2">
					<option value="" credits="0">Select plan</option>
					@foreach($plans as $plan)
					<option value="{{$plan->id}}" credits="{{$plan->credits}}">{{$plan->name}}</option>
					@endforeach
				</select>
				@error('plan_id')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Credits: </label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::number('credits', null, array('id' => 'credits', 'class' => 'form-control', 'placeholder' => '0', 'autocomplete' => 'off', 'min' => 1, 'step' => '1', 'readonly' => false)) }}
				@error('credits')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 text-end">
				<button type="submit" class="btn btn-primary">Add</button>
				<a href="{{route('backend.user-credits.index')}}" class="btn btn-secondary">Back</a>
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
{!! JsValidator::formRequest('App\Http\Requests\Backend\UserCreditRequest', '#add-user-credit-form'); !!}
<script type="text/javascript">
	$(document).ready(function(){
		$('input[name="name"]').keyup(function(){
			$('input[name="slug"]').val(slugify($(this).val()));
		});

		$(document).on('change', '#plan_id', function(){
			var plan_id = $(this).val();
			var credits = $('option:selected', this).attr('credits');

			if(plan_id == ''){
				$('#credits').val('');
				$('#credits').prop('disabled', false);
			}else{
				$('#credits').val(credits);
				$('#credits').prop('disabled', true);
			}
		});
	});
</script>
@endsection