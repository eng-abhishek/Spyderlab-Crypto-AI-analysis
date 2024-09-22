<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

@yield('og')
<link rel="icon" href="{{asset('assets/frontend/images/icons/favicon.png')}}" type="image/png" sizes="32x32"
media="(prefers-color-scheme:no-preference)">
<link href="{{asset('assets/frontend/images/icons/favicon.png')}}" rel="icon" type="image/png" sizes="32x32"
media="(prefers-color-scheme: dark)" />
<link href="{{asset('assets/frontend/images/icons/favicon.png')}}" rel="icon" type="image/png" sizes="32x32"
media="(prefers-color-scheme: light)" />

<link href="{{asset('assets/frontend/css/bootstrap.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/frontend/css/style.css')}}">
<link rel="stylesheet" href="{{asset('assets/frontend/fontawesome/css/all.min.css')}} ">
<link rel="stylesheet" href="{{asset('assets/frontend/owlcarousel/css/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/frontend/owlcarousel/css/owl.theme.default.min.css')}}">

  <!-- Toastr -->
  <link href="{{ asset('assets/backend/plugins/toastr/css/toastr.min.css') }}" rel="stylesheet">
  <!-- Toastr -->
  
<script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="f77769de-750d-424c-ae54-78aae84d7d2c";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>
<style type="text/css">
.skiptranslate{
	display: none;
}
.bg-custom-light{
	top:0px !important;
}
.VIpgJd-ZVi9od-l4eHX-hSRGPd{
   display: none;
}
</style>
@yield('styles')