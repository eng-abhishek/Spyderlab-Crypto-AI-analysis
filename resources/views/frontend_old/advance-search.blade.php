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
                                <li class="breadcrumb-item active">Advanced Search</li>
                            </ol>
                        </nav>
                        <h1 class="fs-2 mb-0">Advanced Search</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-3 bg-custom-dark">            
            <div class="container-xl container-fluid">
                <div class="row justify-content-center align-items-center text-center">
                    <div class="col-lg-12 col-md-12">
                        <p class="mb-0">Available Credits: {{available_credits()}} <span class="divider"></span><a href="{{route('pricing')}}" class="btn btn-outline-light btn-sm btn-spyder rounded-0">Buy Credits</a></p>
                    </div>
                </div>
            </div>           
        </section>
        <section class="bg-custom-light py-5">
            <div class="container-xl container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-12 col-md-12">
                        <div class="result-area">
                            <div class="row justify-content-center">
                                <div class="col-lg-9 col-md-12">
                                    <div class="search-result-item mb-3">
                                        <div class="search-result-head">
                                            <h3 class="mb-0">Connected Acoounts</h3>
                                        </div>
                                        <div class="search-result-content">
                                            <h4 class="fs-5">{{$email}}</h4>
                                            @if(!is_null($connected_accounts))
                                            <ul>
                                                @foreach($connected_accounts as $domain)
                                                <li>{{$domain}}</li>
                                                @endforeach
                                            </ul>
                                            @else
                                            No Data Found.
                                            @endif
                                        </div>
                                    </div>
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
    @endsection