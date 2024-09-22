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
	['title' => 'Contact us']
	]) 
	!!}
	@endsection
@section('styles')
<style type="text/css">
.error{
    width: 100%;
    margin-top: .25rem;
    font-size: .875em;
    color: #dc3545;
}
</style>
@endsection
	@section('content')
	<section class="contact-us">
		<div class="contact-information py-5">
			<div class="container">
				<div class="contact-form-header text-center py-2">
					<h2 class="contact-title">Contact Us</h2>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="contact-form-section">
							<div class="contact-form card">
								<form action="{{route('contact-us')}}" method="post" class="mt-3" id="contact-form">
									@csrf
									<div class="row gx-3">
										
										<div class="col-md-12 question">
											<label for="question">This question is about:<span class="required">*</span></label>
											<h6>Choose a topic, so we know who to send your request to: </h6>
											<select name="query_type" class="form-select subject">
												<option value="">This question is about...</option>	
												<option value="registering_authorising">Registering/Authorising</option>
												<option value="using_application">Using Application</option>
												<option value="troubleshooting">Troubleshooting</option>
												<option value="backup_restore">Backup/Restore</option>
												<option value="other">Other</option>
											</select>
											
										</div>

										@error('query_type')
											<span class="invalid-feedback">{{ $message }}</span>
											@enderror

										<div class="col-md-6">
											<label for="Name">Your Name:<span class="required">*</span></label>
											<input type="text" name="name" class="form-control name" placeholder="Your Name">
											@error('name')
											<span class="invalid-feedback">{{ $message }}</span>
											@enderror 
										</div>

										<div class="col-md-6">
											<label for="email">Your Email Address:<span class="required">*</span></label>
											<input type="email" name="email_id" class="form-control email" placeholder="Email Address">

											@error('email_id')
											<span class="invalid-feedback">{{ $message }}</span>
											@enderror
										</div>

										<div class="col-md-12">
											<label for="message">Explain your question in details: <span class="required">*</span></label>
											<textarea name="query" id="query" placeholder="I have a problem with..." rows="6" class="form-control" rows="5"></textarea>
											@error('query')
											<span class="invalid-feedback">{{ $message }}</span>
											@enderror
										</div>

										<div class="col-md-12 py-2">
											{!! NoCaptcha::renderJs() !!}
											{!! NoCaptcha::display(['data-type'=>'image']) !!}
											@error('g-recaptcha-response')
											<span class="error">{{ $message }}</span>
											@enderror
										</div>

										<div class="col-md-12 mt-15 form-btn text-right py-2">
											<button type="submit" class="btn btn-primary">Submit Request</button>	
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="contact-details">
							<div class="telegram-section d-flex">
								<i class="fa-brands fa-telegram"></i>
								<span>
									Telegram
									<h4>@spyderlab</h4>
								</span>
							</div>
							<div class="email-section d-flex">
								<i class="fa-solid fa-envelope"></i>
								<span>
									Email
									<h4>info@spyderlab.org</h4>
								</span>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	@endsection
	@section('scripts')
	{!! JsValidator::formRequest('App\Http\Requests\ContactUsRequest', '#contact-form'); !!}
	@endsection