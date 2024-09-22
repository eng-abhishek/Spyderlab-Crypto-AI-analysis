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
    ['title' => 'About us']
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
                                <li class="breadcrumb-item active">About Us</li>
                            </ol>
                        </nav>
                        <h1 class="fs-2 mb-0">About Us</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="bg-custom-light py-5">
            <div class="container-xl container-fluid">
                <div class="row justify-content-center align-items-center text-center">
                    <div class="col-md-12">
                        <p class="text-justify">SpyderLab is the leading provider of public information through its dedicated APIs and huge database. It primarily aims to provide deep analytics data at par with the search query in real time. Users can search for publicly posted information on diverse platforms including Facebook, Instagram, Twitter, and WhatsApp through either phone number or email id.</p>  
                        <p class="text-justify">At SpyderLab, we strive to provide information scraping the darknet such as malicious blockchain transactions, cybercrime, criminal activities, drug sales, and other illicit activities. This information is specifically meant for law enforcement agencies to combat increasing cybercrimes. Thousands of sites across multiple darknets are added to our database every day, letting users analyze the data for specific use cases.</p>
                        <a href="#" class="btn btn-pricing my-3">Explore</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="bg-custom-dark py-5">
            <div class="container-xl container-fluid">
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-6">
                        <div class="about-img">
                            <img src="{{asset('assets/frontend/images/about/base.png')}}" class="img-fluid base" alt="">
                            <img src="{{asset('assets/frontend/images/about/spyder.png')}}" class="img-fluid custom" alt="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h2 class="mb-3">Why Are We Unique?</h2>
                        <ul class="list-main list-unstyled">
                            <li>API-focused quick search</li>
                            <li>Whopping database</li>
                            <li>Vast amount of rich darknet data</li>
                            <li>Relevant, searchable, and scalable data</li>
                            <li>Customer-driven data</li>
                            <li>Investigation tools</li>
                            <li>Real-time threat detection</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        @include('frontend.layouts.partials.alert-message')
    </main>
@endsection
@section('scripts')
@endsection