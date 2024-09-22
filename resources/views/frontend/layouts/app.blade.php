<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	@include('frontend.layouts.partials.header')
</head>
<body class="bg-custom-light">

	@include('frontend.layouts.partials.navigation')


	@yield('content')


	@include('frontend.layouts.partials.footer')
</body>
</html>