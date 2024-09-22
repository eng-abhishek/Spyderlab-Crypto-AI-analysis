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
                                <li class="breadcrumb-item active"><a href="{{route('blockchain-analysis')}}">Blockchain Analysis</a></li>
                                <li class="breadcrumb-item active">Search Result</li>
                            </ol>
                        </nav>
                        <h1 class="fs-2 mb-0">Search Result</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="bg-custom-light py-5">
            <div class="container-xl container-fluid">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-12 col-md-12">
                        <h2 class="fs-4">{{count($results)}} Result(s)</h2>
                        {{-- <div id="chartResult2"></div>
                        <div id="chartResult1"></div>
                        <div id="chartResult0"></div> --}}
                        @foreach($results as $result)

                        <div class="listing-wrap my-3 px-md-0 px-3">
                            <div class="d-flex justify-content-between align-items-stretch flex-md-row flex-column">

                                @if($result->anti_fraud->credit == 1)

                                <div class="listing-result me-md-3 my-md-0 my-3 me-auto ms-auto mb-md-0 mb-3 d-flex justify-content-center flex-column">
                                    <p class="mb-1">AML Risk Factor</p>
                                    <img src="{{asset('assets/frontend/images/icons/aml-safe.jpg')}}">
                                    <span>Success</span>
                                </div>

                                @elseif($result->anti_fraud->credit == 2)

                                <div class="listing-result me-md-3 my-md-0 my-3 me-auto ms-auto mb-md-0 mb-3 d-flex justify-content-center flex-column">
                                  <p class="mb-1">AML Risk Factor</p>
                                  <img src="{{asset('assets/frontend/images/icons/aml-risk.jpg')}}">
                                  <span>Cautious</span>
                              </div>

                              @elseif($result->anti_fraud->credit == 3)

                              <div class="listing-result me-md-3 my-md-0 my-3 me-auto ms-auto mb-md-0 mb-3 d-flex justify-content-center flex-column">
                                  <p class="mb-1">AML Risk Factor</p>
                                  <img src="{{asset('assets/frontend/images/icons/aml-warning.jpg')}}">
                                  <span>Warning</span>
                              </div>

                              @endif

                              <div class="flex-grow-1 text-md-start text-center my-1 d-flex justify-content-center flex-column">
                                <ul class="list-unstyled mb-0">
                                    <li>Type: <span>{{$result->type}}</span></li>
                                    @if(!empty($result->chain))
                                    <li>Chain: <span>{{$result->chain->name}}</span></li>
                                    @elseif(!empty($result->url))
                                    <li>URL: <span>{{$result->url}}</span></li>
                                    @elseif(!empty($result->domain))
                                    <li>Domain: <span>{{$result->domain}}</span></li>
                                    @elseif(!empty($result->ip))
                                    <li>Ip: <span>{{$result->ip}}</span></li>
                                    @endif

                                    @if(!empty($result->address))
                                    <li class="text-break">Address: <span>{{$result->address}}</span></li>
                                    @endif
                                </ul>
                            </div>
                            
                            <div class="btn-listing ms-md-3 my-md-0 my-3 ms-auto me-auto mb-md-0 mb-3">
                                @if(!empty($result->address))

                                @if(auth()->guard('backend')->check())
                           
                                <a href="{{route('blockchain-search').'?keyword='.$keyword.'&result_no='.$result->unique_id}}" title="{{($result->chain) ? $result->chain->name : '' }}"><img src="{{asset('assets/frontend/images/icons/arrow-right.png')}}"></a>
                                @else
                                <a href="{{route('blockchain-search').'?keyword='.$keyword.'&result_no='.$result->unique_id}}" title="{{($result->chain) ? $result->chain->name : '' }}"><img src="{{asset('assets/frontend/images/icons/arrow-right.png')}}"></a>
                                @endif
                                
                                @endif
                            </div>
                        </div>
                    </div>                    
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @include('frontend.layouts.partials.alert-message')
</main>
@endsection
@section('scripts')
@endsection