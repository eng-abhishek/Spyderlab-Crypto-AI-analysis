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
    ['title' => 'Investigation']
]) 
!!}

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
							<li class="breadcrumb-item active">Investigation</li>
						</ol>
					</nav>
					<h1 class="fs-2 mb-0">Investigation</h1>
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
										<h2 class="mb-md-0 mb-3"><i class="fa-light fa-radar"></i>  Investigation</h2>
									</div>
									<div class="col-md-6 text-md-end text-center">
										@if($chk_user_sub > 0)    
										<a href="#" class="btn btn-dark addModalbtn" data-bs-toggle="modal" data-bs-target="#addMonitoringModal">Add Investigation<span class="badge bg-danger lh-1">PRO</span></a>
										@else
										<a href="{{route('pricing')}}" class="btn btn-dark">Continues with <span class="badge bg-danger lh-1">PRO</span></a>
										@endif
									</div>
								</div>
							</div>
						</div>
					</div>
					@if($chk_user_sub > 0)
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
								<!-- ajax --->
							</div>
						</div>
					</div>
					@else
					<div class="row">
						<div class="col-lg-12">
							<div class="coin-item my-3">
								<div class="text-center">
									<h3 class="mt-5">This features only avaliable for paid user</h3>
									<p> for more click on below button</p>
									<a href="{{route('pricing')}}" class="btn btn-main-2">Click Here<i class="fa-thin fa-external-link p-1"></i></a>           
								</div>
							</div>
						</div>
					</div>
					@endif
				</div>
			</div>
		</div>
	</section>
	@include('frontend.layouts.partials.alert-message')
</main>

<!---  Add Modal --->
<div class="modal fade custom-modal" id="addMonitoringModal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header section-home">
				<h4 class="modal-title fs-6">New Investigation</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body bg-custom-light">
				<div class="form-wrap">

					{{ Form::open(array('route' => 'investigation.store', 'id'=>'add-investigation-form','files' => true)) }}
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

					{{--<div class="row mb-3">
						<div class="col-lg-3">
							<label for="" class="form-label">Select Logo: </label>
						</div>
						<div class="col-lg-9">
							<input type="file" name="logo" class="form-control">
							@error('logo')
							<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>--}}

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
				<h4 class="modal-title fs-6">Edit Investigation</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body bg-custom-light">
				<div class="form-wrap edit-form">


				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\InvestigationRequest', '#add-investigation-form'); !!}
{!! JsValidator::formRequest('App\Http\Requests\InvestigationRequest', '#edit-investigation-form'); !!}

<script type="text/javascript">
	var get_table_data = @json(route('get-investigation-table-data'));

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

	$('.addModalbtn').on('click',function(){
		data_edit = 0;
	});


	$(document).on("click",".editAddEmail",function() {
		$('.addMonitoringDynamicModalTop').attr('data-bs-target','#editMonitoringModal');
		$('.addMonitoringDynamicModalBottom').attr('data-bs-target','#editMonitoringModal');
		$('#editMonitoringModal').modal('hide');

	});

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
					url:"{{route('change-investigation-status')}}",
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