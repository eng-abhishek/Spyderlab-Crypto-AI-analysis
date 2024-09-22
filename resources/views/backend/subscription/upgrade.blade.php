@extends('backend.layouts.app')

@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active"><a href="{{route('backend.subscription.index')}}">PLANS</a></li>
			<li class="breadcrumb-item active">UPGRADE SUBSCRIPTION</li>
		</ul>
		<h1 class="page-header">Upgrade Subscription</h1>
	</div>
</div>

@include('backend.layouts.partials.alert-messages')

<div class="card">
	<div class="card-body">
		{{ Form::model($record ,array($record,'route' => ['backend.subscription.upgrade',$record->id], 'id' => 'edit-subscription-form')) }}
		@method('POST')
		
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">User Name: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				<div class="input-group flex-nowrap">
					{{ Form::text('name', $user[0], array('class' => 'form-control', 'placeholder' => 'Name', 'autocomplete' => 'off', 'autofocus','readonly')) }}
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
					{{ Form::select('plan_id', $plan, null, array('class' => 'form-select', 'placeholder' => 'Select Plan', 'autocomplete' => 'off', 'autofocus')) }}
				</div>
				@error('plan_id')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Select Terms:: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				<div class="input-group flex-nowrap">
								<select id="terms_in_month" name="terms_in_month" class="form-select mb-3" onchange="changeTerms(this.value)">
									<option value="1">1 month</option>
									<option value="3">3 month</option>
									<option value="6">6 month</option>
									<option value="12">1 year</option>
									<option value="24">2 year</option>
								</select>
				</div>
				@error('terms_in_month')
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
{!! JsValidator::formRequest('App\Http\Requests\Backend\SubscriptionRequest','#edit-subscription-form'); !!}
@endsection