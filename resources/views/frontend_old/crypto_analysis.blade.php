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
    ['title' => 'Crypto Analysis']
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
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Crypto Analysis</li>
                        </ol>
                    </nav>
                    <h1 class="fs-2 mb-0">Crypto Analysis</h1>
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
                <div class="col-lg-10">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="coin-item">
                                <div class="row align-items-center">
                                    <div class="col-md-12 text-md-start text-center">
                                        <h2 class="mb-0"><i class="fa-light fa-search"></i>  Crypto Analysis</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="coin-item my-3">
                                <div class="row">
                                    <div class="col-lg-12 col-12">
                                        <h2 class="text-center">Risk Analysis, Intelligent Tracking</h2>
                                    </div>
                                    <div class="col-lg-12 py-3">
                                        <form action="{{urlencode(route('blockchain-search'))}}" method="GET" class="address-search-form">
                                           <div class="input-group">
                                            <input type="text" name="keyword" class="form-control keyword" placeholder="Search by Address / ENS / Txn Hash">
                                            <button type="submit" class="btn btn-main-2">Search</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-lg-12">
                                    <p class="mb-0 text-center"><i class="fa-solid fa-fire-flame-curved text-danger me-2"></i> Recent Hot Event {{--<a href="#" class="custom-link">RocketSwap Exploiter (<span data-bs-toggle="tooltip" data-bs-title="qp3wjpa3tjlj042z2wv7hahsldgwhwy0rq9sywjpyy">qp....pyy</span>)</a>--}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="coin-item my-3">
                            <div class="row align-items-center border-bottom pb-3 mb-2">
                                <div class="col-md-6 text-md-start text-center">
                                    <h2 class="mb-md-0 mb-3"><i class="fa-light fa-star"></i>  Favorites</h2>
                                </div>
                                <div class="col-md-6 text-md-end text-center">
                                    <a href="{{route('favorites')}}" class="custom-link">More <i class="fa-light fa-angle-right"></i></a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Wallet Address</th>
                                                    <th>Note</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $i=0;
                                                @endphp
                                                @forelse($fevourits as $fevourits_data)
                                                <tr>
                                                    <td><p class="mb-0 text-truncate txn-address" data-bs-toggle="tooltip" data-bs-original-title="{{$fevourits_data->address ?? ''}}">{{$fevourits_data->address ?? ''}}</p></td>
                                                    <td>{{$fevourits_data->description ?? ''}}</td>
                                                </tr>
                                                @php
                                                $i++;
                                                @endphp
                                                @empty
                                                <tr>
                                                    <td colspan="2">Not record found.</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="coin-item my-3">
                            <div class="row align-items-center border-bottom pb-3 mb-2">
                                <div class="col-md-6 text-md-start text-center">
                                    <h2 class="mb-md-0 mb-3"><i class="fa-light fa-radar"></i>  Investigations</h2>
                                </div>
                                <div class="col-md-6 text-md-end text-center">
                                    <a href="{{route('investigation.index')}}" class="custom-link">More <i class="fa-light fa-angle-right"></i></a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Wallet Address</th>
                                                    <th>Created At (UTC)</th>
                                                    <th>Note</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $j=0;
                                                @endphp
                                                @forelse($investigation as $investigation_data)
                                                <tr>
                                                    <td class="mb-0 text-truncate txn-address" data-bs-toggle="tooltip" data-bs-original-title="{{$investigation_data->address ?? ''}}"> {{\Illuminate\Support\Str::limit($investigation_data->address ?? '', 15, $end='...') }}</td>
                                                    <td>{{$investigation_data->created_at ?? ''}}</td>
                                                    <td class="mb-0 text-truncate txn-address" data-bs-toggle="tooltip" data-bs-original-title="{{$investigation_data->description ?? ''}}">{{ \Illuminate\Support\Str::limit($investigation_data->description ?? '', 15, $end='...')}}</td>
                                                </tr>
                                                @php
                                                $j++;
                                                @endphp
                                                @empty
                                                <tr>
                                                    <td colspan="3">Not record found.</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="coin-item my-3">
                            <div class="row align-items-center border-bottom pb-3 mb-2">

                                <div class="col-md-6 text-md-start text-center">
                                    <h2 class="mb-0"><i class="fa-light fa-light fa-sensor-triangle-exclamation"></i>  Unread Alert(s)</h2>
                                </div>

                                <div class="col-md-6 text-md-end text-center">
                                    <a href="{{route('alerts')}}" class="custom-link">More <i class="fa-light fa-angle-right"></i></a>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Token</th>
                                                    <th>Time(UTC)</th>
                                                    <th>Txn Has</th>
                                                    <th>Sender - Recipient</th>
                                                    <th>Amount</th>
                                                    <th>TXID</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($alerts as $alerts_data)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{asset('assets/frontend/images/coins/'.strtolower($alerts_data->token ?? '').'.png')}}" alt="{{$alerts_data->token ?? ''}}" class="me-1 coin-sm">
                                                            <span class="lh-1">{{$alerts_data->token ?? ''}}</span>
                                                        </div>
                                                    </td>
                                                    <td>{{$alerts_data->created_at ?? ''}}</td>
                                                    
                                                    <td class="mb-0 text-truncate txn-address" data-bs-toggle="tooltip" data-bs-original-title="{{$alerts_data->txn_has ?? ''}}">{{ \Illuminate\Support\Str::limit($alerts_data->txn_has ?? '', 15, $end='...')}}</td>

                                                    <td class="mb-0 text-truncate txn-address" data-bs-toggle="tooltip" data-bs-original-title="{{$alerts_data->address ?? ''}}">{{ \Illuminate\Support\Str::limit($alerts_data->address ?? '', 15, $end='...')}}</td>

                                                    <td>{{$alerts_data->txn_amount ?? ''}}</td>
                                                    
                                                    <td class="mb-0 text-truncate txn-address" data-bs-toggle="tooltip" data-bs-original-title="{{$alerts_data->txn_id ?? ''}}">{{ \Illuminate\Support\Str::limit($alerts_data->txn_id ?? '', 15, $end='...')}}</td>
                                                    
                                                </tr>    
                                                @empty
                                                <tr>
                                                    <td colspan="6">Not record found.</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
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