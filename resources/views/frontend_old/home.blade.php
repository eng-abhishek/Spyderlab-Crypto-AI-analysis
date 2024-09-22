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
]) 
!!}
@endsection


@section('content')
<main>
  <section id="section1" class="position-relative canvas-area">
    <div class="spyder-element"></div>
    <div class="canvas-content text-light">
        <h1 class="text-uppercase">Spyderlab AML</h1>
        <p>Illuminate the shadowy woods of Blockchain and OSINT with a radiant beam of light.</p>
    </div>
</section>
{{-- <section class="py-5">
    <div class="container-fluid">
        <div class="row">
            <video autoplay muted loop>
                <source src="{{asset('assets/frontend/videos/IMG_9488.MP4')}}" type="video/mp4">
              </div>
          </div>
      </section> --}}
      <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-2"></div>

                <div class="col-md-8">
                    <div class="row pt-5 pb-3 text-center option-row">
                        <div class="col-3">
                            <h6 class="service-option crypto-tracking" onclick="show_2()">Crypto Analysis</h6>
                            <hr class="under-opt crypto-under">
                        </div>
                        <div class="col-3">
                            <h6 class="service-option OSINT" onclick="show_1()">OSINT</h6>
                            <hr class="under-opt osint-under">
                        </div>
                        <div class="col-3">
                            <h6 class="service-option dweb-intelli" onclick="show_3()">Dark Web Intelligence</h6>
                            <hr class="under-opt dweb-under">
                        </div>

                        <div class="col-3">
                            <h6 class="service-option others" onclick="show_4()"> Others </h6>
                            <hr class="under-opt others-under">
                        </div>
                    </div>
                </div>

                <div class="col-lg-2"></div>
            </div>
            <div class="row pt-3 service-row OSINT-service-row">
                <div class="col-md-4">
                    <div class="service-box">
                        <img src="{{asset('assets/frontend/images/icons/reserve-phone-ico.png')}}"
                        class="img-fluid service-ico">
                        <h5>Reverse Phone Lookup

                        </h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-box">
                        <img src="{{asset('assets/frontend/images/icons/reverse-mail-ico.png')}}"
                        class="img-fluid service-ico">
                        <h5>Reverse Mail Lookup

                        </h5>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="service-box">
                        <img src="{{asset('assets/frontend/images/icons/web-recon-ico.png')}}" class="img-fluid service-ico">
                        <h5>Web Reconnaissance
                        </h5>
                    </div>
                </div>
            </div>

            <div class="row pt-3 service-row crypto-tracking-row">
                <div class="col-md-3">
                    <div class="service-box">
                        <img src="{{asset('assets/frontend/images/icons/aml-ico.png')}}" class="img-fluid service-ico">
                        <h5>
                            Crypto AML
                            <sup>
                                <img src="{{asset('assets/frontend/images/icons/hot-ico.png')}}" class="img-fluid hot-ico">
                            </sup>
                        </h5>
                        <p>Crypto Anti-Money Laundering</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="service-box">
                        <img src="{{asset('assets/frontend/images/icons/on-chain-logo.png')}}" class="img-fluid service-ico">
                        <h5>On-Chain Analysis
                            <sup>
                                <img src="{{asset('assets/frontend/images/icons/new-ico.png')}}" class="img-fluid new-ico">
                            </sup>
                        </h5>
                        <p>Analysing Blockchain</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="service-box">
                        <img src="{{asset('assets/frontend/images/icons/off-chain-ico.png')}}" class="img-fluid service-ico">
                        <h5>Off-Chain Analysis
                        </h5>
                        <p>Analysing Blockchain</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="service-box">
                        <img src="{{asset('assets/frontend/images/icons/monitoring-ico.png')}}" class="img-fluid service-ico">
                        <h5>Crypto Tracking
                            <sup>
                                <img src="{{asset('assets/frontend/images/icons/hot-ico.png')}}" class="img-fluid hot-ico">
                            </sup>
                        </h5>
                        <p>Crypto Tracking and Monitoring</p>
                    </div>
                </div>
            </div>

            <div class="row pt-3  service-row dweb-intelligence-row">
                <div class="col-md-4">
                    <div class="service-box">
                        <img src="{{asset('assets/frontend/images/icons/onion-ico2.png')}}" class="img-fluid service-ico">
                        <h5>Onion Search
                        </h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-box">
                        <img src="{{asset('assets/frontend/images/icons/data-leack-ico.png')}}" class="img-fluid service-ico">
                        <h5>Search Dataleak TOR, I2P
                        </h5>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-box">
                        <img src="{{asset('assets/frontend/images/icons/password-ico.png')}}" class="img-fluid service-ico">
                        <h5>Password Compliance Check

                        </h5>
                    </div>
                </div>
            </div>

            <div class="row pt-3  service-row others-row">
                <div class="col-md-6">
                    <div class="service-box">
                        <img src="{{asset('assets/frontend/images/icons/audit-ico.png')}}" class="img-fluid service-ico">
                        <h5>Smart Contract Security Audit</h5>
                        <p>Audit Smart Contract</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="service-box">
                        <img src="{{asset('assets/frontend/images/icons/derivative-ico.png')}}" class="img-fluid service-ico">
                        <h5>Derivative</h5>
                        <p>Culture products</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-custom-dark py-5 text-center">
        <div class="container-xl container-fluid">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-12">
                    <h2>SpyderLab Service</h2>
                    <p> Dedicated to resolving issues related to "coin location," "tracking associated addresses," "identifying hacker profiles,"  and "verification freeze," alongside OSINT. </p>
                </div>
            </div>
            <div class="row justify-content-center mt-lg-5 mt-3">
                <div class="col-lg-12 mb-3">
                    <h3>Service Content</h3>
                </div>
                <div class="col-lg col-md-4 mb-lg-0 mb-3">
                    <div class="service-icon">
                        <img src="{{asset('assets/frontend/images/home/icon-1.png')}}" alt="">
                    </div>
                    <p class="mb-0">Analyze the transfer chain of the funding</p>
                </div>
                <div class="col-lg col-md-4 mb-lg-0 mb-3">
                    <div class="service-icon">
                        <img src="{{asset('assets/frontend/images/home/icon-2.png')}}" alt="">
                    </div>
                    <p class="mb-0">Monitor associated addresses</p>
                </div>
                <div class="col-lg col-md-4 mb-lg-0 mb-3">
                    <div class="service-icon">
                        <img src="{{asset('assets/frontend/images/home/icon-3.png')}}" alt="">
                    </div>
                    <p class="mb-0">Dynamic feedback when funding transferred to the exchange</p>
                </div>
                <div class="col-lg col-md-4 mb-lg-0 mb-3">
                    <div class="service-icon">
                        <img src="{{asset('assets/frontend/images/home/icon-4.png')}}" alt="">
                    </div>
                    <p class="mb-0">Track analysis report</p>
                </div>
                <div class="col-lg col-md-4 mb-lg-0 mb-3">
                    <div class="service-icon">
                        <img src="{{asset('assets/frontend/images/home/icon-5.png')}}" alt="">
                    </div>
                    <p class="mb-0">Assist the police to investigate and freeze</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mt-lg-5 mt-3">
                    <a href="#" class="btn btn-main">Learn More</a>
                </div>
            </div>
        </div>
    </section>


{{--<section class="bg-custom-dark py-5">
    <div class="container-xl container-fluid">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6 order-md-2 order-1">
                <img src="{{asset('assets/frontend/images/home/2.png')}}" alt="" class="img-fluid mb-md-0 mb-3">
            </div>
            <div class="col-md-6 order-md-1 order-2">
                <h2>Unlock the Power of Open Source Intelligence with Spyderlab</h2>
                <p class="text-justify mt-3">Spyderlab is your go-to tool for conducting comprehensive open source intelligence (OSINT) investigations. With our platform, you can effortlessly access the deepest corners of the internet and obtain fast, high-quality results with just a few clicks. Leveraging billions of selectors, Spyderlab swiftly searches through vast amounts of data in milliseconds. Plus, our data archive adds an extra layer of power to your investigations.</p>
                <ul class="list-unstyled list-main mb-3 text-justify">
                    <li><span class="fw-bold me-1">Unparalleled Access:</span>  Data collected from authenticated sources across the web.</li>
                    <li><span class="fw-bold me-1">Cybercriminal Activity:</span>  Monitor drug sales, blockchain transactions, human trafficking, and cyberweapons.</li>
                    <li><span class="fw-bold me-1">Comprehensive:</span>  Analyze historical data from a mammoth database.</li>
                    <li><span class="fw-bold me-1">Accessible:</span>  Build models based on data collected through dedicated APIs.</li>
                </ul>
                <p class="text-justify">Experience the next level of OSINT capabilities with Spyderlab today!</p>
            </div>
        </div>
    </div>
</section>--}}


<section class="bg-custom-light py-5 text-center">
    <div class="container-xl container-fluid">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-12">
                <h2>Malicious Address Library</h2>
                <p>The threat intelligence engine of SpyderLab gathers data from diverse sources, undergoes thorough cleansing and integration, leveraging artificial intelligence technology to extract precise information from vast datasets. Encompassing content from the dark web to numerous global exchanges, it identifies malicious wallet addresses, including but not limited to BTC, ETH, EOS, XRP, T RX, USDT, surpassing a total count of 100,000. With its extensive capabilities, SpyderLab's threat intelligence engine offers comprehensive support for tracking hacker attacks, coin laundering, and OSINT.</p>
                <img src="{{asset('assets/frontend/images/home/mw-yq.png')}}" alt="" class="img-fluid my-md-5 my-3">
                <a href="#" class="btn btn-main-2">Learn More</a>
            </div>
        </div>
    </div>
</section>

{{--<section class="bg-custom-light py-5">
    <div class="container-xl container-fluid">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6">
                <img src="{{asset('assets/frontend/images/home/3.png')}}" alt="" class="img-fluid mb-md-0 mb-3">
            </div>
            <div class="col-md-6">
                <h2>Strong Commitment to Privacy: Your Data is Safe with Us</h2>
                <p class="text-justify mt-3">At Spyderlab, we prioritize your privacy above all else. We strictly adhere to the principle of minimal data storage, ensuring that we only retain the information necessary to deliver our exceptional services. Rest assured, all our servers are located within the EU, where they are subject to the robust privacy regulations mandated by the European Union. Trust in Spyderlab's unwavering commitment to safeguarding your data and protecting your privacy.</p>
                <p class="text-justify">Spyderlab's Cookie Policy ensures a smooth browsing experience, with cookies used to personalize content and improve site performance. We respect your privacy and offer options to manage cookie settings.</p>
                <a href="{{route('privacy-policy')}}" class="btn btn-main">Privacy Policy</a>
                <a href="{{route('terms-of-service')}}" class="btn btn-main-2">Cookie Policy</a>
            </div>
        </div>
    </div>
</section>--}}

<section class="bg-custom-dark py-5 text-center">
    <div class="container-xl container-fluid">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-12 mb-3">
                <h2>Customer Cases</h2>
            </div>
            <div class="col-lg-4 col-md-6 my-3">
                <img src="{{asset('assets/frontend/images/home/cc-icon-1.png')}}" alt="" class="cc-icon">
                <h3>60 <span class="ms-1">+</span></h3>
                <p class="mb-0">Wallet APP</p>
            </div>
            <div class="col-lg-4 col-md-6 my-3">
                <img src="{{asset('assets/frontend/images/home/cc-icon-2.png')}}" alt="" class="cc-icon">
                <h3>80 <span class="ms-1">+</span></h3>
                <p class="mb-0">Exchange</p>
            </div>
            <div class="col-lg-4 col-md-6 my-3">
                <img src="{{asset('assets/frontend/images/home/cc-icon-3.png')}}" alt="" class="cc-icon">
                <h3>60 <span class="ms-1">+</span></h3>
                <p class="mb-0">Asset custody platform</p>
            </div>
            <div class="col-lg-4 col-md-6 my-3">
                <img src="{{asset('assets/frontend/images/home/cc-icon-4.png')}}" alt="" class="cc-icon">
                <h3>60 <span class="ms-1">+</span></h3>
                <p class="mb-0">DeFi</p>
            </div>
            <div class="col-lg-4 col-md-6 my-3">
                <img src="{{asset('assets/frontend/images/home/cc-icon-5.png')}}" alt="" class="cc-icon">
                <h3>60 <span class="ms-1">+</span></h3>
                <p class="mb-0">Investment Agency</p>
            </div>
            <div class="col-lg-4 col-md-6 my-3">
                <img src="{{asset('assets/frontend/images/home/cc-icon-6.png')}}" alt="" class="cc-icon">
                <h3>60 <span class="ms-1">+</span></h3>
                <p class="mb-0">Others</p>
            </div>
        </div>
    </div>
</section>

<section class="bg-custom-light py-5 text-center">
    <div class="container-xl container-fluid">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-12 text-center">
                <h2>Spyderlab Plarform</h2>
                <p>SpyderLab, a comprehensive Crypto Tracking and Compliance Platform accessible to all, is crafted by PDPL AML to address and counter cryptocurrency money laundering activities through its robust anti-money laundering tracking system and OSINT integration.</p>                        
            </div>
        </div>
        <div class="row mt-lg-5 mt-3">
            <div class="col-lg-3 col-md-6 mb-lg-0 mb-3">
                <h3>1K <span class="ms-1">+</span></h3>
                <p class="mb-0">Address Entity</p>
            </div>
            <div class="col-lg-3 col-md-6 mb-lg-0 mb-3">
                <h3>200M <span class="ms-1">+</span></h3>
                <p class="mb-0">Address Label</p>
            </div>
            <div class="col-lg-3 col-md-6 mb-lg-0 mb-3">
                <h3>100K <span class="ms-1">+</span></h3>
                <p class="mb-0">Threat Intelligence</p>
            </div>
            <div class="col-lg-3 col-md-6 mb-lg-0 mb-3">
                <h3>90M <span class="ms-1">+</span></h3>
                <p class="mb-0">Risky Address</p>
            </div>
            <div class="col-lg-12 mt-lg-5 mt-3">
                <a href="#" class="btn btn-main-2">Learn More</a>
            </div>
        </div>
    </div>
</section>

{{--<section class="bg-custom-dark py-5">
    <div class="container-xl container-fluid">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6 order-md-2 order-1">
                <img src="{{asset('assets/frontend/images/home/4.png')}}" alt="" class="img-fluid mb-md-0 mb-3">
            </div>
            <div class="col-md-6 order-md-1 order-2">
                <h2>About Us</h2>
                <p class="text-justify mt-3">At Spyderlab, we provide a wide array of data for your search by scraping through multiple platforms. Continuously monitoring the internet allows us to provide you with answers within minutes. Our site provides information on various online frauds and cyber threats. Using threat map and the information, you can identify, prepare, and prevent attacks. With our chain analysis data, you can make better decisions.</p>
                
                <a href="#" class="btn btn-main">Our Datacenter</a>
                <a href="#" class="btn btn-main-2">Network</a>
            </div>
        </div>
    </div>
</section>--}}

{{--<section class="bg-custom-light py-5">
    <div class="container-xl container-fluid">
        <div class="row justify-content-center align-items-center text-center">
            <div class="col-md-12 mb-3">
                <h2>Our Services</h2>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="home-services mb-3">
                    <img src="{{asset('assets/frontend/images/services/1.png')}}" alt="">
                    <h3 class="fs-5">OSINT</h3>
                    <p>Our analysts gather publicly available data from the internet and analyze it to store high-quality intelligence information</p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="home-services mb-3">
                    <img src="{{asset('assets/frontend/images/services/2.png')}}" alt="">
                    <h3 class="fs-5">Reverse Phone Number Lookup</h3>
                    <p>Our in-built APIs help you find all public data associated with a phone number.</p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="home-services mb-3">
                    <img src="{{asset('assets/frontend/images/services/3.png')}}" alt="">
                    <h3 class="fs-5">Reverse Email ID Lookup</h3>
                    <p>Our in-built APIs help you find all public data associated with an email id.</p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="home-services mb-3">
                    <img src="{{asset('assets/frontend/images/services/4.png')}}" alt="">
                    <h3 class="fs-5">Chain Analysis</h3>
                    <p>Track malicious blockchain transactions and prevent illegal activities with our chain analysis.</p>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="home-services mb-3">
                    <img src="{{asset('assets/frontend/images/services/5.png')}}" alt="">
                    <h3 class="fs-5">Web Reconnaissance</h3>
                    <p>Obtain all relevant information about a targeted system, both passively and actively.</p>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="home-services mb-3">
                    <img src="{{asset('assets/frontend/images/services/6.png')}}" alt="">
                    <h3 class="fs-5">Cyber Attack Intelligence</h3>
                    <p>Combat and mitigate cyber-attacks faster with our intelligence service.</p>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="home-services mb-3">
                    <img src="{{asset('assets/frontend/images/services/7.png')}}" alt="">
                    <h3 class="fs-5">OSINT Resources</h3>
                    <p>Access a host of OSINT resources from the largest database of OSINT Tools and resources on the web.</p>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="home-services mb-3">
                    <img src="{{asset('assets/frontend/images/services/8.png')}}" alt="">
                    <h3 class="fs-5">Dark Web Intelligence</h3>
                    <p>Curb online financial crime and cyber-terrorism with our Darkweb intelligence service.</p>
                </div>
            </div>

        </div>
    </div>
</section>--}}

{{--<section class="bg-custom-light py-5">
    <div class="container-xxl container-fluid">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-xxl-12 col-lg-12 col-12 text-center">
                <h2>Our Services</h2>
            </div>
        </div>
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-xxl-12 col-lg-12 col-12">
                <div class="row align-items-stretch justify-content-center py-3">
                    <div class="col-lg-4 col-md-6">
                        <div class="new-service-wrap text-center d-flex align-items-center justify-content-center p-lg-0 p-3">
                            <div class="my-3">
                                <h3 class="fs-5 mb-0">OSINT</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <ul class="new-service-inner">
                            <li>Reverse Phone Lookup</li>
                            <li>Reverse Mail Lookup</li>
                            <li>Web Reconnaissance</li>
                        </ul>
                    </div>
                </div>
                <div class="row align-items-stretch justify-content-center py-3">
                    <div class="col-lg-4 col-md-6">
                        <div class="new-service-wrap text-center d-flex align-items-center justify-content-center p-lg-0 p-3">
                            <div class="my-3">
                                <h3 class="fs-5 mb-0">Crypto Tracking</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <ul class="new-service-inner">
                            <li>On-Chain Analysis</li>
                            <li>Off-Chain Analysis</li>
                            <li>Monitoring</li>
                        </ul>
                    </div>
                </div>
                <div class="row align-items-stretch justify-content-center py-3">
                    <div class="col-lg-4 col-md-6">
                        <div class="new-service-wrap text-center d-flex align-items-center justify-content-center p-lg-0 p-3">
                            <div class="my-3">
                                <h3 class="fs-5 mb-0">Dark Web Intelligence</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <ul class="new-service-inner">
                            <li>Onion Search</li>
                            <li>Search Dataleak TOR, I2P</li>
                            <li>Password Compliance Check</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>--}}

<section class="bg-custom-dark py-5">
    <div class="container-xl container-fluid">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-12 mb-5">
                <h2 class="fs-3 text-center">Partners</h2>
            </div>
            <div class="col-md-12">
                <div class="partner">
                    <div class="partner-content">
                        <div class="d-flex">
                            <div class="partner-single">
                                <a href="javascript:void(0)" title=""><img src="{{asset('assets/frontend/images/home/partner/binance.png')}}" class="img-fluid" alt=""></a>
                            </div>
                            <div class="partner-single">
                                <a href="javascript:void(0)" title=""><img src="{{asset('assets/frontend/images/home/partner/trend.png')}}" class="img-fluid" alt=""></a>
                            </div>
                            <div class="partner-single">
                                <a href="javascript:void(0)" title=""><img src="{{asset('assets/frontend/images/home/partner/zilliqa.png')}}" class="img-fluid" alt=""></a>
                            </div>
                            
                            <div class="partner-single">
                                <a href="javascript:void(0)" title=""><img src="{{asset('assets/frontend/images/home/partner/secureshift.png')}}" class="img-fluid" alt=""></a>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="partner-single">
                                <a href="javascript:void(0)" title=""><img src="{{asset('assets/frontend/images/home/partner/binance.png')}}" class="img-fluid" alt=""></a>
                            </div>
                            <div class="partner-single">
                                <a href="javascript:void(0)" title=""><img src="{{asset('assets/frontend/images/home/partner/trend.png')}}" class="img-fluid" alt=""></a>
                            </div>
                            <div class="partner-single">
                                <a href="javascript:void(0)" title=""><img src="{{asset('assets/frontend/images/home/partner/zilliqa.png')}}" class="img-fluid" alt=""></a>
                            </div>
                            
                            <div class="partner-single">
                                <a href="javascript:void(0)" title=""><img src="{{asset('assets/frontend/images/home/partner/secureshift.png')}}" class="img-fluid" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{--<section class="bg-custom-dark py-5">
    <div class="container-xl container-fluid">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-12 mb-5">
                <h2 class="fs-3 text-center">Trusted by developers and businesses from over 80 countries</h2>
            </div>
            <div class="col-md-4 mb-md-0 mb-3">
                <div class="home-tracking">
                    <div class="home-tracking-image">
                        <img src="{{asset('assets/frontend/images/tracking/1.png')}}" alt="">
                    </div>
                    <h3 class="fs-5">Trusted</h3>
                    <p class="text-justify">Spyderlab accesses verified and reliable data from trusted sources, ensuring the accuracy and integrity of the information you rely on.</p>
                </div>
            </div>
            <div class="col-md-4 mb-md-0 mb-3">
                <div class="home-tracking">
                    <div class="home-tracking-image">
                        <img src="{{asset('assets/frontend/images/tracking/2.png')}}" alt="">
                    </div>
                    <h3 class="fs-5">Top Rated</h3>
                    <p class="text-justify">Unleash the Power of Top-Rated Data and Services for Unmatched Intelligence Insights. Trust the Experts for Unparalleled Results.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="home-tracking">
                    <div class="home-tracking-image">
                        <img src="{{asset('assets/frontend/images/tracking/3.png')}}" alt="">
                    </div>
                    <h3 class="fs-5">Fast Service</h3>
                    <p class="text-justify">Experience the speed of Spyderlab's services as we swiftly process data and provide lightning-fast results for your investigative needs.</p>
                </div>
            </div>
        </div>
    </div>
</section>--}}
@include('frontend.layouts.partials.alert-message')
</main>
@endsection
@section('scripts')
<script src="{{asset('assets/frontend/3d/three.min.js')}}"></script>
<script type="module" src="{{asset('assets/frontend/3d/3d.js')}}"></script>
<script type="module" src="{{asset('assets/frontend/3d/GLTFLoader.js')}}"></script>
<script type="module" src="{{asset('assets/frontend/3d/OrbitControls.js')}}"></script>
@endsection