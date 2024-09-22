@extends('frontend.layouts.app')
@section('og')
<title>{{ $post->title ?? ''}}</title>
<meta name="title" content="{{$post->meta_title ?? ''}}">
<meta name="description" content="{{$post->meta_description ?? ''}}">
<meta name="keywords" content="{{$post->meta_keyword ?? ''}}">
<meta name="author" content="Osint">
<meta name="robots" content="index follow" />
<link rel="canonical" href="{{url()->current()}}"/>
<meta property="og:type" content="website" />
<meta property="og:title" content="{{$post->meta_title ?? ''}}" />
<meta property="og:description" content="{{$post->meta_description ?? ''}}" />
<meta property="og:url" content="{{url()->current()}}"/>
<meta property="og:image" content="{{$post->image_url ?? ''}}" />
<meta property="og:image:width" content="850">
<meta property="og:image:height" content="560">
<meta property="og:site_name" content="spyderlab" />
<meta property="og:locale" content="en" />
<meta property="twitter:url" content="{{url()->current()}}">
<meta property="twitter:image" content="{{$post->image_url ?? ''}}">
<meta property="twitter:title" content="{{$post->meta_title ?? ''}}">
<meta property="twitter:description" content="{{$post->meta_description ?? ''}}">
<meta name="twitter:description" content="{{$post->meta_description ?? ''}}">
<meta name="twitter:image" content="{{$post->image_url ?? ''}}">
<meta name="twitter:card" value="summary_large_image">
<meta name="twitter:site" value="@spyderlab">
@if(($post->is_faq == 'Y') && !empty(json_decode($post->faq)))
<script data-n-head="ssr" type="application/ld+json" data-body="true">
	{
		"@context": "https://schema.org",
		"@type": "FAQPage",
		"mainEntity": [
		@php
		$i = 0;
		@endphp
		@foreach(json_decode($post->faq) as $faq)
		{
			@php
			
			$i = $i+1;

			@endphp
			"@type": "Question",
			"name": "{{$faq->key}}",
			"acceptedAnswer": {
			"@type": "Answer",
			"text": "{{$faq->description}}"
		}}@if(count(json_decode($post->faq)) == $i)@else, @endif
		@endforeach
		]}
	</script>
	<script data-n-head="ssr" type="application/ld+json" data-body="true">
		{
			"@context": "https://schema.org",
			"@type": "NewsArticle",
			"headline":"{{$post->title}}",
			"description" : "{{$post->meta_description}}",
			"image": {
			"@type": "ImageObject",
			"url": "{{$post->image_url}}",
			"width": "1280",
			"height": "720"
		},
		"author": {
		"@type": "Person",
		"name": "Spyderlab"
	},
	"publisher": {
	"@type": "Organization",
	"name": "spyderlab",
	"logo": {
	"@type": "ImageObject",
	"url": "https://www.spyderlab.org/assets/frontend/images/icons/logo.png",
	"width": "300",
	"height": "242"
}
},
"datePublished": "{{$post->publish_at}}"
}
</script>
@endif

@endsection
@section('styles')
<style type="text/css">
	.invalid-feedback{
		color:#dc3545 !important;
	}
	.blog-detils-page .sidebar-img img {
		width: 100% !important;
		height: 200px !important;
	}
	.error{
		color:#dc3545 !important;
	}
</style>
@endsection
@section('content')

<!-- blog details -->
<section class="blog-detils-page py-5">
	<div class="container-fluid">
		<div class="blog-detils-page-heading text-center">
			<h2>Blog Details{{$preview}}</h2>
		</div>
		<div class="blog-detils-information py-4">
			<div class="row">
				<div class="col-md-9">
					<div class="card blog-detils-information-card py-2 px-2">
						<div class="card-body">
							<div class="blog-content">
								<div class="main-blog-content">

									@if($post->image_url != '')

									<img src="{{$post->image_url}}" class="img-fluid" alt="{{$post->image_title}}">

									@endif
									<h1>{{$post->title}}</h1>
									<div class="d-flex justify-content-between">

										@if($post->publish_at != '')
										<span class="d-block mb-2"><i class="fa-solid fa-calendar-days px-2"></i>{{\Carbon\Carbon::parse($post->publish_at)->format('d F, Y')}}</span>
										@endif

										<span class="d-block mb-2 px-2 text-end">Updated on: {{\Carbon\Carbon::parse($post->updated_at)->format('d F, Y')}}</span>
									</div>

									<div class="d-flex justify-content-between py-3">
										<kbd class="mx-2">{{$postviews_count}} Views | {{$post_comment_count}} Comments</kbd>
										<span class="d-block mb-2 px-3"><i class="fa-solid fa-user-pen px-2"></i>{{config('app.name')}}</span>
									</div>
									{!! $getFixContent !!}

								</div>       
							</div>
							
							<!-- FAQ -->
							@if(($post->is_faq == 'Y') && !empty(json_decode($post->faq)))
							<div class="faq-blog-details">
								<h2>Frequently Asked Questions</h2>

								@forelse(json_decode($post->faq) as $faq)
								<div class="faq-item">
									<div class="faq-question">
										<span>{{$faq->key}}</span>
										<span class="icon">+</span>
									</div>
									<div class="faq-answer">
										<p>{{$faq->description}}</p>
									</div>
								</div>
								@empty

								@endforelse
							</div>
							@endif

							<!-- Customer Comments -->
							@if($post->post_comment_count > 0)

							<div class="customer-comments py-5">
								<div class="container">
									<h2 class="customer-comments-heading">Comments</h2>
									<div class="top-comments py-4">
										<div class="comments-container">
											@foreach($post->post_comment as $comment)
											<div class="row">
												<div class="top-comments-card mb-4">
													<div class="d-flex customer">
														<span class="customer-name">
															<i class="fa fa-user icon-round"></i>{{$comment->name ?? ''}}
														</span>
														<span class="customer-email">{{$comment->email ?? ''}}</span>
													</div>
													<p class="comments-description">{{$comment->comment ?? ''}}</p>
													<span class="comments-date">{{\Carbon\Carbon::parse($comment->created_at)->format("d M Y")}}</span>
												</div>
											</div>
											@endforeach
										</div>  
									</div>
								</div>
							</div>

							@endif
							<!-- comment form -->
							<div class="blog-comment py-3">
								<div class="container">
									<div class="row justify-content-center">
										<div class="col-md-12">
											<div class="card">
												<div class="card-header">
													<h5>Leave a Comment</h5>
												</div>

												<div class="card-body">
													<form id="commentForm" action="{{route('blog.submit-user-comments',['post_id'=>$post->id])}}" method="POST">
														@csrf
														<div class="mb-3">
															<label for="name" class="form-label">Your Name:</label>
															<input type="text" class="form-control" id="name" name="name" required>

															@error('name')
															<div class="invalid-feedback d-block">{{ $message }}</div>
															@enderror

														</div>
														<div class="mb-3">
															<label for="email" class="form-label">Your Email:</label>
															<input type="email" class="form-control" id="email" name="email" required>

															@error('email')
															<div class="invalid-feedback d-block">{{ $message }}</div>
															@enderror
														</div>

														<div class="mb-3">
															<label for="comment" class="form-label">Your Comment:</label>
															<textarea class="form-control" id="comment" name="comment" rows="5" required></textarea>
															@error('comment')
															<div class="invalid-feedback d-block">{{ $message }}</div>
															@enderror
														</div>

														<div class="mb-3">
															<label for="captcha" class="py-2">Captcha:<span class="required">*</span></label>
															{!! NoCaptcha::renderJs() !!}
															{!! NoCaptcha::display(['data-type'=>'image']) !!}
															@error('g-recaptcha-response')
															<span class="error">{{ $message }}</span>
															@enderror
														</div>

														<div class="text-center">
															<button type="submit" class="btn btn-comment">Submit Comment</button>
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
				<div class="col-md-3">
					<!-- Ads image -->

					@if(count($ads)>1)

					<!-- sidebar image -->
					<div class="card sidebar-img">
						<div id="second-owl-carousel" class="owl-carousel owl-theme">
							@foreach($ads as $ads_data)
							<div class="item">
								<div class="card-body">
									<img src="{{$ads_data->image_url}}" alt="Blog Sidebar">
								</div>
							</div>
							@endforeach
							<!-- Add more items as needed -->
						</div>
					</div>
					<!-- sidebar content  -->
					@else
					<div class="card sidebar-img">
						<div class="card-body">
							@if(!empty($ads) && count($ads) > 0)
							<a href="{{$ads[0]->url}}"><img src="{{$ads[0]->image_url}}"></a>
							@else
							<img src="{{asset('assets/frontend//images/blog-sidebar.webp')}}">
							@endif

						</div>
					</div>
					@endif

					<!-- sidebar content  -->
					<div class="card sidebar-content-table">
						<div class="card-header d-flex justify-content-between" onclick="toggleCardBody()">
							<h4>TABLE OF CONTENT</h4>
							<span id="toggleButton"><i class="fas fa-chevron-down rotate-icon"></i></span>
						</div>
						<div class="card-body" id="cardBody">
							{!! $getTableOfContent !!}
						</div>
					</div>


					<!-- tags -->
					<div class="card tags my-4">
						<div class="card-header">
							#Tags
						</div>
						<div class="card-body">

							@forelse($post->tags as $tags)
							<a href="{{route('blog.blog-tag',$tags->slug)}}" title="">
								<span class="badge rounded-pill bg-tag">
									#{{$tags->name}}</span></a>
									@empty
									@endforelse
								</div>
							</div>

							<!-- subscribe -->
							<div class="card subscribe">
								<div class="card-header">
									<h5>subscribe! for or newsletter</h5>
								</div>
								<div class="card-body subscribe-box py-2">
									<form method="POST" action="{{route('blog.capture_email',['post_id'=>$post->id])}}" id="newsletterForm">
										@csrf
										<div class="form-group px-3 text-center">
											<small id="emailHelp" class="form-text text-muted">We'll never share your email </small>
											<input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" placeholder="Enter Your email">
											@error('email')
											<div class="invalid-feedback d-block">{{ $message }}</div>
											@enderror
										</div>
										<div class="text-center">
											<button type="submit" class="btn btn-primary btn-sm">Send</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		@endsection
		@section('scripts')
		{!! JsValidator::formRequest('App\Http\Requests\BlogCommentRequest', '#commentForm'); !!}
		{!! JsValidator::formRequest('App\Http\Requests\NewsLetterRequest', '#newsletterForm'); !!}
		@endsection