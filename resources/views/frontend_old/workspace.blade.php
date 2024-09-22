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
    ['title' => 'Workspace']
]) 
!!}

@endsection

@section('styles')
<style type="text/css">
    .btn-crypto-node{
        font-size: 10px;
        font-weight: bold;
    }
</style>
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
                            <li class="breadcrumb-item active">Workspace</li>
                        </ol>
                    </nav>
                    <h1 class="fs-2 mb-0">Workspace</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-custom-light py-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-2">
                    @include('frontend.layouts.partials.account-sidebar')
                </div>
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="coin-item">
                                <div class="row align-items-center">
                                    <div class="col-md-12 text-md-start text-center">
                                        <h2 class="mb-0"><i class="fa-light fa-desktop"></i>  Workspace</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="coin-item my-3">
                                <div class="row align-items-center border-bottom pb-3 mb-2">
                                    <div class="col-md-6 text-md-start text-center">
                                        <h3 class="mb-md-0 mb-3"> User Credits</h3>
                                    </div>
                                    <div class="col-md-6 text-md-end text-center">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Total Credit(s)</th>
                                                        <th>
                                                            <div class="d-flex align-items-lg-center align-items-start flex-lg-row flex-column">
                                                                <p class="mb-0">{{available_credits()}}</p>
                                                                <a href="{{route('pricing')}}" class="mx-lg-3 mx-0 my-lg-0 my-3 custom-link"><i class="fa-light fa-up-from-line me-1"></i> Buy Credits</a>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">

                    <div class="container-fluid system-status-box">

                        <div class="row">
                            <div class="col-12">
                                <h6 class="system-status-hd">System status</h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">

                                <h6 class="system-status-opt mt-3">Crypto Node
                                    <label class="online-tag">Online</label>
                                    {{--<label class="offline-tag">Offline</label>--}}
                                </h6>
                                <h6 class="system-status-opt mt-4">OSINT node
                                    <label class="online-tag">Online</label>
                                    {{--<label class="offline-tag">Offline</label>--}}
                                </h6>
                                <h6 class="system-status-opt mt-4">Darknet Tor Node
                                    <label class="online-tag">Online</label>
                                    {{--<label class="offline-tag">Offline</label>--}}
                                </h6>

                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>
</main>
@endsection
@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\ContactUsRequest', '#contact-form'); !!}
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
                location.href = newUrl;
            }
        });    
        return false;
    })

</script>
@endsection