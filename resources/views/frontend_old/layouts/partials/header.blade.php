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
<link rel="stylesheet" href="{{asset('assets/frontend/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/frontend/vendors/font-awesome-v6.2.0/css/all.css')}}">
<link rel="stylesheet" href="{{asset('assets/frontend/vendors/font-awesome-v6.2.0/css/sharp-solid.css')}}">

<link rel="stylesheet" href="{{asset('assets/frontend/vendors/material-datetimepicker/css/materialDateTimePicker.css')}}">

<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

<link rel="stylesheet" href="{{asset('assets/frontend/css/sweetalert2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/frontend/css/partner-slider.css')}}">
<link rel="stylesheet" href="{{asset('assets/frontend/css/style.css')}}">
<link rel="stylesheet" href="{{asset('assets/frontend/css/responsive.css')}}">
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
<div id="google_translate_element"></div>