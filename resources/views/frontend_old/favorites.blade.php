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
    ['title' => 'Favorites']
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
							<li class="breadcrumb-item active">Favorites</li>
						</ol>
					</nav>
					<h1 class="fs-2 mb-0">Favorites</h1>
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
										<h2 class="mb-md-0 mb-3"><i class="fa-light fa-star"></i>  Favorites</h2>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
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
					</div>

					<div class="row">
						<div class="col-lg-12">
							<div class="coin-item my-3 favorites-table">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	@include('frontend.layouts.partials.alert-message')
</main>

@endsection
@section('scripts')
<script type="text/javascript">

	$(function(){
		getData();
	});

	$(document).ready(function() {
		/*Tooltip*/
    // var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    // var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    //     return new bootstrap.Tooltip(tooltipTriggerEl)
    // });
    /*Tooltip*/

	var get_table_data =  @json(route('get-favorite-data'));

	$(document).on('click', '.favorites-table .pagination a', function(event){
		event.preventDefault(); 
		var page = $(this).attr('href').split('page=')[1];
		getData(page,'');
	});


	function getData(page='',search=''){
		
		$.blockUI({ message: 'Please wait...' });

		if(search == ''){
			url = get_table_data+'?page=' + page;
		}else{
			url = get_table_data+'?search=' + search;
		}
		
		$.ajax({
			headers: {
				'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
			},
			type: "get",
			url: url,
			success: function (result) {
                $.unblockUI();
				$('.favorites-table').html(result);
				$('[data-bs-toggle="tooltip"]').tooltip();
			
			}
		});
	}

	/*----------- Filter --------*/
	$('.btnSearch').on('click',function(){

		var search = $('.search').val();
		getData('',search);

	})

	$('.btnReset').on('click',function(){
		$('.search').val('');
		getData();
	})
	});
</script>
@endsection