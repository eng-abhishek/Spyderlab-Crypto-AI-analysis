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
        <section class="section-blockchain py-5">
            <div class="container-xl container-fluid">
                <div class="row justify-content-center text-center mb-3">
                    <div class="col-lg-10">
                        <h1>A Crypto Tracking and Compliance<br>Web3 background check</h1>
                        <p>Spyderlab is an anti-money laundering tracking system developed by the <a href="https://www.patterndrive.com/" target="_blank" style="color:#fff">PDPL AML</a>. We use on-chain analytics to assist in the tracing of illicit funds.</p>
                    </div>
                </div>
                <div class="row justify-content-center text-center mb-3">
                    <div class="col-lg-8 col-md-10">
                        <div class="domain-search">
                            <form action="{{urlencode(route('blockchain-search'))}}" method="GET" class="address-search-form">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="domain-group">
                                            <input type="text" name="keyword" class="form-control keyword" placeholder="Search for addresses, transactions, url / web3 domain name">
                                            <button class="btn btn-main btn-search" type="submit"></button>
                                        </div>
                                    </div>
                                </div>
                            </form>                            
                            <p class="text-start my-2 search-eg">
                                Search examples:
                                <a href="javascript:void(0);" class="px-2 my-2 d-block d-md-inline-block fw-bold">
                                    <i class="fa-light fa-wallet"></i> Address
                                </a>
                                {{--<a href="javascript:void(0);" class="px-2 my-2 d-block d-md-inline-block fw-bold">
                                    <i class="fa-light fa-cube"></i> Block
                                </a>--}}
                                <a href="javascript:void(0);" class="px-2 my-2 d-block d-md-inline-block fw-bold">
                                    <i class="fa-light fa-arrow-right-arrow-left"></i> Transaction
                                </a>
                                <a href="javascript:void(0);" class="px-2 my-2 d-block d-md-inline-block fw-bold">
                                    <i class="fa-light fa-text-size"></i> Url / web3 domain name
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="bg-custom-light py-5">
            <div id="scrollTop" class="d-none">
                <div class="container-xl container-fluid" id="blockchain_search_result">
                    <div class="row justify-content-center mb-3">
                        <div class="col-lg-5 col-md-6">
                            <div class="section-home p-2 mb-3 rounded-3">
                                <a class="blockchain-btn bg-custom-light-2" data-bs-toggle="tooltip" data-bs-title="1 of critical issues identified for the privacy of the involved addresses. Click to learn more.">
                                    <div class="d-flex justify-content-between align-items-center flex-md-row flex-column mb-md-2 mb-3">
                                        <img src="{{asset('assets/frontend/images/shield.png')}}" alt="" class="me-md-3 me-auto ms-auto mb-md-0 mb-3">
                                        <div class="flex-grow-1 text-md-start text-center">
                                            <!-- <h5>Privacy</h5> -->
                                            <h4>
                                                <i class="fa-solid fa-exclamation-circle text-danger"></i> Focusing on Blockchain Ecosystem Security <i class="fa-solid fa-circle-question fs-7 text-secondary"></i></h4>
                                                <!-- <h6><span class="text-danger">Issues: </span>1</h6> -->
                                            </div>
                                        </div>
                                        <p class="mb-0 text-md-start text-center">In security, slow is smooth, smooth is fast</p>
                                    </a>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row justify-content-center mb-3">
                            <div class="col-lg-10 col-md-12">
                                <div class="section-home rounded-3 p-3">
                                    <div class="d-flex justify-content-between align-items-center flex-md-row flex-column">
                                        <div class="flex-grow-1 text-md-start text-center">
                                            <h4 class="mb-lg-0 mb-3 fs-5">Login or Signup to continue your search!</h4>
                                        </div>
                                        <div class="text-center ms-lg-3 ms-0">
                                            <a href="{{route('login')}}" class="btn btn-main rounded-pill loginbtn">Login / Signup</a>
                                            {{--<span class="mx-1 blockchain-or">OR</span>--}}
                                            {{--<a href="{{route('register')}}" class="btn btn-main-2 rounded-pill">Signup</a>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="mb-3">
                    </div>
                </div>


                <div class="container-xl container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-12 mb-3 text-center">
                            <h2>We currently support 15+ chains and following coins</h2>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <a href="#" title="" class="coin-wrap">
                                <div class="d-flex justify-content-between align-items-center flex-md-row flex-column">
                                    <img src="{{asset('assets/frontend/images/coins/btc.png')}}" alt="" class="me-md-3 me-auto ms-auto mb-md-0 mb-3">
                                    <div class="flex-grow-1 text-md-start text-center">
                                        <h3 class="mb-0">Bitcoin</h3>
                                        {{--<div class="price">
                                            <i class="fa-regular fa-dollar"></i> 27,472.25
                                            <span class="up">2%</span>
                                        </div>--}}
                                    </div>
                                </div>
                                {{--<ul class="list-unstyled mb-0 fw-bold">
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Block</span>
                                        <span class="coin-value">789,257</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Transactions</span>
                                        <span class="coin-value">836,066,692</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Latest block</span>
                                        <span class="coin-value">19 min ago</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Transactions per second</span>
                                        <span class="coin-value">3.55</span>
                                    </li>
                                </ul>--}}
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <a href="#" title="" class="coin-wrap">
                                <div class="d-flex justify-content-between align-items-center flex-md-row flex-column">
                                    <img src="{{asset('assets/frontend/images/coins/eth.png')}}" alt="" class="me-md-3 me-auto ms-auto mb-md-0 mb-3">
                                    <div class="flex-grow-1 text-md-start text-center">
                                        <h3 class="mb-0">Ethereum</h3>
                                        {{--<div class="price">
                                            <i class="fa-regular fa-dollar"></i> 27,472.25
                                            <span class="down">3%</span>
                                        </div>--}}
                                    </div>
                                </div>
                                {{--<ul class="list-unstyled mb-0 fw-bold">
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Block</span>
                                        <span class="coin-value">789,257</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Transactions</span>
                                        <span class="coin-value">836,066,692</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Latest block</span>
                                        <span class="coin-value">19 min ago</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Transactions per second</span>
                                        <span class="coin-value">3.55</span>
                                    </li>
                                </ul>--}}
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="#" title="" class="coin-wrap">
                                <div class="d-flex justify-content-between align-items-center flex-md-row flex-column">
                                    <img src="{{asset('assets/frontend/images/coins/bnb.png')}}" alt="" class="me-md-3 me-auto ms-auto mb-md-0 mb-3">
                                    <div class="flex-grow-1 text-md-start text-center">
                                        <h3 class="mb-0">BNB <span class="ms-2 badge bg-success rounded-pill">New</span></h3>
                                        {{--<div class="price">
                                            <i class="fa-regular fa-dollar"></i> 27,472.25
                                            <span class="down">3%</span>
                                        </div>--}}
                                    </div>
                                </div>
                                {{--<ul class="list-unstyled mb-0 fw-bold">
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Block</span>
                                        <span class="coin-value">789,257</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Transactions</span>
                                        <span class="coin-value">836,066,692</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Latest block</span>
                                        <span class="coin-value">19 min ago</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Transactions per second</span>
                                        <span class="coin-value">3.55</span>
                                    </li>
                                </ul>--}}
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="#" title="" class="coin-wrap">
                                <div class="d-flex justify-content-between align-items-center flex-md-row flex-column">
                                    <img src="{{asset('assets/frontend/images/coins/solana.png')}}" alt="" class="me-md-3 me-auto ms-auto mb-md-0 mb-3">
                                    <div class="flex-grow-1 text-md-start text-center">
                                        <h3 class="mb-0">Solana</h3>
                                        {{--<div class="price">
                                            <i class="fa-regular fa-dollar"></i> 27,472.25
                                            <span class="down">3%</span>
                                        </div>--}}
                                    </div>
                                </div>
                                {{--<ul class="list-unstyled mb-0 fw-bold">
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Block</span>
                                        <span class="coin-value">789,257</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Transactions</span>
                                        <span class="coin-value">836,066,692</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Latest block</span>
                                        <span class="coin-value">19 min ago</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Transactions per second</span>
                                        <span class="coin-value">3.55</span>
                                    </li>
                                </ul>--}}
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="#" title="" class="coin-wrap">
                                <div class="d-flex justify-content-between align-items-center flex-md-row flex-column">
                                    <img src="{{asset('assets/frontend/images/coins/avalanche.png')}}" alt="" class="me-md-3 me-auto ms-auto mb-md-0 mb-3">
                                    <div class="flex-grow-1 text-md-start text-center">
                                        <h3 class="mb-0">Avalanche</h3>
                                        {{--<div class="price">
                                            <i class="fa-regular fa-dollar"></i> 27,472.25
                                            <span class="down">3%</span>
                                        </div>--}}
                                    </div>
                                </div>
                                {{--<ul class="list-unstyled mb-0 fw-bold">
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Block</span>
                                        <span class="coin-value">789,257</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Transactions</span>
                                        <span class="coin-value">836,066,692</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Latest block</span>
                                        <span class="coin-value">19 min ago</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Transactions per second</span>
                                        <span class="coin-value">3.55</span>
                                    </li>
                                </ul>--}}
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="#" title="" class="coin-wrap">
                                <div class="d-flex justify-content-between align-items-center flex-md-row flex-column">
                                    <img src="{{asset('assets/frontend/images/coins/tron.png')}}" alt="" class="me-md-3 me-auto ms-auto mb-md-0 mb-3">
                                    <div class="flex-grow-1 text-md-start text-center">
                                        <h3 class="mb-0">Tron</h3>
                                        {{--<div class="price">
                                            <i class="fa-regular fa-dollar"></i> 27,472.25
                                            <span class="down">3%</span>
                                        </div>--}}
                                    </div>
                                </div>
                                {{--<ul class="list-unstyled mb-0 fw-bold">
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Block</span>
                                        <span class="coin-value">789,257</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Transactions</span>
                                        <span class="coin-value">836,066,692</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Latest block</span>
                                        <span class="coin-value">19 min ago</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Transactions per second</span>
                                        <span class="coin-value">3.55</span>
                                    </li>
                                </ul>--}}
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="#" title="" class="coin-wrap">
                                <div class="d-flex justify-content-between align-items-center flex-md-row flex-column">
                                    <img src="{{asset('assets/frontend/images/coins/polygon.png')}}" alt="" class="me-md-3 me-auto ms-auto mb-md-0 mb-3">
                                    <div class="flex-grow-1 text-md-start text-center">
                                        <h3 class="mb-0">Polygon</h3>
                                        {{--<div class="price">
                                            <i class="fa-regular fa-dollar"></i> 27,472.25
                                            <span class="down">3%</span>
                                        </div>--}}
                                    </div>
                                </div>
                                {{--<ul class="list-unstyled mb-0 fw-bold">
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Block</span>
                                        <span class="coin-value">789,257</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Transactions</span>
                                        <span class="coin-value">836,066,692</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Latest block</span>
                                        <span class="coin-value">19 min ago</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Transactions per second</span>
                                        <span class="coin-value">3.55</span>
                                    </li>
                                </ul>--}}
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="#" title="" class="coin-wrap">
                                <div class="d-flex justify-content-between align-items-center flex-md-row flex-column">
                                    <img src="{{asset('assets/frontend/images/coins/chainlink.png')}}" alt="" class="me-md-3 me-auto ms-auto mb-md-0 mb-3">
                                    <div class="flex-grow-1 text-md-start text-center">
                                        <h3 class="mb-0">Chainlink</h3>
                                        {{--<div class="price">
                                            <i class="fa-regular fa-dollar"></i> 27,472.25
                                            <span class="down">3%</span>
                                        </div>--}}
                                    </div>
                                </div>
                                {{--<ul class="list-unstyled mb-0 fw-bold">
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Block</span>
                                        <span class="coin-value">789,257</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Transactions</span>
                                        <span class="coin-value">836,066,692</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Latest block</span>
                                        <span class="coin-value">19 min ago</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Transactions per second</span>
                                        <span class="coin-value">3.55</span>
                                    </li>
                                </ul>--}}
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="#" title="" class="coin-wrap">
                                <div class="d-flex justify-content-between align-items-center flex-md-row flex-column">
                                    <img src="{{asset('assets/frontend/images/coins/flow.png')}}" alt="" class="me-md-3 me-auto ms-auto mb-md-0 mb-3">
                                    <div class="flex-grow-1 text-md-start text-center">
                                        <h3 class="mb-0">Flow</h3>
                                        {{--<div class="price">
                                            <i class="fa-regular fa-dollar"></i> 27,472.25
                                            <span class="down">3%</span>
                                        </div>--}}
                                    </div>
                                </div>
                                {{--<ul class="list-unstyled mb-0 fw-bold">
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Block</span>
                                        <span class="coin-value">789,257</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Transactions</span>
                                        <span class="coin-value">836,066,692</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Latest block</span>
                                        <span class="coin-value">19 min ago</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Transactions per second</span>
                                        <span class="coin-value">3.55</span>
                                    </li>
                                </ul>--}}
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="#" title="" class="coin-wrap">
                                <div class="d-flex justify-content-between align-items-center flex-md-row flex-column">
                                    <img src="{{asset('assets/frontend/images/coins/heco.png')}}" alt="" class="me-md-3 me-auto ms-auto mb-md-0 mb-3">
                                    <div class="flex-grow-1 text-md-start text-center">
                                        <h3 class="mb-0">Heco</h3>
                                        {{--<div class="price">
                                            <i class="fa-regular fa-dollar"></i> 27,472.25
                                            <span class="down">3%</span>
                                        </div>--}}
                                    </div>
                                </div>
                                {{--<ul class="list-unstyled mb-0 fw-bold">
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Block</span>
                                        <span class="coin-value">789,257</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Transactions</span>
                                        <span class="coin-value">836,066,692</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Latest block</span>
                                        <span class="coin-value">19 min ago</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Transactions per second</span>
                                        <span class="coin-value">3.55</span>
                                    </li>
                                </ul>--}}
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="#" title="" class="coin-wrap">
                                <div class="d-flex justify-content-between align-items-center flex-md-row flex-column">
                                    <img src="{{asset('assets/frontend/images/coins/zilliqa.png')}}" alt="" class="me-md-3 me-auto ms-auto mb-md-0 mb-3">
                                    <div class="flex-grow-1 text-md-start text-center">
                                        <h3 class="mb-0">Zilliqa</h3>
                                        {{--<div class="price">
                                            <i class="fa-regular fa-dollar"></i> 27,472.25
                                            <span class="down">3%</span>
                                        </div>--}}
                                    </div>
                                </div>
                                {{--<ul class="list-unstyled mb-0 fw-bold">
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Block</span>
                                        <span class="coin-value">789,257</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Transactions</span>
                                        <span class="coin-value">836,066,692</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Latest block</span>
                                        <span class="coin-value">19 min ago</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="coin-caption">Transactions per second</span>
                                        <span class="coin-value">3.55</span>
                                    </li>
                                </ul>--}}
                            </a>
                        </div>
                        <div class="col-lg-12 col-md-12 text-center">
                            <h4 class="my-3">300K+ tokens, dApps, NFT and DeFi protocols</h4>
                        </div>
                    </div>
                </div>
            </section>
            {{--<section class="bg-custom-dark py-5">
                <div class="container-xl container-fluid">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-6 order-md-2 order-1">
                            <img src="{{asset('assets/frontend/images/api.png')}}" alt="" class="img-fluid mb-md-0 mb-3">
                        </div>
                        <div class="col-md-6 order-md-1 order-2">
                            <h2>1 API for 17 Blockchains</h2>
                            <h3 class="fs-5">Join thousands of crypto companies, analysts, academics, and students which utilize Blockchair’s REST API to fetch data and power their projects</h3>
                            <ul class="list-unstyled list-main my-3">
                                <li>Never-ending data insights for 17 blockchains</li>
                                <li>Sort and filter data with our SQL-like queries</li>
                                <li>Integrate news from 60 crypto outlets into your app</li>
                            </ul>
                            <a href="#" class="btn btn-main-2 px-5">Discover API</a>
                        </div>
                    </div>
                </div>
            </section>--}}
            <section class="py-5">
                <div class="container-xl container-fluid">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-12 text-center mb-5">
                            <h2>Spyderlab Features</h2>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center mb-5">
                        <div class="col-md-4 order-md-2 order-1">
                            <img src="{{asset('assets/frontend/images/featured/AML Risk Score.png')}}" alt="" class="img-fluid mb-md-0 mb-3">
                        </div>
                        <div class="col-md-8 order-md-1 order-2">
                            <h3>AML Risk Score</h3>
                            <p style="text-align: justify">An AML risk score is an assigned value to a crypto address, determined by their blockchain interactions using Spyder AI's intelligence database. It offers users valuable insight into the extent of suspicious activity associated with that address.</p>
                            <a href="#" class="btn btn-main-2 px-2">Get Started</a>
                        </div>
                    </div>
                    <hr class="mt-5 pb-5">
                    <div class="row justify-content-center align-items-center mb-5">
                        <div class="col-md-4">
                            <img src="{{asset('assets/frontend/images/featured/Address Labels.png')}}" alt="" class="img-fluid mb-md-0 mb-3">
                        </div>
                        <div class="col-md-8">
                            <h3>Address Labels</h3>
                            <p style="text-align: justify">Labels on blockchain addresses aid users in distinguishing between various types of addresses, including exchanges, MEV bots, crypto whales, smart contracts, and more, facilitating better identification and understanding of different entities operating within the blockchain ecosystem.</p>
                            <a href="#" class="btn btn-main px-2">Get Started</a>
                        </div>
                    </div>
                    <hr class="mt-5 pb-5">
                    <div class="row justify-content-center align-items-center mb-5">
                        <div class="col-md-4 order-md-2 order-1">
                            <img src="{{asset('assets/frontend/images/featured/Transaction Analysis.png')}}" alt="" class="img-fluid mb-md-0 mb-3">
                        </div>
                        <div class="col-md-8 order-md-1 order-2">
                            <h3>Transaction Analysis</h3>
                            <p style="text-align: justify">Spyderlab simplifies the process of understanding address history on the block explorer by utilizing on-chain analytics, transforming complex past data into a user-friendly and readily accessible format.</p>
                            <a href="#" class="btn btn-main-2 px-2">Get Started</a>
                        </div>
                    </div>
                    <hr class="mt-5 pb-5">
                    <div class="row justify-content-center align-items-center mb-5">
                        <div class="col-md-4">
                            <img src="{{asset('assets/frontend/images/featured/Time Analysis.png')}}" alt="" class="img-fluid mb-md-0 mb-3">
                        </div>
                        <div class="col-md-8">
                            <h3>Time Analysis</h3>
                            <p style="text-align: justify">Users can predict time zones and active time periods by segmenting transactions on an address based on the time of signature.</p>
                            <a href="#" class="btn btn-main px-2">Get Started</a>
                        </div>
                    </div>
                    <hr class="mt-5 pb-5">
                    <div class="row justify-content-center align-items-center mb-5">
                        <div class="col-md-4 order-md-2 order-1">
                            <img src="{{asset('assets/frontend/images/featured/Visual Display.png')}}" alt="" class="img-fluid mb-md-0 mb-3">
                        </div>
                        <div class="col-md-8 order-md-1 order-2">
                            <h3>Visual Display</h3>
                            <p style="text-align: justify">Combining blockchain analytics and data filtering, we create a dynamic visual display that offers a clean and readable user experience.</p>
                            <a href="#" class="btn btn-main-2 px-2">Get Started</a>
                        </div>
                    </div>
                    <hr class="mt-5 pb-5">
                    <div class="row justify-content-center align-items-center mb-5">
                        <div class="col-md-4">
                            <img src="{{asset('assets/frontend/images/featured/Favorite Address.png')}}" alt="" class="img-fluid mb-md-0 mb-3">
                        </div>
                        <div class="col-md-8">
                            <h3>Favorite Address</h3>
                            <p style="text-align: justify">Build a convenient list of addresses for effortless tracking, viewing, and exploration.</p>
                            <a href="#" class="btn btn-main px-2">Get Started</a>
                        </div>
                    </div>
                    <hr class="mt-5 pb-5">
                    <div class="row justify-content-center align-items-center mb-5">
                        <div class="col-md-4 order-md-2 order-1">
                            <img src="{{asset('assets/frontend/images/featured/Monitoring & Alerts.png')}}" alt="" class="img-fluid mb-md-0 mb-3">
                        </div>
                        <div class="col-md-8 order-md-1 order-2">
                            <h3>Monitoring & Alerts</h3>
                            <p style="text-align: justify">Real-time monitoring of specific addresses with instant notifications. Automatically store and access information for viewing, searching, and downloading anytime.</p>
                            <a href="#" class="btn btn-main-2 px-2">Get Started</a>
                        </div>
                    </div>
                    <hr class="mt-5 pb-5">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-4">
                            <img src="{{asset('assets/frontend/images/featured/investigation.png')}}" alt="" class="img-fluid mb-md-0 mb-3">
                        </div>
                        <div class="col-md-8">
                            <h3>Investigations</h3>
                            <p style="text-align: justify">Track, analyze, and collaborate on cases effortlessly with our powerful investigation tools. Stay organized with automatic saving and seamless note-taking. Simplify complex investigations and work together with colleagues for future success.</p>
                            <a href="#" class="btn btn-main px-2">Get Started</a>
                        </div>
                    </div>
                </div>
            </section>
            @include('frontend.layouts.partials.alert-message')
        </main>
        @endsection
        @section('scripts')
        <script type="text/javascript">
            var auth = @json(route('is-authenticated'));
            var id = @json((Auth()->user() != null) ? Auth()->user()->id : '');
            var url = @json((route('blockchain-search')));
    //alert(auth);

    $('.address-search-form').on('submit',function(){
        
        $.ajax({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            url:auth,
            method:'get',
            success:function(data){

                var keyword = $('.keyword').val();
                var newUrl = url+'?keyword='+keyword;
                
                if(data.auth_check == false){

                 $('.loginbtn').attr('href',newUrl);
                 $('#scrollTop').removeClass('d-none');
                 $('html, body').animate({
                    scrollTop: $("#scrollTop").offset().top - 48
                }, 500);
                 setTimeout(function(){ $("#blockchain_search_result").fadeIn(); },600);
                 $(".divRefresh").load(location.href + " .divRefresh");
                 
             }else{
               location.href = newUrl;
               $(".divRefresh").load(location.href + " .divRefresh");
           }
       }
   });    
        return false;
    })
</script>
@endsection