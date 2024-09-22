@extends('backend.layouts.app')

@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active"><a href="{{route('backend.crypto-monitoring.index')}}">MONITORING</a></li>
			<li class="breadcrumb-item active">EDIT Monitoring</li>
		</ul>
		<h1 class="page-header">EDIT Monitoring</h1>
	</div>
</div>

@include('backend.layouts.partials.alert-messages')

<div class="card">
	<div class="card-body">
		{{ Form::model($record,array('route' => ['backend.crypto-monitoring.update',$record->id], 'id'=>'edit-monitoring-form','files'=>true)) }}
		@method('PUT')
		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Select User: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				<div class="input-group flex-nowrap">
					{{ Form::select('user_id',$user,null,array('class' => 'form-select', 'placeholder' => 'Select User', 'autocomplete' => 'off', 'autofocus')) }}
				</div>
				@error('user_id')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div> 
		</div>

	    <div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Enter Token: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				<div class="input-group flex-nowrap">
					{{ Form::select('token',[''=>'Select Token','BTC'=>'BTC','ETH'=>'ETH'],null,array('class' => 'form-select', 'autocomplete' => 'off', 'autofocus')) }}
                     @error('token')
                     <div class="invalid-feedback d-block">{{ $message }}</div>
                     @enderror
				</div>
				@error('token')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div> 
		</div>

					<div class="row mb-3">
						<div class="col-lg-3 col-md-4">
							<label class="form-label" for="">Address Logo: <span class="text-danger">*</span></label>
						</div>
						<div class="col-lg-9 col-md-8">
							<div class="input-group flex-nowrap">
						
						    {{ Form::file('logo', ['class'=>'form-control m-input', 'data-preview' => '#view-address-image']) }}
							</div>
							@error('logo')
							<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
							<div class="image-block">
							<img id="view-address-image" src="{{$record->image_url}}" style="margin-top:10px;max-height: 150px;width: auto;">
						</div>
						</div>
					</div>

		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Enter Address: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				<div class="input-group flex-nowrap">
					{{ Form::text('address',null,array('class' => 'form-control', 'placeholder' => 'Enter address', 'autocomplete' => 'off', 'autofocus')) }}
				</div>
				@error('address')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div> 
		</div>

		<div class="row mb-3">
			<div class="col-lg-3 col-md-3">
				<label class="form-label" for="">Recipent Email: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-6 col-md-6">
				<ul class="email_list list-unstyled">
					@if(count($email) > 0)
					@foreach($email as $key => $emailData)
					<li>
						<div class="form-check">
							<input class="form-check-input"  type="checkbox" checked name="email_list[]" value="{{$emailData}}" id="{{$key}}">
							<label class="form-check-label" for="{{$key}}">{{$emailData}}</label>
						</div>
					</li>
					@endforeach
					@endif
				</ul>
				@error('email_list')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
			<div class="col-lg-3 col-md-3">
				<button type="button" id="add_email" class="btn btn-primary">Add Email</button>
			</div>
		</div>

		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Enter Description: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				<div class="input-group flex-nowrap">
					{{ Form::textarea('description',null,array('rows'=>'5','class' => 'form-control', 'placeholder' => 'Enter description', 'autocomplete' => 'off', 'autofocus')) }}
				</div>
				@error('description')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div> 
		</div>
		
		<div class="row">
			<div class="col-lg-12 col-md-12 text-end">
				<button type="submit" class="btn btn-primary">Add</button>
				<a href="{{route('backend.crypto-monitoring.index')}}" class="btn btn-secondary">Back</a>
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


<!-- Modal -->
<div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">New Email</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form method="post" action="" id="renewForm">
				@csrf
				<div class="modal-body">

					<div class="row mb-3">
						<div class="col-lg-3 col-md-4">
							<label class="form-label" for="">Recipent Email: <span class="text-danger">*</span></label>
						</div>
						<div class="col-lg-9 col-md-8">
							<div class="input-group flex-nowrap">
								<input type="text" name="recipent_email" class="form-control recipent_email" placeholder="Enter recipent email">
								<button type="button" class="input-group-text btn btn-outline-theme" id="verify_email">Send Code</button>
							</div>
							@error('recipent_email')
							<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>

					<div class="row mb-3 user_veridication_code d-none">
						<div class="col-lg-3 col-md-4">
							<label class="form-label" for="">Verification Code: <span class="text-danger">*</span></label>
						</div>
						<div class="col-lg-9 col-md-8">
							<div class="input-group flex-nowrap">
								<input type="text" name="user_verification_code" class="form-control user_verification_code" placeholder="Enter verification code">
								{{--<span class="input-group-text btn btn-outline-theme verifiy_btn">Verify</span>--}}
							</div>
							@error('user_verification_code')
							<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>

					<div class="row mb-3 timer_start d-none">
						<div class="col-lg-3 col-md-4">
						</div>
						<div class="col-lg-4 col-md-4 timerStart"></div>
						<div class="col-lg-5 col-md-4 resend_btn d-none">
							<button type="button" class="btn btn-outline-theme resend-email">Resend Code</button>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary verifiy_btn">Save changes</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\Backend\MonitoringRequest', '#edit-monitoring-form'); !!}
<script type="text/javascript">
	var myTimer = null;
	var verified_email =0;
	$('#verify_email').on('click',function(){
		var input_email = $('.recipent_email').val();
		//alert(input_email);
		if(input_email == ''){
			$('.recipent_email').addClass('is-invalid');
			return false;
		}

		var EmailRegex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if(EmailRegex.test(input_email) == false){
			$('.recipent_email').addClass('is-invalid');
        	//alert('false');
        	return false;
        }
        $('.recipent_email').removeClass('is-invalid');
        $('.timerStart').html('');
        $.blockUI({ message: 'Please wait...' });
        $.ajax({
        	headers: {
        		'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
        	},
        	type: "post",
        	url: "{{route('backend.send-verification-email')}}",
        	data:{sender_email:input_email},
        	success: function (result) {

        		$.unblockUI();
        		if (result.status == 'success') {

        			$('#verify_email').attr('disabled','disabled');   
        			$('.recipent_email').attr('readonly','readonly');
        			$('.user_veridication_code').removeClass('d-none');
        			$('.timer_start').removeClass('d-none');
        			verified_email = 0;
        			begin();
        			toastr.success(result.message);
        		}else{

        			$('.user_veridication_code').addClass('d-none');
        			$('.timer_start').addClass('d-none');
        			toastr.error(result.message);
        		}
        	},
        	error: function (jqXHR, textStatus, errorThrown) {
        		$.unblockUI();
        	}
        });
    })

	$('.verifiy_btn').on('click',function(){
		var user_code = $('.user_verification_code').val();


		$.blockUI({ message: 'Please wait...' });
		$.ajax({
			headers: {
				'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
			},
			type: "post",
			url: "{{route('backend.match-verification-code')}}",
			data:{user_code:user_code},
			success: function (result) {

				$.unblockUI();
				if (result.status == 'success') {
					$('.recipent_email').val('');
					$('.user_verification_code').val('');
					$('#emailModal').modal('hide');
					$('.user_veridication_code').addClass('d-none');
					$('.timer_start').addClass('d-none');
					$('.email_list').append('<li><div class="form-check"><input class="form-check-input"  type="checkbox" name="email_list[]" value="'+result.email+'" id="'+result.email+'"><label class="form-check-label" for="'+result.email+'">'+result.email+'</label></div></li>');
					
					window.clearInterval(myTimer);
					verified_email = 1;
					toastr.success(result.message);
				} else {
					toastr.error(result.message);
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				$.unblockUI();
			}
		});
	})

	$('.resend-email').on('click',function(){

		$.blockUI({ message: 'Please wait...' });
		$('.timerStart').html('');
		$.ajax({
			headers: {
				'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
			},
			type: "get",
			url: "{{route('backend.resend-email')}}",
			success: function (result) {
				$.unblockUI();
				if (result.status == 'success') {
					$('.user_verification_code').val('');
					$('.resend_btn').addClass('d-none');
					begin();
					toastr.success(result.message);
				} else {
					toastr.error(result.message);
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				$.unblockUI();
			}
		});
	})

	$('#add_email').on('click',function(){
		if(verified_email>0){
			$('#verify_email').removeAttr('disabled');   
			$('.recipent_email').removeAttr('readonly');
		}
		$('.timerStart').html('');
		$('#emailModal').modal('show');
	})


	function begin() {
		timing = 60;
		$('.timerStart').html('You have left: '+timing);
		myTimer = setInterval(function() {
			--timing;
			$('.timerStart').html('You have left: '+timing);
			if (timing === 0) {
				$('.resend_btn').removeClass('d-none');
				clearInterval(myTimer);
			}
		}, 1000);
	}
</script>
@endsection