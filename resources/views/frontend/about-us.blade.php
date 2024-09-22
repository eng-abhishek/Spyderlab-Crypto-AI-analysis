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
    ['title' => 'About Us']
    ]) 
    !!}

    @endsection
    @section('content')
    <!-- about -->
    <section class="about">
        <div class="container">
            <div class="about-information">
                <div class="row">
                    <div class="col-md-3">
                        <div class="about-img">
                            <img src="{{asset('assets/frontend/images/logo.png')}}">
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="about-description">
                            <h3>About SpyderLab</h3>
                            <p>{{isset($record->about_spyderlab) ? $record->about_spyderlab : '' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="team-development">
        <div class="container">
            <div class="team-development-details py-5">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="team-development-card">
                                <h3>Origins & Team</h3>
                                <p>{{isset($record->origins_and_team) ? $record->origins_and_team : '' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="team-development-card">
                                <h3>Developments</h3>
                                <p>{{isset($record->developments) ? $record->developments : '' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="about-section">
        <div class="container">
            <div class="about-details">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="about-card">
                                <div class="about-logo">
                                    <img src="{{asset('assets/frontend/images/about-logo.svg')}}">
                                </div>
                                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Labore, magnam tempora. Doloribus, explicabo vel veritatis neque eligendi sed err.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="about-card">
                                <div class="about-logo">
                                    <img src="{{asset('assets/frontend/images/about-logo-2.svg')}}">
                                </div>
                                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Labore, magnam tempora. Doloribus, explicabo vel veritatis neque eligendi sed err.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="about-card">
                                <div class="about-logo">
                                    <img src="{{asset('assets/frontend/images/about-logo-3.svg')}}"> 
                                </div>
                                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Labore, magnam tempora. Doloribus, explicabo vel veritatis neque eligendi sed err.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
    @endsection