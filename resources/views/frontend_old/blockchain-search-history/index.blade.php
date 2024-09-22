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
                            <li class="breadcrumb-item active">Blockchain Search History</li>
                        </ol>
                    </nav>
                    <h1 class="fs-2 mb-0">Blockchain Search History</h1>
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
        <div class="container-fluid">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-12 col-md-12">
                    <div class="p-3 mb-3">
                        <div class="table-responsive mb-3">
                            <table class="table table-bordered table-list">
                                <thead>
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>IP</th>
                                        <th>Keyword</th>
                                        <th>Status</th>
                                        <th>Location</th>
                                        <th>User Agent</th>
                                        <th>Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @forelse($records as $key => $value)
                                  <tr>
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{$value->ip_address}}</td>
                                    <td>{{$value->search->keyword}}</td>
                                    <td>{{$value->search->status_code}}</td>
                                    <td>
                                        @php
                                        $location = "";
                                        if(!is_null($value->location)){
                                        $location_obj = json_decode($value->location);
                                        $location = 'City: <span class="fw-bold">'.$location_obj->city.'</span>';
                                        $location .= '<br>State: <span class="fw-bold">'.$location_obj->state.'</span>';
                                        $location .= '<br>Country: <span class="fw-bold">'.$location_obj->country.'</span>';
                                    }
                                    echo $location;
                                    @endphp
                                </td>
                                <td>{{$value->user_agent}}</td>
                                <td>{{$value->created_at->format('Y-m-d H:i:s')}}</td>
                                <td class="text-center"><a href="{{route("blockchain-search-history.show", ['id' => $value->search_id])}}" class="btn btn-main-2 btn-sm rounded-0"><i class="fa-regular fa-eye"></i></a></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8">No record found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="custom-pagination float-end">
                    {{$records->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
</section>

@if(session()->has('status'))
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div class="toast align-items-center text-bg-{{session('status')}} border-0 fade show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                {{session('message')}}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
@endif

@endsection
</main>