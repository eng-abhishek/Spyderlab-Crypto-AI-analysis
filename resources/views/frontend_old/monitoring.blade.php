@extends('frontend.layouts.app')

@section('og')
<title>{{ (!empty($seoData->title) && !empty($seoData)) ? $seoData->title : (settings('site')->meta_title ?? config('app.name')) }}</title>
<meta name="title" content="{{ ( !empty($seoData) && !empty($seoData->meta_title)) ? $seoData->meta_title : settings('site')->meta_title ?? ''}}">
<meta name="description" content="{{ ( !empty($seoData) && !empty($seoData->meta_des)) ? $seoData->meta_des :(settings('site')->meta_description ?? '')}}">
<meta name="keywords" content="{{ ( !empty($seoData) && !empty($seoData->meta_keyword)) ? $seoData->meta_keyword : (settings('site')->meta_keywords ?? '') }}">
<meta name="author" content="Osint">
<meta name="robots" content="index follow" />
<link rel="canonical" href="{{url()->current()}}"/>
<meta property="og:type" content="website" />
<meta property="og:title" content="{{ ( !empty($seoData) && !empty($seoData->meta_title)) ? $seoData->meta_title : settings('site')->meta_title ?? ''}}" />
<meta property="og:description" content="{{ (!empty($seoData) && !empty($seoData->meta_des) ) ? $seoData->meta_des :(settings('site')->meta_description ?? '')}}" />
<meta property="og:url" content="{{url()->current()}}"/>
<meta property="og:image" content="{{ !empty($seoData) ?  getNormalImage('featured_image',$seoData->featured_image) : asset('assets/frontend/images/spyderlab_featured_image.png')}}" />
<meta property="og:image:width" content="850">
<meta property="og:image:height" content="560">
<meta property="og:site_name" content="spyderlab" />
<meta property="og:locale" content="en" />
<meta property="twitter:url" content="{{url()->current()}}">
<meta property="twitter:image" content="{{ !empty($seoData) ? getNormalImage('featured_image',$seoData->featured_image) : asset('assets/frontend/images/spyderlab_featured_image.png')}}">
<meta property="twitter:title" content="{{ ( !empty($seoData) && !empty($seoData->meta_title)) ? $seoData->meta_title : settings('site')->meta_title ?? ''}}">
<meta property="twitter:description" content="{{ ( !empty($seoData) && !empty($seoData->meta_des)) ? $seoData->meta_des :(settings('site')->meta_description ?? '')}}">
<meta name="twitter:description" content="{{ ( !empty($seoData) && !empty($seoData->meta_des)) ? $seoData->meta_des :(settings('site')->meta_description ?? '')}}">
<meta name="twitter:image" content="{{ !empty($seoData) ? getNormalImage('featured_image',$seoData->featured_image) : asset('assets/frontend/images/spyderlab_featured_image.png')}}">
<meta name="twitter:card" value="summary_large_image">
<meta name="twitter:site" value="@spyderlab">

{!! organization_jsonld() !!}

{!! breadcrumbs_jsonld([
    ['url' => route('home'), 'title' => 'Home'],
    ['title' => 'Monitoring']
]) 
!!}

@endsection


@section('styles')
<style>.dropdown-toggle.no-caret::before{content: none;}
</style>
@endsection
@section('content')
<main>
	<section class="section-home py-5">
		<div class="container-xl container-fluid">
			<div class="row justify-content-center text-center">
				<div class="col-lg-12">
					<nav>
						<ol class="breadcrumb justify-content-center mb-3 text-light">
							<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
							<li class="breadcrumb-item active">Monitoring</li>
						</ol>
					</nav>
					<h1 class="fs-2 mb-0">Monitoring</h1>
				</div>
			</div>
		</div>
	</section>
	<section class="bg-custom-light py-5">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-2">
					@include('frontend.layouts.partials.account-sidebar')
				</div>
				<div class="col-lg-10">
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="coin-item">
								<div class="row align-items-center">
									<div class="col-md-6 text-md-start text-center">
										<h2 class="mb-md-0 mb-3"><i class="fa-light fa-crosshairs"></i>Monitoring</h2>
									</div>
									<div class="col-md-6 text-md-end text-center">
										<a href="#" class="btn btn-dark addModalbtn" data-bs-toggle="modal" data-bs-target="#addMonitoringModal">Add Monitoring</a>
									</div>
								</div>
							</div>
						</div>
					</div>

					{{--<div class="row">
						<div class="col-lg-12">
							<div class="coin-item my-3">
								<form>
									<div class="row justify-content-between">
										<div class="col-lg-3 col-md-6 col-12">
											<input type="text" class="form-control my-2 search" name="search" placeholder="Search">
										</div>
										<div class="col-lg-3 col-md-6 col-12 text-end">
											<button type="button" class="btn btn-main-2 my-2 btnSearch"><i class="fa-thin fa-magnifying-glass"></i> Search</button>
											<button type="button" class="btn btn-main my-2 btnReset"><i class="fa-light fa-rotate-right"></i> Reset</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>--}}

					<div class="row">
						<div class="col-lg-12">
							<div class="coin-item my-3">
								<form action="" id="form_filter">
									<div class="row">
										<div class="col-xl-4 col-lg-4 col-md-4 col-12 py-3">
											<select name="token" id="token" class="form-control form-select">
												<option value="">Token</option>
												<option value="BTC">Bitcoin (BTC)</option>
												<option value="ETH">Ethereum (ETH)</option>
											</select>
										</div>
										<div class="col-xl-4 col-lg-4 col-md-4 col-12 py-3">
											<select name="status" id="status" class="form-control form-select">
												<option value="">Status</option>
												<option value="Y">Active</option>
												<option value="N">Inactive</option>
											</select>
										</div>
										<div class="col-xl-3 col-lg-12 col-md-12 col-12 py-3 text-xl-end text-center">
											<div class="btn-group w-100">
												<button type="submit" class="btn btn-main-2"><i class="fa-light fa-magnifying-glass"></i> Search</button>
												<button type="reset" class="btn btn-main btnReset"><i class="fa-light fa-arrow-rotate-left"></i> Reset</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<!-- ajax --->
							<div class="coin-item my-3 table-Data">
								<!--- ajax -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--- Toster Message ------>
	<div class="toast-container position-fixed bottom-0 end-0 p-3 ajax-alert-box d-none">
		<div class="toast align-items-center toster-bg border-0 fade show" role="alert" aria-live="assertive" aria-atomic="true">
			<div class="d-flex">
				<div class="toast-body toster-ajax-message">

				</div>
				<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
			</div>
		</div>
	</div>
	@include('frontend.layouts.partials.alert-message')
</main>


<!---  Add Modal --->
<div class="modal fade custom-modal" id="addMonitoringModal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header section-home">
				<h4 class="modal-title fs-6">New Monitoring</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body bg-custom-light">
				<div class="form-wrap">

					{{ Form::open(array('route' => 'monitoring.store', 'id'=>'add-monitoring-form','files' => true)) }}
					@csrf
					<div class="row mb-3">
						<div class="col-lg-3">
							<label for="" class="form-label">Wallet Address: </label>
						</div>
						<div class="col-lg-9">
							<input type="text" class="form-control" name="address" placeholder="Wallet Address">
						</div>
						@error('address')
						<div class="invalid-feedback d-block">{{ $message }}</div>
						@enderror
					</div>
					<div class="row mb-3">
						<div class="col-lg-3">
							<label for="" class="form-label">Token: </label>
						</div>
						<div class="col-lg-9">
							<select class="form-select form-control" name="token">
								<option value="">Select Token</option>
								<option value="BTC">BTC</option>
								<option value="ETH">ETH</option>
							</select>
							@error('token')
							<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>    
					</div>

					<div class="row mb-3">
						<div class="col-lg-3">
							<label for="" class="form-label">Select Logo: </label>
						</div>
						<div class="col-lg-9">
							<input type="file" name="logo" class="form-control">
							@error('logo')
							<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>

					<div class="row mb-3">
						<div class="col-lg-3">
							<label for="" class="form-label">Recipient Email: </label>
						</div>
						<div class="col-lg-9">
							<ul class="email_list list-unstyled mb-0">
								<!-- Loop -->
								<!-- Loop -->
								<li>
									<a href="#" id="add_email" class="custom-link"><i class="fa-light fa-plus"></i> Add Email</a>
								</li>
							</ul>
							@error('email_list')
							<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
						
					</div>
					<div class="row mb-3">
						<div class="col-lg-3">
							<label for="description" class="form-label">Description: </label>
						</div>
						<div class="col-lg-9">
							<textarea name="description" id="description" rows="5" class="form-control" placeholder="Description"></textarea>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12 text-end">
							<button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-main-2">Add</button>
						</div>
					</div>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
</div>

<!--- Edit Modal --->
<div class="modal fade custom-modal" id="editMonitoringModal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header section-home">
				<h4 class="modal-title fs-6">Edit Monitoring</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body bg-custom-light">
				<div class="form-wrap edit-form">

					
				</div>
			</div>
		</div>
	</div>
</div>


<div class="modal fade custom-modal" id="recipientEmailModal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header section-home">
				<h4 class="modal-title fs-6">Recipient Email</h4>
				<button type="button" class="btn-close addMonitoringDynamicModalTop" data-bs-toggle="modal" data-bs-target="#addMonitoringModal"></button>
			</div>
			<div class="modal-body bg-custom-light">
				<div class="form-wrap">
					<form action="">
						<div class="row mb-3">
							<div class="col-lg-3">
								<label for="" class="form-label">Recipient Email: </label>
							</div>
							<div class="col-lg-9">
								<div class="input-group">
									<input type="text" class="form-control recipent_email" name="recipent_email" placeholder="Recipient Email">
									<button type="button" class="btn btn-main" id="verify_email">Send Code</button>
								</div>
							</div>
						</div>
						<div class="row mb-3 user_veridication_code d-none">
							<div class="col-lg-3">
								<label for="" class="form-label">Code: </label>
							</div>
							<div class="col-lg-9">
								<input type="text" class="form-control user_verification_code" name="user_verification_code" placeholder="Code">
							</div>
						</div>
						<div class="row mb-3 justify-content-end">
							<div class="col-lg-9">
								<span class="d-block timerStart">Time Remaining: 5:00</span>
								<button type="button" class="btn btn-main-2 resend_btn d-none">Re-Send Code</button>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 text-end">
								<button type="button" class="btn btn-secondary rounded-0 addMonitoringDynamicModalBottom" data-bs-toggle="modal" data-bs-target="#addMonitoringModal">Close</button>
								<button type="button" class="btn btn-main-2 verifiy_btn">Save</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="toast-container position-fixed bottom-0 end-0 p-3 ajax-alert-box d-none">
	<div class="toast align-items-center toster-bg border-0 fade show" role="alert" aria-live="assertive" aria-atomic="true">
		<div class="d-flex">
			<div class="toast-body toster-ajax-message">

			</div>
			<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
		</div>
	</div>
</div>
@endsection

@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\MonitoringRequest', '#add-monitoring-form'); !!}
{!! JsValidator::formRequest('App\Http\Requests\MonitoringRequest', '#edit-monitoring-form'); !!}
<script type="text/javascript">
	var get_table_data = @json(route('get-monitoring-table-data'));

	$(document).on('click', '.table-Data .pagination a', function(event){
		event.preventDefault(); 
		var page = $(this).attr('href').split('page=')[1];
		getData(page,'');
	});

	$(function(){
		getData();        
	})

	function getData(page='',search=''){
		$.blockUI({ message: 'Please wait...' });
		if(search == ''){
			url = get_table_data+'?page=' + page;
		}else{
			url = get_table_data+'?' + search;
		}

		$.ajax({
			headers: {
				'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
			},
			type: "get",
			url: url,
			success: function (result) {
				$('.table-Data').html(result);
				$('[data-bs-toggle="tooltip"]').tooltip();
				$.unblockUI();
			}
		});
	}

	var myTimer = null;
	var verified_email =0;
	var data_edit = 0;

	$('#verify_email').on('click',function(){
		var input_email = $('.recipent_email').val();

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
        $.blockUI({ message: 'Please wait...' });
        $('.timerStart').html('');
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
        			/* timer */
        			begin();
        			
        			$('.toster-bg').removeClass('text-bg-danger');
        			$('.ajax-alert-box').removeClass('d-none');
        			$('.toster-bg').addClass('show');      
        			$('.toster-bg').addClass('text-bg-success');
        			$('.toster-ajax-message').html(result.message);

        		}else{
        			$('.resend_btn').addClass('d-none');
        			$('.user_veridication_code').addClass('d-none');
        			$('.ajax-alert-box').removeClass('d-none');
        			$('.toster-bg').addClass('show');      
        			$('.toster-bg').addClass('text-bg-danger');
        			$('.toster-ajax-message').html(result.message);
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
					$('#recipientEmailModal').modal('hide');
					$('.recipent_email').val('');
					$('.user_verification_code').val('');
					$('.user_veridication_code').addClass('d-none');
					$('.timer_start').addClass('d-none');
					$('.resend_btn').addClass('d-none');

					
					if(data_edit > 0){

						$('#editMonitoringModal .email_list').append('<li><div class="form-check"><input class="form-check-input"  type="checkbox" name="email_list[]" value="'+result.email+'" id="'+result.email+'"><label class="form-check-label" for="'+result.email+'">'+result.email+'</label></div></li>');

						$('#editMonitoringModal').modal('show');
					}else{

						$('#addMonitoringModal .email_list').append('<li><div class="form-check"><input class="form-check-input"  type="checkbox" name="email_list[]" value="'+result.email+'" id="'+result.email+'"><label class="form-check-label" for="'+result.email+'">'+result.email+'</label></div></li>');

						$('#addMonitoringModal').modal('show');
					}

					window.clearInterval(myTimer);
					verified_email = 1;

					$('.toster-bg').removeClass('text-bg-danger');

					$('.ajax-alert-box').removeClass('d-none');
					$('.toster-bg').addClass('show');      
					$('.toster-bg').addClass('text-bg-success');
					$('.toster-ajax-message').html(result.message);

				}else{
					
					$('.ajax-alert-box').removeClass('d-none');
					$('.toster-bg').addClass('show');      
					$('.toster-bg').addClass('text-bg-danger');
					$('.toster-ajax-message').html(result.message);
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				$.unblockUI();
			}
		});
	})

	$('.resend_btn').on('click',function(){

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
					$('.timerStart').removeClass('d-none');
					$('.resend_btn').addClass('d-none');
					begin();

					$('.toster-bg').removeClass('text-bg-danger');
					$('.ajax-alert-box').removeClass('d-none');
					$('.toster-bg').addClass('show');      
					$('.toster-bg').addClass('text-bg-success');
					$('.toster-ajax-message').html(result.message);

				}else{

					if(result.status == 'error'){
						result.status = 'danger';
					}else{
						result.status = 'success';
					}

					$('.ajax-alert-box').removeClass('d-none');
					$('.toster-bg').addClass('show');      
					$('.toster-bg').addClass('text-bg-danger');
					$('.toster-ajax-message').html(result.message);

				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				$.unblockUI();
			}
		});
	})

	$('.addModalbtn').on('click',function(){
		data_edit = 0;
	});

	$('#add_email').on('click',function(){
		
		$('.addMonitoringDynamicModalTop').attr('data-bs-target','#addMonitoringModal');
		$('.addMonitoringDynamicModalBottom').attr('data-bs-target','#addMonitoringModal');
		

		$('#addMonitoringModal').modal('hide');
		if(verified_email>0){
			$('#verify_email').removeAttr('disabled');   
			$('.recipent_email').removeAttr('readonly');
		}
		$('.timerStart').html('');
		$('#recipientEmailModal').modal('show');
	});

	$(document).on("click",".editAddEmail",function() {
		$('.addMonitoringDynamicModalTop').attr('data-bs-target','#editMonitoringModal');
		$('.addMonitoringDynamicModalBottom').attr('data-bs-target','#editMonitoringModal');

		$('#editMonitoringModal').modal('hide');
		if(verified_email>0){
			$('#verify_email').removeAttr('disabled');   
			$('.recipent_email').removeAttr('readonly');
		}

		$('.timerStart').html('');
		$('#recipientEmailModal').modal('show');

	});

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

	/*--------- Edit Form -------*/
	function getEditData(id){
		var url = $('.editItem'+id).data('url');

		$.ajax({
			headers: {
				'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
			},
			type: "get",
			url: url,
			success: function (result) {
				data_edit = 1;
				$('#editMonitoringModal').modal('show');
				$('.edit-form').html(result);
			}
		});
	}

	/*----------- Filter --------*/

	$('#form_filter').on('submit',function(){
		var $form = $('#form_filter');
		var data = $form.serialize();
		getData('',data);
		return false;
	})


	$('.btnReset').on('click',function(){
		$('.search').val('');
		getData();
	})


	$(document).on( 'click', '#customSwitch1', function () {

		var id = $(this).attr("data-id");
		var is_active; 
		if($('.is_active'+id).is(":checked")){
			is_active='Y';
		}else{
			is_active='N';  
		}

		Swal.fire({
			title: "Are you sure?",
			text: "You won't be able to revert this!",
			type: "warning",
			showCancelButton: true,
			confirmButtonText: "Yes, change it!"
		}).then(function (e) {

			if (e.value) {

				$.blockUI({ message: 'Please wait...' });

				$.ajax({
					url:"{{route('change-monitoring-status')}}",
					method:'post',
					data:{is_active:is_active,id:id,"_token":'{{ csrf_token() }}'},  
					success:function(data){
						if(data.status=='success'){

							$('.toster-bg').removeClass('text-bg-danger');
							$('.ajax-alert-box').removeClass('d-none');
							$('.toster-bg').addClass('show');      
							$('.toster-bg').addClass('text-bg-'+data.status);
							$('.toster-ajax-message').html(data.message);

							$.unblockUI();
						}else{
							$('.is_active'+id).prop("checked",false);
							
							$.unblockUI();
						}

					}
				});
			}else{

				if($('.is_active'+id).is(":checked")){

					$('.is_active'+id).prop("checked",false);
				}else{
					$('.is_active'+id).prop("checked",true);
				}
				swal.fire(
					'Cancelled',
					'Your status do not change:)',
					'error'
					)
			}
		})
	});
</script>
@endsection