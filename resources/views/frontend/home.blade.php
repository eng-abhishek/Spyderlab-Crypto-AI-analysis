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
    ['url' => route('home'), 'title' => 'Home']
    ]) 
    !!}

    @endsection

    @section('content')

    <!-- Main slider -->
    <section class="main-slider">
        <div class="owl-carousel main-banner owl-theme">
            <div class="item">
                <div class="slider-content">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="slider-information">
                                    <div class="heading-first">
                                        <h1>Spyderlab.org</h1>
                                    </div>
                                    <div class="description">
                                        <p>Leading Blockchain Forensics & AML, Dark Web Intelligence, and OSINT Platform for Secure Investigations.</p>
                                    </div>
                                    <div class="slider-btn">
                                        <button class="btn btn-price">Get Prices</button>
                                        <button class="btn btn-more">Learn More</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="slider-image">
                                    <!--img src="{{asset('assets/frontend_new/image/sat.svg')}}"-->
                                    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
                                    <dotlottie-player src="https://lottie.host/f8ad8bb9-833d-444c-83b9-b95155cbc34d/QPBoYalevw.json" background="transparent" speed="1" style="width: 600px; height: 300px;" loop autoplay></dotlottie-player>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="slider-content">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="slider-information">
                                    <div class="heading">
                                        <h1>Crypto Tracking & AML</h1>
                                    </div>
                                    <div class="description">
                                        <p>Spyderlab.org: Trusted Blockchain Forensics and Complete Crypto AML Services to Safeguard Your Digital Assets.</p>
                                    </div>
                                    <div class="slider-btn">
                                        <button class="btn btn-price">Get Prices</button>
                                        <button class="btn btn-more">Learn More</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="slider-image">
                                    <!--img src="{{asset('assets/frontend_new/image/rack.svg')}}"-->
                                    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script> 

                                    <dotlottie-player src="https://lottie.host/3e4cc65b-6063-4916-bfe3-bd12d21eb868/nqPcGqwxsW.json" background="transparent" speed="1" style="width: 600px; height: 300px;" loop autoplay></dotlottie-player>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="slider-content">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="slider-information">
                                    <div class="heading">
                                        <h1>OSINT Tools</h1>
                                    </div>
                                    <div class="description">
                                        <p>Advanced OSINT Tools for Effective Gathering and Analysis of Digital Evidence in Investigations.</p>
                                    </div>
                                    <div class="slider-btn">
                                        <button class="btn btn-price">Get Prices</button>
                                        <button class="btn btn-more">Learn More</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="slider-image">
                                    <!--img src="{{asset('assets/frontend_new/image/cloudvps.svg')}}"-->
                                    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script> 

                                    <dotlottie-player src="https://lottie.host/95f33e0d-be9d-4bfa-9902-2a1fbd4eb1a8/cxtnZf9SJM.json" background="transparent" speed="1" style="width: 600px; height: 300px;" loop autoplay></dotlottie-player>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </section>

    <!-- service -->
    <section class="service-product">
        <div class="service py-5">
            <div class="container">

                <div class="product-list">
                    <a href="#" class="active" data-tab="crypto-analysis">Crypto Analysis</a>
                    <a href="#" data-tab="osint">OSINT</a>
                    <a href="#" data-tab="dark-web-intelligence">Dark Web Intelligence</a>
                    <a href="#" data-tab="other">Other</a>
                </div>
                
                <div class="service-box-section">
                    <div class="row d-flex flex-wrap">
                        <div class="col-md-3">
                            <div class="service-box swiper-container card" id="crypto-analysis">
                                <img src="{{asset('assets/frontend/images/aml-ico.png')}}" alt="AML Icon">
                                <h4>Crypto AML </h4>
                                <p>Crypto Anti-Money Laundering</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="service-box swiper-container card" id="crypto-analysis">
                                <img src="{{asset('assets/frontend/images/on-chain-logo.png')}}" alt="On-chain Logo">
                                <h4>On-Chain Analysis </h4>
                                <p>Analysing Blockchain</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="service-box swiper-container card" id="crypto-analysis">
                                <img src="{{asset('assets/frontend/images/off-chain-ico.png')}}" alt="Off-chain Icon">
                                <h4>Off-Chain Analysis</h4>
                                <p>Analysing Blockchain</p>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="service-box swiper-container card" id="crypto-analysis">
                                <img src="{{asset('assets/frontend/images/monitoring-ico.png')}}" alt="Monitoring Icon">
                                <h4>Crypto Tracking</h4>
                                <p>Crypto Tracking and Monitoring</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="service-box swiper-container card" id="osint">
                                <img src="{{asset('assets/frontend/images/reserve-phone-ico.png')}}" alt="reserve phone icon">
                                <h4>Reverse Phone Lookup</h4>
                                <p></p>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="service-box swiper-container card" id="osint">
                                <img src="{{asset('assets/frontend/images/reverse-mail-ico.png')}}" alt="reserve mail icon">
                                <h4>Reverse Mail Lookup</h4>
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="service-box swiper-container card" id="osint">
                                <img src="{{asset('assets/frontend/images/web-recon-ico.png')}}" alt="web-recon-ico.png">
                                <h4>Web Reconnaissance</h4>
                                <p></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="service-box swiper-container card" id="dark-web-intelligence">
                                <img src="{{asset('assets/frontend/images/onion-ico2.png')}}" alt="onion-ico2.png">
                                <h4>Onion Search</h4>
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="service-box swiper-container card" id="dark-web-intelligence">
                                <img src="{{asset('assets/frontend/images/data-leack-ico.png')}}" alt="data-leack-ico.png">
                                <h4>Search Dataleak TOR, I2P</h4>
                                <p></p>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="service-box swiper-container card" id="dark-web-intelligence">
                                <img src="{{asset('assets/frontend/images/password-ico.png')}}" alt="password-ico.png">
                                <h4>Password Compliance Check</h4>
                                <p></p>
                            </div>
                        </div>                   
                    </div>


                    <div class="row">
                        <div class="col-md-4">
                            <div class="service-box swiper-container card" id="other">
                                <img src="{{asset('assets/frontend/images/audit-ico.png')}}" alt="audit-ico.png">
                                <h4>Smart Contract Security Audit</h4>
                                <p>Audit Smart Contract</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="service-box swiper-container card" id="other">
                                <img src="{{asset('assets/frontend/images/derivative-ico.png')}}" alt="derivative-ico.png">
                                <h4>Derivative</h4>
                                <p>Culture products</p>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </section>
    <!--all services -->
    <section class="service-section">
        <div class="container py-5">
            <div class="service-details">
                <div class="heading">
                 <h2> SpyderLab Service</h2>
             </div>
             <div class="description">
                <p>Dedicated to resolving issues related to "coin location," "tracking associated addresses," "identifying hacker profiles," and "verification freeze," alongside OSINT.</p>
            </div>
        </div>
        <div class="col-md-12">
            <div class="canvas-service">
              <!--img src="{{asset('assets/frontend_new/image/balancing.svg')}}" alt="balancing.svg"-->
              <div class="canvas-service" style="display: flex; justify-content: center; align-items: center;">
                  <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script> 

                  <dotlottie-player src="https://lottie.host/72de8581-2886-4672-b8ca-8e7b5f409e8c/vSYP6Yjj8l.json" background="transparent" speed="0.3" style="width: 600px; height: 300px;" loop autoplay></dotlottie-player>
              </div>
          </div>
      </div>
      
      <div class="service-content">
        <div class="row justify-content-center">
            <div class="col-md-2">
                <div class="service-card">
                    <img src="{{asset('assets/frontend/images/icon-1.png')}}" alt="Icon 1">
                    <h4>Analyze the transfer chain of the funding</h4>
                </div>
            </div>
            <div class="col-md-2">
                <div class="service-card">
                    <img src="{{asset('assets/frontend/images/icon-2.png')}}" alt="Icon 2">
                    <h4>Monitor associated addresses</h4>
                </div>
            </div>
            <div class="col-md-2">
                <div class="service-card">
                    <img src="{{asset('assets/frontend/images/icon-3.png')}}" alt="Icon 3">
                    <h4>Dynamic feedback when funding transferred to the exchange</h4>
                </div>
            </div>
            <div class="col-md-2">
                <div class="service-card">
                    <img src="{{asset('assets/frontend/images/icon-4.png')}}" alt="Icon 4">
                    <h4>Track analysis report</h4>
                </div>
            </div>
            <div class="col-md-2">
                <div class="service-card">
                    <img src="{{asset('assets/frontend/images/icon-5.png')}}" alt="Icon 5">
                    <h4>Assist the police to investigate and freeze</h4>
                </div>
            </div>
        </div>
        <a href="#"><button class="btn btn-learn">Learn More</button></a>
    </div>

</div>
</section>

<!-- Address Library -->
<section class="address-library">
    <div class="container">
        <div class="malicious-address-library py-5">
            <h2 class="py-2">Malicious Address Library</h2>
            <p>The threat intelligence engine of SpyderLab gathers data from diverse sources, undergoes thorough cleansing and integration, leveraging artificial intelligence technology to extract precise information from vast datasets. Encompassing content from the dark web to numerous global exchanges, it identifies malicious wallet addresses, including but not limited to BTC, ETH, EOS, XRP, T RX, USDT, surpassing a total count of 100,000. With its extensive capabilities, SpyderLab's threat intelligence engine offers comprehensive support for tracking hacker attacks, coin laundering, and OSINT.</p>
            
            <div class="canvas-service" style="display: flex; justify-content: center; align-items: center;">
               <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script> 

               <dotlottie-player src="https://lottie.host/8c4ea578-9b9e-4a54-a43d-13be64fc74ba/sDGNQkGZkx.json" background="transparent" speed="1" style="width: 600px; height: 300px;" loop autoplay></dotlottie-player>

           </div>
           <a href="#"><button class="btn btn-learn">Learn More</button></a>
       </div>
   </div>
</section>

<!-- Customer Cases -->
<section class="customer-cases">
    <div class="container">
        <div class="customer-cases-details py-5">
            <h2 class="py-3 customer-cases-heading">Customer Cases</h2>
            <div class="row justify-content-center">
                <div class="col-md-4">
                 <div class="card cases-name">
                    <img src="{{asset('assets/frontend/images/cc-icon-1.png')}}">
                    <h2>60 <i class="fa-solid fa-plus"></i></h2>
                    <h6>Wallet APP</h6>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card cases-name">
                   <img src="{{asset('assets/frontend/images/cc-icon-2.png')}}">
                   <h2>80 <i class="fa-solid fa-plus"></i></h2>
                   <h6>Exchange</h6>
               </div>
           </div>
           <div class="col-md-4">
            <div class="card cases-name">
               <img src="{{asset('assets/frontend/images/cc-icon-3.png')}}">
               <h2>50 <i class="fa-solid fa-plus"></i></h2>
               <h6>Asset custody platform</h6>
           </div>
       </div>
       <div class="col-md-4">
        <div class="card cases-name">
           <img src="{{asset('assets/frontend/images/cc-icon-4.png')}}">
           <h2>70 <i class="fa-solid fa-plus"></i></h2>
           <h6>DeFi</h6>
       </div>
   </div>
   <div class="col-md-4">
    <div class="card cases-name">
       <img src="{{asset('assets/frontend/images/cc-icon-5.png')}}">
       <h2>40 <i class="fa-solid fa-plus"></i></h2>
       <h6>Investment Agency</h6>
   </div>
</div>
<div class="col-md-4">
    <div class="card cases-name">
       <img src="{{asset('assets/frontend/images/cc-icon-6.png')}}">
       <h2>20 <i class="fa-solid fa-plus"></i></h2>
       <h6>Others</h6>
   </div>
</div>
</div>
</div>
</div>
</section>

<!-- Spyderlab Plarform -->
<section class="spyderlab-platform">
    <div class="container">
        <div class="spyderlab-platform-details py-5">
            <div class="spyderlab-platform-heading">
                <h2 class="py-2">Spyderlab Platform</h2>
            </div>
            <div class="spyderlab-platform-description">
                <p>SpyderLab, a comprehensive Crypto Tracking and Compliance Platform accessible to all, is crafted by PDPL AML to address and counter cryptocurrency money laundering activities through its robust anti-money laundering tracking system and OSINT integration.</p>

            </div>
            <div class="counter">
                <div class="row justify-content-center">
                    <div class="col-md-3">
                      <div class="count d-flex">
                        <h4 class="count-number">250 </h4><span>K</span>
                    </div>
                    <h3>Address Entity</h3>
                </div>
                <div class="col-md-3">
                    <div class="count d-flex">
                        <h4 class="count-number">200 </h4><span>K</span>
                    </div>
                    <h3>Address Label</h3>
                </div>
                <div class="col-md-3">
                    <div class="count d-flex">
                        <h4 class="count-number">180 </h4><span>K</span>                          
                    </div>
                    <h3>Threat Intelligence</h3>
                </div>
                <div class="col-md-3">
                    <div class="count d-flex">
                        <h4 class="count-number">220 </h4><span>K</span>
                    </div>
                    <h3>Risky Address</h3>
                </div>
            </div>
        </div>
        <a href="#"><button class="btn btn-learn">Learn More</button></a>
    </div>
</div>

</section>

@if(count($post) > 0)
<!-- blog -->
<section class="blog">
    <div class="container">
        <div class="blog-details py-5">
            <h2 class="py-2 text-center">Blog</h2>
            <div class="row justify-content-center">
                @forelse($post as $post_list)

                <div class="col-md-4 mb-3">
                    <div class="card blog-information text-center h-100">
                        <img src="{{$post_list->image_url}}" class="img-fluid" alt="Blog image">
                        <div class="card-body">
                            <span class="d-block mb-2">Date: {{\Carbon\Carbon::parse($post_list->publish_at)->format('Y-m-d')}}</span>
                            <div class="about-blog">
                                <a href="{{route('blog.details',$post_list->slug)}}"><h4>{{\Str::limit(strip_tags(html_entity_decode($post_list->title)), 80)}}</h4></a>
                                <p>{{\Str::limit(strip_tags(html_entity_decode($post_list->content)), 200)}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @empty

                @endforelse
            </div>
        </div>
    </div>
</section>
@endif

<!-- partners -->
<section class="partners">
    <div class="container-fluid">
        <div class="partners-details py-5">
            <h2 class="text-center">Partners</h2>
            <div class="marquee">
                <div class="marquee-content">
                    
                    @forelse($partner as $record)
                    <a href="{{$record->url}}" target="_blank">
                        <img src="{{$record->image_url}}" alt="Binance">
                    </a>
                    @empty
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
