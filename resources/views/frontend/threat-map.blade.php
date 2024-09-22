@extends('frontend.layouts.app')
@section('og')
{{-- <title>{{ (!empty($seoData->title) && !empty($seoData)) ? $seoData->title : (settings('site')->meta_title ?? config('app.name')) }}</title>
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
<meta name="twitter:site" value="@spyderlab"> --}}
{!! organization_jsonld() !!}

{!! breadcrumbs_jsonld([
	['url' => route('home'), 'title' => 'Home'],
	['title' => 'Threat Map']
]) 
!!}
@endsection
@section('styles')
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/lucide@latest"></script>
<script type="importmap">
	{
		"imports": {
			"three": "https://unpkg.com/three@0.162.0/build/three.module.js",
			"three/addons/": "https://unpkg.com/three@0.162.0/examples/jsm/"
		}
	}
</script>
@endsection
@section('content')
<section class="contact-us">
	<div class="contact-information py-5">
		<div class="container-fluid">
			<div class="contact-form-header text-center py-2">
				<h2 class="contact-title">Threat Map</h2>
			</div>
			<div class="w-full relative  h-[85vh] bg-black overflow-x-scroll overflow-y-hidden md:!overflow-hidden left-0">
				<div id="globeContainer"></div>
				<div id="tablesContainer" class='absolute h-[15vh] md:h-[20vh]    bottom-3 left-0 w-[99vw] overflow-x-scroll px-2 md:!px-5  md:!overflow-hidden hide-scrollbar  shadow-md rounded-t-lg'>
					<div class='grid relative grid-cols-7 w-[1000px] md:!w-full overflow-y-hidden h-full md:overflow-hidden hide-scrollbar gap-2 md:gap-4'>
						<div class='mb-4 col-span-1 h-full overflow-hidden '>
							<h3 class='p-1 md:p-2 bg-[#2a5266]/50 rounded-lg mriya-bold text-sm md:text-base'>
								Attack Origins
							</h3>
							<div class='grid grid-cols-4 gap-2 md:gap-4   text-xs md:text-sm bg-[#2a5266]/10 text-white p-1 md:p-2 rounded-lg shadow-md'>
								<div class='font-bold mriya-bold'>ID</div>

								<div class='font-bold mriya-bold'>NAME</div>
							</div>
							<div id='attackOrigins' class='bg-[#2a5266]/10 text-white rounded-lg shadow-md mb-1 md:mb-4'>

							</div>
						</div>
						<div class='mb-4 col-span-1 h-full overflow-hidden '>
							<h3 class='p-1 md:p-2  bg-[#2a5266]/50 rounded-lg mriya-bold  text-sm md:text-base'>
								Attack Targets
							</h3>
							<div class='grid grid-cols-4 gap-2 md:gap-4  text-xs md:text-sm bg-[#2a5266]/10 text-white p-1 md:p-2 rounded-lg shadow-md'>
								<div class='font-bold mriya-bold'>ID</div>

								<div class='font-bold col-span-3 mriya-bold'>NAME</div>
							</div>
							<div id='attackTargets' class='bg-[#2a5266]/10 text-white rounded-lg shadow-md mb-2 md:mb-4'>

							</div>
						</div>
						<div class='mb-4 col-span-1 h-full overflow-hidden '>
							<h3 class='p-1 md:p-2 text-sm md:text-base bg-[#2a5266]/50 rounded-lg mriya-bold'>
								Attack Types
							</h3>
							<div class='grid grid-cols-8  text-xs md:text-sm text-start gap-2 md:gap-4 bg-[#2a5266]/10 text-white p-1 md:p-2 rounded-lg shadow-md'>
								<div class='font-bold col-span-2  mriya-bold'>ID</div>
								<div class='font-bold col-span-2  mriya-bold'>PORT</div>
								<div class='font-bold col-span-4 mriya-bold'>TYPE</div>
							</div>
							<div id='attackTypes' class='bg-[#2a5266]/10 text-white rounded-lg shadow-md mb-4'>

							</div>
						</div>

						<div class='mb-4 col-span-4 h-full overflow-hidden '>
							<h3 class='p-1 md:p-2  text-sm md:text-base bg-[#2a5266]/50 rounded-lg  mriya-bold'>
								Live Attacks
							</h3>
							<div class='grid grid-cols-8 w-full gap-2 md:gap-4 text-xs md:text-sm bg-[#2a5266]/10 text-white p-2 rounded-lg shadow-md'>
								<div class='font-bold col-span-1 w-full truncate  mriya-bold'>
									Timestamp
								</div>
								<div class='font-bold col-span-2 mriya-bold'>Attacker</div>
								<div class='font-bold mriya-bold'>Att. IP</div>
								<div class='font-bold mriya-bold'>Att. Geo</div>
								<div class='font-bold mriya-bold'>Tar. Geo</div>
								<div class='font-bold mriya-bold'>Att. Type</div>
								<div class='font-bold mriya-bold'>Port</div>
							</div>
							<div id='liveAttacks' class='bg-[#2a5266]/10 text-white w-full rounded-lg shadow-md mb-4 '>

							</div>
						</div>
					</div>
				</div>

				<div id="scrollLeft" class="absolute top-[76%] left-2 transform md:hidden w-6 h-6 text-white bg-[#2a5266]/50 rounded-full p-1.5 cursor-pointer ">
					<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-left">
						<path d="M6 8L2 12L6 16" />
						<path d="M2 12H22" />
					</svg>
				</div>
				<div id="scrollRight" class="absolute top-[76%] right-2 transform md:hidden w-6 h-6 text-white bg-[#2a5266]/50 rounded-full p-1.5 cursor-pointer ">
					<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-right">
						<path d="M18 8L22 12L18 16" />
						<path d="M2 12H22" />
					</svg>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script src="https://unpkg.com/globe.gl"></script>
<script type="module" src="{{asset('assets/frontend/threat-map/js/script.js')}}"></script>
@endsection