@extends('backend.layouts.app')
@section('styles')
<style>.dropdown-toggle.no-caret::before{content: none;}
.select2-container--default .select2-results>.select2-results__options {
  background-color: #fff; 
  color: #000;
  font-size: .875rem;
  font-weight:400;
}

.select2-container--default .select2-selection--single{
background-color: #e9e9e900; 
padding:1px;
height:36px;
border: 1px solid rgba(255, 255, 255, .3);
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
/* Change this to your desired text color */
color: rgba(255, 255, 255, .75);

}

@media only screen and (max-width:991px){
.select2-container--default .select2-selection--single{
	width: 100%!important;
}
}
</style>
@endsection
@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active"><a href="{{route('backend.subscription.index')}}">PLANS</a></li>
			<li class="breadcrumb-item active">ADD SUBSCRIPTION</li>
		</ul>
		<h1 class="page-header">Add Subscription</h1>
	</div>
</div>

@include('backend.layouts.partials.alert-messages')

<div class="card">
	<div class="card-body">
		{{ Form::open(array('route' => 'backend.subscription.store', 'id'=>'add-subscription-form')) }}
		
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Select User: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				<div class="input-group flex-nowrap">
					<select class="form-select filter_user" name="user_id" sutocomplete="off">
						<option value="">Select User</option>
						@foreach($user as $userData)
						<option value="{{$userData->id}}">{{$userData->username}} {{$userData->email}}</option>
						@endforeach
					</select>
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
					{{ Form::select('plan_id', $plan, null, array('class' => 'form-select select_plan', 'placeholder' => 'Select Plan', 'autocomplete' => 'off', 'autofocus')) }}
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
				<button type="submit" class="btn btn-primary">Add</button>
				<a href="{{route('backend.subscription.index')}}" class="btn btn-secondary">Back</a>
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
{!! JsValidator::formRequest('App\Http\Requests\Backend\SubscriptionRequest', '#add-subscription-form'); !!}
<script type="text/javascript">

	$('.filter_user').select2();

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