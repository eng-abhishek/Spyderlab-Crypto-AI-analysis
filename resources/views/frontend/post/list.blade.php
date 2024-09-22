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
    ['title' => 'Blog']
]) 
!!}

@endsection
@section('content')
<!-- blog -->
<section class="main-blog py-5">
    <div class="container-fluid">
        <div class="main-blog-details">
            <div class="main-blog-details-heading text-center">
                <h2>Blog</h2>
            </div>
            <div class="main-blog-card card py-4 px-4">
                <div class="row">
                    <div class="col-md-9">
                        <div class="row">
                         @forelse($posts as $post)
                         <div class="col-md-4">
                            <div class="card main-blog-information">
                                <img src="{{$post->image_url}}" class="img-fluid" alt="{{$post->image_alt}}" class="img-fluid">
                                <div class="card-body">
                                    <span class="d-block mb-2">Date: {{ \Carbon\Carbon::parse($post->publish_at)->format('Y-m-d') }}</span>
                                    <div class="about-blog">
                                        <a href="{{route('blog.details',$post->slug)}}"><h4>
                                            {{\Str::limit(strip_tags(html_entity_decode($post->title)), 80)}}
                                        </h4></a>
                                        <p>{{\Str::limit(strip_tags(html_entity_decode($post->content)), 150)}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-md-12">
                            <div class="card main-blog-information">
                                <h2 class="not-found">Record is not found</h2>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="col-md-3">
                    <div class="card subscribe">
                        <div class="card-header">
                            <h5>Subscribe to our newsletter</h5>
                        </div>
                        <div class="card-body subscribe-box py-2">
                          <form method="POST" action="{{route('blog.capture_email',['post_id'=>$post->id ?? ''])}}" id="newsletterForm">
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

                <div class="card tags my-4">
                    <div class="card-header">
                        #Tags
                    </div>
                    <div class="card-body">
                        @forelse($tags as $tag_list)
                        <a href="{{route('blog.blog-tag',$tag_list->slug)}}"><span class="badge rounded-pill bg-tag">#{{$tag_list->name}}</span></a>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</section>
@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\NewsLetterRequest', '#newsletterForm'); !!}
@endsection