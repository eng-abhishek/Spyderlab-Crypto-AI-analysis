 <footer>
    <div class="footer-bottom py-3">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-8 mb-md-0 mb-3 text-md-start text-center">
                    <p class="mb-0">Copyright &copy; {{date('Y')}} <a href="https://www.patterndrive.com/" target="_blank" class="custom-link">Pattern Drive Private Limited</a>. All Rights Reserved.</p>
                </div>
                <div class="col-md-4 mb-md-0 mb-3 text-md-end text-center">
                    <ul class="nav social-media justify-content-md-end justify-content-center">
                        <li class="nav-item"><a href="#" class="nav-link" target="_blank" title="Facebook"><span class="social-icon icon-facebook"></span></a></li>
                        <li class="nav-item"><a href="#" class="nav-link" target="_blank" title="X"><span class="social-icon icon-x"></span></a></li>
                        <li class="nav-item"><a href="#" class="nav-link" target="_blank" title="Instagram"><span class="social-icon icon-instagram"></span></a></li>
                        <li class="nav-item"><a href="#" class="nav-link" target="_blank" title="YouTube"><span class="social-icon icon-youtube"></span></a></li>
                        <li class="nav-item"><a href="#" class="nav-link" target="_blank" title="Pinterest"><span class="social-icon icon-pinterest"></span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<!---------------- Transation Modal --------------->
<div class="modal fade custom-modal" id="transactionModal">
    <div class="modal-dialog modal-xl modal-fullscreen-xl-down">
        <div class="modal-content">
            <div class="modal-header section-home">
                <h4 class="modal-title fs-6">Transactions</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-custom-light" id="blockcypher-txn-detail">
                <div class="table-responsive txn-details">

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Activation Modal -->
<div class="modal fade activationModal" id="activationModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title fs-6">Account activation pending</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-12 text-center">
                        <img src="{{asset('assets/frontend/images/id-card.png')}}" alt="">
                        <p>Please e-mail us a picture of your department ID card to <a href="mailto:{{config('mail.kyc_verification_mail')}}" class="fw-bold text-light">kyc@spyderlab.org</a></p>
                        <!-- <a href="activate.html" class="btn btn-main-2 px-5 rounded-pill">Activate Account</a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Activation Modal -->
@if( (plan_expire_at() == 'Y') AND (plan_is_expire() == 'N') AND (auth()->user()))
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div class="toast align-items-center text-bg-danger border-0 fade show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Your current plan will expire soon, please Renew / Upgrade your plan.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
@endif

@if( (plan_is_expire() == 'Y') AND (auth()->user()) )
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div class="toast align-items-center text-bg-danger border-0 fade show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Your plan has expired, If you want to countinue the service, please Renew / Upgrade your plan.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
@endif
<script src="{{asset('assets/frontend/js/jquery-3.6.1.min.js')}}"></script>
<!-- toastr 
   <script src="{{asset('assets/frontend//js/toastr.min.js') }}"></script>
-->
<script src="{{asset('assets/frontend/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/main.js')}}"></script>
<script src="{{asset('assets/frontend/vendors/material-datetimepicker/js/moment.min.js')}}"></script>
<script src="{{asset('assets/frontend/vendors/material-datetimepicker/js/materialDateTimePicker.js')}}"></script>

<script src="{{asset('assets/frontend/js/jquery.blockUI.js')}}"></script>

<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>

<script src="http://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script>

<script src="{{asset('assets/frontend/vendors/stellernav/js/stellarnav.min.js')}}"></script>

<script src="{{asset('assets/frontend/js/sweetalert2.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

<script type="text/javascript">
    var auth_user = @json(auth()->user());
    var setting = @json(\App\Models\Setting::find('1'));
    var is_admin_logged_in = @json(auth()->guard('backend')->check());
    var current_route = @json(\Request::route()->getName());
    var restricted_routes = ['search.index', 'search.submit', 'blockchain-analysis', 'blockchain-search'];

    $(document).ready(function(){
        if(restricted_routes.includes(current_route)){
            setInterval(function() {
                check_kyc_status();
            }, 5000);
        }
    });

    function check_kyc_status(){
  
        if(JSON.parse(setting.value).activation_popup == 'Y'){
        if(!is_admin_logged_in && auth_user != null && auth_user.kyc_verified_at == null){
            $('#activationModal').modal('show');
        }
        }
    }

 function hc(dc){
        lang = Cookies.get('language');
        if(lang != dc){
            window.location.hash = 'googtrans(en|' + dc + ')';
            //location.reload();
            Cookies.set('language', dc);
        }
 }

    $.ajax({
        type: "GET",
        url: "https://geolocation-db.com/jsonp/",
        jsonpCallback: "callback",
        dataType: "jsonp",
        success: function( location ) {
            $('#country').html(location.country_code);
            co = location.country_code;
            co = co.toLowerCase();
            hc(co); // Replace here
        }
    });

    function googleTranslateElementInit() {
        new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
    }
    </script>
@yield('scripts')