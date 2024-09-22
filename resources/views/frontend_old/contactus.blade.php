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

@section('content')
<main>
    <section class="section-home py-5">
        <div class="container-xl container-fluid">
            <div class="row justify-content-center text-center">
                <div class="col-lg-12">
                    <nav>
                        <ol class="breadcrumb justify-content-center mb-3 text-light">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active">Contact Us</li>
                        </ol>
                    </nav>
                    <h1 class="fs-2 mb-0">Contact Us</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-custom-light py-5">
        <div class="container-xl container-fluid">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-12">
                    <div class="form-wrap">
                        <h2 class="fs-4 text-center">Have a question? Send us your query and we will do our best to help you.</h2>
                        <form action="{{route('contact-us')}}" method="post" class="mt-3" id="contact-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="" class="form-label">Name: <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" placeholder="Enter name" class="form-control">
                                    @error('name')
                                    <span class="invalid-feedback">Please enter your name!</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="" class="form-label">Email: <span class="text-danger">*</span></label>
                                    <input type="text" name="email_id" id="email_id" placeholder="Enter email" class="form-control">
                                    @error('email_id')
                                    <span class="invalid-feedback">Please enter your email!</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="" class="form-label">Query: <span class="text-danger">*</span></label>
                                    <textarea name="query" id="query" placeholder="Enter query" class="form-control" rows="5"></textarea>
                                    @error('query')
                                    <span class="invalid-feedback">Please enter your query!</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                {{--<label for="captcha" class="form-label">Captcha : <span class="text-danger">*</span></label>--}}
                                    <div class="d-flex">
                                        <div class="position-relative  flex-grow-1">
                                            <span class="icon-login icon-captcha"></span>
                                        {!! NoCaptcha::renderJs() !!}
                                        {!! NoCaptcha::display(['data-type'=>'image']) !!}
                                        </div>
                                    </div>
                                    @error('g-recaptcha-response')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-main btn-lg w-100 fw-bold">Send Query</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@include('frontend.layouts.partials.alert-message')
</main>
@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\ContactUsRequest', '#contact-form'); !!}
@endsection