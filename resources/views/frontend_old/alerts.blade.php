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
    ['title' => 'Alerts']
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
							<li class="breadcrumb-item"><a href="index.html">Home</a></li>
							<li class="breadcrumb-item active">Alerts</li>
						</ol>
					</nav>
					<h1 class="fs-2 mb-0">Alerts</h1>
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
									<div class="col-md-12 text-md-start text-center">
										<h2 class="mb-md-0 mb-3"><i class="fa-light fa-sensor-triangle-exclamation"></i> Alerts</h2>
									</div>
								</div>
							</div>
						</div>
					</div>

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
									
										<div class="col-xl-6 col-lg-8 col-md-6 col-12 py-3">
											<div class="input-group">
												<input type="text" name="date_from" id="date_from" class="form-control datepicker" placeholder="Transaction Begin Date" value="{{$start_date}}" readonly>
												<span class="input-group-text">To</span>
												<input type="text" name="date_to" id="date_to" class="form-control datepicker" placeholder="Transaction End Date" value="{{$end_date}}" readonly>
											</div>
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
							<div class="coin-item my-3 table-Data">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>

@endsection
@section('scripts')
<script type="text/javascript">

	$(document).ready(function () {
		$('#date_to').bootstrapMaterialDatePicker({
			format: 'YYYY-MM-DD',
			time: false,
			maxDate: '<?php echo $end_date; ?>',
			minDate : '<?php echo $start_date; ?>',
		});
		$('#date_from').bootstrapMaterialDatePicker({
			format: 'YYYY-MM-DD',
			time: false,
			maxDate: '<?php echo $end_date; ?>',
			minDate : '<?php echo $start_date; ?>',
		}).on('change', function(e, date) {
			$('#date_to').bootstrapMaterialDatePicker('setMinDate', date);
		});
	});


	var get_table_data = @json(route('get-alerts-table-data'));

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

	/*----------- Filter --------*/

	$('#form_filter').on('submit',function(){
		var $form = $('#form_filter');
		var data = $form.serialize();
        


		getData('',data);
		return false;
	})

	$('.btnReset').on('click',function(){
		getData();
	})

</script>
@endsection