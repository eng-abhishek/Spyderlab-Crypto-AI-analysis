@extends('backend.layouts.app')

@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active"><a href="{{route('backend.subscription.index')}}">PLANS</a></li>
			<li class="breadcrumb-item active">EDIT SUBSCR</li>
		</ul>
		<h1 class="page-header">Edit Crypto Plan</h1>
	</div>
</div>

@include('backend.layouts.partials.alert-messages')

<div class="card">
	<div class="card-body">
		{{ Form::model($record, array('route' => ['backend.subscription.update', $record->id], 'id' => 'edit-subscription-form')) }}
		@method('PUT')
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">User Name: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				<div class="input-group flex-nowrap">
					{{ Form::text('user_id', $user[0], array('class' => 'form-control', 'placeholder' => 'Name', 'autocomplete' => 'off', 'autofocus','readonly')) }}
				</div>
				@error('user_id')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div> 
		</div>
		
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Select Plan: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				<div class="input-group flex-nowrap">
					{{ Form::select('plan_id', $plan, $record->plan_id, array('class' => 'form-select select_plan', 'placeholder' => 'Select Plan', 'autocomplete' => 'off', 'autofocus')) }}
				</div>
				@error('plan_id')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<div class="row mb-3" id="plan_expiray">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Plan Type: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				<div class="input-group flex-nowrap">
					{{ Form::select('plan_type', ['Y'=>'Yearly','M'=>'Monthly'],$record->plan_type, array('class' => 'form-select plan_expiray', 'placeholder' => 'Plan Type', 'autocomplete' => 'off', 'autofocus')) }}

				</div>
				@error('plan_type')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
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
{!! JsValidator::formRequest('App\Http\Requests\Backend\SubscriptionRequest', '#edit-subscription-form'); !!}

<script type="text/javascript">
	var plan_type = @json($is_free);

	$(function(){
		if(plan_type == 'Y'){
			$('#plan_expiray').addClass('d-none');
			$('.plan_expiray').attr('disabled','disabled');
		}
	});

	$('.select_plan').on('change',function(){

		var id = $('.select_plan').val();

		$.ajax({
			url:"{{route('backend.check-plan-type')}}",
			method:'post',
			data:{id:id,"_token":'{{ csrf_token() }}'},  
			success:function(data){
				console.log(data);
				if(data == 'Y'){
					$('#plan_expiray').addClass('d-none');
					$('.plan_expiray').attr('disabled','disabled');
				}else{
					$('#plan_expiray').removeClass('d-none');
					$('.plan_expiray').removeAttr('disabled','disabled');
				}
			}
		});
	})
</script>
@endsection