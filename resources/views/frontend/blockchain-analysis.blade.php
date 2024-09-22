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
    ['title' => 'Blockchain Analysis']
]) 
!!}

@endsection
@section('content')

<!-- Crypto tracking -->
<section class="crypto-tracking-section">
    <div class="container">
        <div class="crypto-tracking-details py-5">
            <div class="crypto-tracking-heading">
                <h2>A Crypto Tracking and Compliance Web3 background check</h2>
            </div>
            <div class="crypto-tracking-description">
                <p>Spyderlab is an anti-money laundering tracking system developed by the PDPL AML. We use on-chain analytics to assist in the tracing of illicit funds.</p> 
            </div>

            <form action="{{urlencode(route('blockchain-search'))}}" method="GET" class="address-search-form">

                <div class="search-container">

                <div class="searchBar">
            <input type="text" id="searchQueryInput" name="keyword" name="searchQueryInput" class="form-control keyword" placeholder="Search for addresses, transactions, url / web3 domain name">
                                                    
            <button id="searchQuerySubmit" class="btn btn-main btn-search" type="submit" name="searchQuerySubmit"><i class="fa fa-search"></i></button>
                </div>

                <div class="footer-label d-flex">
                    <span>search examples:</span>

                    <div class="wallet">
                        <i class="fa fa-wallet px-2"></i>Address
                    </div>

                    <div class="transaction">
                        <i class="fa-solid fa-arrows-left-right-to-line px-2"></i>Transaction
                    </div>

                    <div class="domain">
                        <i class="fa-solid fa-text-height px-2"></i>Url/Web3 domain name
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</section>
<!-- Crypto tracking -->

      <section class="support-chains">
        <div class="container">

            <!-- security waring -->
            <div class="security-search py-5 d-none" id="scrollTop">
                <div class="security-search-information">
                    <div class="security-box card">
                        <div class="d-flex">
                        <img src="{{asset('assets/frontend/images/crypto-tracking/shield.png')}}">
                        <h5><i class="fa fa-warning" style="color: red;"></i>  Focusing on Blockchain Ecosystem Security<i class="fa-solid fa-question"></i></h5>
                        </div>
                        <p>In security, slow is smooth, smooth is fast</p>
                    </div>
                </div>
                <div class="login-signup pt-5">
                    <div class="login-box card">
                        <div class="row">
                            <div class="col-md-6">
                                 <h4>Login or Signup to continue your search!</h4>
                            </div>
                            <div class="col-md-6">
                            <a href="{{route('login')}}"><button class="btn px-3 py-2">Login/signup</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           

            <div class="support-chains-information py-5">
                <div class="support-chains-heading">
                    <h2 class="text-center py-4">We currently support 15+ chains and following coins</h2>
                </div>
               <div class="following-coins">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card coins">
                            <div class="d-flex">
                            <img src="{{asset('assets/frontend/images/crypto-tracking/btc.png')}}">
                            <h3>Bitcoin</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card coins">
                            <div class="d-flex">
                            <img src="{{asset('assets/frontend/images/crypto-tracking/eth.png')}}">
                            <h3>Ethereum</h3>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card coins">
                            <div class="d-flex">
                            <img src="{{asset('assets/frontend/images/crypto-tracking/bnb.png')}}">
                            <h3>BNB</h3> <h5><span class="badge bg-success">New</span></h5>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card coins">
                            <div class="d-flex">
                            <img src="{{asset('assets/frontend/images/crypto-tracking/solana.png')}}">
                            <h3>Solana</h3>
                            </div>
                            
                            
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card coins">
                            <div class="d-flex">
                            <img src="{{asset('assets/frontend/images/crypto-tracking/avalanche.png')}}">
                            <h3>Avalanche</h3>
                            </div>
                            
                            
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card coins">
                            <div class="d-flex">
                            <img src="{{asset('assets/frontend/images/crypto-tracking/tron.png')}}">
                            <h3>Tron</h3>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card coins">
                            <div class="d-flex">
                            <img src="{{asset('assets/frontend/images/crypto-tracking/polygon.png')}}">
                            <h3>Polygon</h3>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card coins">
                            <div class="d-flex">
                            <img src="{{asset('assets/frontend/images/crypto-tracking/chainlink.png')}}">
                            <h3>Chainlink</h3>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card coins">
                            <div class="d-flex">
                            <img src="{{asset('assets/frontend/images/crypto-tracking/flow.png')}}">
                            <h3>Flow</h3>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card coins">
                            <div class="d-flex">
                            <img src="{{asset('assets/frontend/images/crypto-tracking/heco.png')}}">
                            <h3>Heco</h3>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card coins">
                            <div class="d-flex">
                            <img src="{{asset('assets/frontend/images/crypto-tracking/zilliqa.png')}}">
                            <h3>Zilliqa</h3>
                            </div>
                            
                        </div>
                    </div>
                </div>
               </div>
               <div class="footer-conins-information">
                <h5 class="text-center pt-5">300K+ tokens, dApps, NFT and DeFi protocols</h5>
               </div>
            </div>
        </div>
      </section>

      <!-- Spyderlab Features -->
       <section class="spyderlab-features">
        <div class="container">
            <div class="spyderlab-features-information py-5">
                <div class="spyderlab-features-heading">
                    <h2>Spyderlab Features</h2>
                </div>
                <!-- AML risk score -->
                <div class="risk-score py-5">
                    <div class="row">
                        <div class="col-md-8">
                            <h4>AML Risk Score</h4>
                            <p>An AML risk score is an assigned value to a crypto address, determined by their blockchain interactions using Spyder AI's intelligence database. It offers users valuable insight into the extent of suspicious activity associated with that address.</p>
                            <a href="#"><button class="btn btn-get-started">Get Started</button></a>
                        </div>
                        <div class="col-md-4">
                            <img src="{{asset('assets/frontend/images/crypto-tracking/AML Risk Score.png')}}">
                        </div>
                    </div>
                </div>

                <!-- Address labels -->
                <div class="address-label py-5">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{asset('assets/frontend/images/crypto-tracking/Address Labels.png')}}">  
                        </div>
                        <div class="col-md-8">
                            <h4>Address Labels</h4>
                            <p>Labels on blockchain addresses aid users in distinguishing between various types of addresses, including exchanges, MEV bots, crypto whales, smart contracts, and more, facilitating better identification and understanding of different entities operating within the blockchain ecosystem.</p>

                            <a href="#"><button class="btn btn-get-started">Get Started</button></a>
                        </div>
                    </div>
                </div>

                <!-- Transaction Analysis -->

                <div class="Transaction-Analysis py-5">
                    <div class="row">
                        <div class="col-md-8">
                            <h4>Transaction Analysis</h4>
                            <p>Spyderlab simplifies the process of understanding address history on the block explorer by utilizing on-chain analytics, transforming complex past data into a user-friendly and readily accessible format.</p>
                            <a href="#"><button class="btn btn-get-started">Get Started</button></a>
                        </div>
                        <div class="col-md-4">
                            <img src="{{asset('assets/frontend/images/crypto-tracking/Transaction Analysis.png')}}">
                        </div>
                    </div>
                </div>

                <!-- Time Analysis -->
               
                <div class="Time-Analysis py-5">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{asset('assets/frontend/images/crypto-tracking/Time Analysis.png')}}">
                           
                        </div>
                        <div class="col-md-8">
                            <h4>Time Analysis</h4>
                            <p>Users can predict time zones and active time periods by segmenting transactions on an address based on the time of signature.</p>
                            <a href="#"><button class="btn btn-get-started">Get Started</button></a>
                           
                        </div>
                    </div>
                </div>

                <!-- Visual Display -->
                <div class="Visual-Display py-5">
                    <div class="row">
                        <div class="col-md-8">
                            <h4>Visual Display</h4>
                            <p>Combining blockchain analytics and data filtering, we create a dynamic visual display that offers a clean and readable user experience.</p>
                            <a href="#"><button class="btn btn-get-started">Get Started</button></a>
                        </div>
                        <div class="col-md-4">
                            <img src="{{asset('assets/frontend/images/crypto-tracking/Visual Display.png')}}">
                        </div>
                    </div>
                </div>
                 <!-- Favorite Address -->
                 <div class="Favorite-Address py-5">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{asset('assets/frontend/images/crypto-tracking/Favorite Address.png')}}">
                            
                        </div>
                        <div class="col-md-8">
                            <h4>Favorite Address</h4>
                            <p>Build a convenient list of addresses for effortless tracking, viewing, and exploration.</p>
                            <a href="#"><button class="btn btn-get-started">Get Started</button></a>
                            
                        </div>
                    </div>
                </div>

                <!-- Monitoring & Alerts -->
                <div class="Monitoring-Alerts py-5">
                    <div class="row">
                        <div class="col-md-8">
                            <h4>Monitoring & Alerts</h4>
                            <p>Real-time monitoring of specific addresses with instant notifications. Automatically store and access information for viewing, searching, and downloading anytime.</p>
                            <a href="#"><button class="btn btn-get-started">Get Started</button></a>
                        </div>
                        <div class="col-md-4">
                            <img src="{{asset('assets/frontend/images/crypto-tracking/Monitoring & Alerts.png')}}">
                        </div>
                    </div>
                </div>

                <!-- Investigations -->
                <div class="Investigations py-5">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{asset('assets/frontend/images/crypto-tracking/investigation.png')}}">
                           
                        </div>
                        <div class="col-md-8">
                            <h4>Investigations</h4>
                            <p>Track, analyze, and collaborate on cases effortlessly with our powerful investigation tools. Stay organized with automatic saving and seamless note-taking. Simplify complex investigations and work together with colleagues for future success.</p>
                            <a href="#"><button class="btn btn-get-started">Get Started</button></a>
                            
                        </div>
                    </div>
                </div>

            </div>
        </div>
         @include('frontend.layouts.partials.alert-message')
       </section>
    <!-- Footer -->
@endsection

 @section('scripts')
        <script type="text/javascript">
            var auth = @json(route('is-authenticated'));
            var id = @json((Auth()->user() != null) ? Auth()->user()->id : '');
            var url = @json((route('blockchain-search')));

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