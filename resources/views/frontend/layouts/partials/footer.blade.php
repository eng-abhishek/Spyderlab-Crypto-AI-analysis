@include('frontend.layouts.partials.alert-message')
    <footer class="footer py-3">
        <div class="container">
            <div class="footer-information py-4">
                <div class="row ">
                    <div class="col-md-3">
                        <div class="heading">
                            Language
                        </div>
                        <ul>
                            <div class="d-flex">
                                <li><a href="">English</a></li>
                                <li><a href="">Română</a></li>
                            </div>

                            <div class="d-flex">
                                <li><a href="">Español</a></li>
                                <li><a href="">Polski</a></li>
                            </div>

                            <div class="d-flex">
                                <li><a href="">Français</a></li>
                                <li><a href="">Українська</a></li>

                            </div>
                            <div class="d-flex">
                                <li><a href="">Italiano</a></li>
                                <li><a href="">Кыргыз</a></li>

                            </div>
                            <div class="d-flex">
                                <li><a href="">Nederlands</a></li>
                                <li><a href="">Қазақша</a></li>
                            </div>
                            
                        </ul>

                    </div>
                    <div class="col-md-3">
                        <div class="heading">
                            Support
                        </div>
                        <ul class="support">
                            <li><a href="">Create Ticket</a></li>
                            <li><a href="">Knowledge Base</a></li>
                            <li><a href="{{route('contact-us')}}">Contact Us</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <div class="heading">
                            Company
                        </div>
                        <ul class="company">
                            <li><a href="{{route('about-us')}}">About Us</a></li>
                            <li><a href="">Acceptable Usage Policy</a></li>
                            <li><a href="{{route('privacy-policy')}}">Privacy Policy</a></li>
                            <li><a href="{{route('terms-of-service')}}">Terms of Service</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <div class="logo">
                            <a href=""><img src="{{asset('assets/frontend/images/logo.png')}}"></a> 
                        </div>
                        <div class="about">
                            <p>
                                Spyderlab.org is a leading blockchain forensic, dark web intelligence & OSINT platform.
                            </p>
                        </div>
                        <div class="social">
                            <a href="https://www.facebook.com/spyderlab" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="https://www.x.com/spyderlab" target="_blank"><i class="fa-brands fa-x-twitter"></i></a>
                            <a href="https://www.t.me/spyderlab" target="_blank"><i class="fa-brands fa-telegram"></i></a>
                            <a href="" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                            <a href="" target="_blank"><i class="fa-brands fa-pinterest-p"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="copyright text-center py-2">
            <p>&copy; 2024 <a href="#" style="text-decoration: none;color: rgb(0, 166, 255);">Pattern Drive Private Limited</a>. All rights reserved.</p>
        </div>
    </footer>
        <!-- js -->
    <script src="{{asset('assets/frontend/jquery/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('assets/frontend/owlcarousel/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('assets/frontend/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/frontend/fontawesome/js/all.min.js')}}"></script>
    <script src="{{asset('assets/frontend/js/main.js')}}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
      <!-- toastr -->
    <script src="{{asset('assets/backend/plugins/toastr/js/toastr.min.js') }}"></script>
    <!-- blockUI -->
    <script src="{{asset('assets/backend/plugins/blockUI/js/jquery.blockUI.js') }}"></script>
    <script type="text/javascript">
        /*Block UI CSS*/
        $.blockUI.defaults.css.border = 'none'; 
        $.blockUI.defaults.css.padding = '15px';
        $.blockUI.defaults.css.backgroundColor = '#000';
        $.blockUI.defaults.css.opacity = '0.8';
        $.blockUI.defaults.css.color = '#fff';
        $.blockUI.defaults.css.borderRadius = '10px';
        $.blockUI.defaults.css.zIndex = '2000';
        /*Block UI CSS*/
    </script>
    @yield('scripts')