<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('title')
    <link href="{{asset('assets/frontend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/fontawesome/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/owlcarousel/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/owlcarousel/css/owl.theme.default.min.css')}}">
</head>
<body class="d-flex flex-column min-vh-100 not-found-bg">
    <section class="page-404-not-found py-5">
     @yield('content')
    </section>
    <!-- Footer -->
    <footer class="footer py-3" style="position: fixed; bottom:0px; width:100%;">
        <div class="container">
            <div class="copyright text-center py-2">
                <p>&copy; 2024 <a href="#" style="text-decoration: none;color: rgb(0, 166, 255);">Pattern Drive Private Limited</a>. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <!-- js -->
    <script src="{{asset('assets/frontend/jquery/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('assets/frontend/owlcarousel/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('assets/frontend/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/frontend/fontawesome/js/all.min.js')}}"></script>
    <script src="{{asset('assets/frontend/js/main.js')}}"></script>
    
</body>
</html>
