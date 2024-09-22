<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8" />

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>@yield('title', config('app.name', 'SpyderLab'))</title>

	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="" />
	<meta name="author" content="" />

	<link rel="icon" href="{{asset('assets/frontend/images/favicon.png')}}" type="image/png">
	<link href="{{asset('assets/frontend/images/favicon-light.png')}}" rel="icon" media="(prefers-color-scheme: light)"/>
	<link href="{{asset('assets/frontend/images/favicon-dark.png')}}" rel="icon" media="(prefers-color-scheme: dark)"/>

	<!-- ================== BEGIN core-css ================== -->
	<link href="{{asset('assets/backend/css/vendor.min.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/backend/css/app.min.css')}}" rel="stylesheet" />
	<link rel="stylesheet" href="{{asset('assets/frontend/vendors/font-awesome-v6.2.0/css/all.css')}}">
	<!-- ================== END core-css ================== -->

	<!--begin::Page Vendors Styles -->
	<link href="{{asset('assets/backend/plugins/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
	<!--end::Page Vendors Styles -->

	<!-- Datatable -->
	<link rel="stylesheet" href="{{asset('assets/backend/plugins/datatables/css/datatables.min.css')}}">

	<!-- Sweet Alert 2 CSS -->
	<link href="{{ asset('assets/backend/plugins/sweet-alert/css/sweetalert2.min.css') }}" rel="stylesheet">

	<!-- Select 2 CSS -->
	<link href="{{ asset('assets/backend/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/backend/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet">

	<!-- Toastr -->
	<link href="{{ asset('assets/backend/plugins/toastr/css/toastr.min.css') }}" rel="stylesheet">
	<!-- Toastr -->	
	

	<!-- Toastr -->
	<link href="{{ asset('assets/backend/css/bootstrap-tagsinput.css') }}" rel="stylesheet">
	<!-- Toastr -->	
	

	@yield('styles')
</head>

<body>
	<!-- BEGIN #app -->
	<div id="app" class="app">
		<!-- BEGIN #header -->
		<div id="header" class="app-header">
			<!-- BEGIN desktop-toggler -->
			<div class="desktop-toggler">
				<button type="button" class="menu-toggler" data-toggle-class="app-sidebar-collapsed" data-dismiss-class="app-sidebar-toggled" data-toggle-target=".app">
					<span class="bar"></span>
					<span class="bar"></span>
					<span class="bar"></span>
				</button>
			</div>
			<!-- BEGIN desktop-toggler -->
			
			<!-- BEGIN mobile-toggler -->
			<div class="mobile-toggler">
				<button type="button" class="menu-toggler" data-toggle-class="app-sidebar-mobile-toggled" data-toggle-target=".app">
					<span class="bar"></span>
					<span class="bar"></span>
					<span class="bar"></span>
				</button>
			</div>
			<!-- END mobile-toggler -->
			
			<!-- BEGIN brand -->
			<div class="brand">
				<a href="{{route('backend.dashboard')}}" class="brand-logo">
					<span class="brand-img">
						<span class="brand-img-text text-theme">S</span>
					</span>
					<span class="brand-text">SPYDERLAB</span>
				</a>
			</div>
			<!-- END brand -->
			
			<!-- BEGIN menu -->
			<div class="menu">
				<div class="menu-item dropdown dropdown-mobile-full">
					<a href="#" data-bs-toggle="dropdown" data-bs-display="static" class="menu-link">
						<div class="menu-text d-sm-block d-none">{{auth()->user()->name}} <i class="fa-light fa-angle-down"></i></div>
					</a>
					<div class="dropdown-menu dropdown-menu-end me-lg-3 fs-11px mt-1">
						<a class="dropdown-item d-flex align-items-center" href="{{route('home')}}" target="_blank">VISIT SITE <i class="fa-light fa-globe ms-auto text-theme fs-16px my-n1"></i></a>
						<a class="dropdown-item d-flex align-items-center" href="{{route('backend.account.profile.view')}}">PROFILE <i class="fa-light fa-user ms-auto text-theme fs-16px my-n1"></i></a>
						<a class="dropdown-item d-flex align-items-center" href="{{route('backend.account.change-password.view')}}">PASSWORD <i class="fa-light fa-key ms-auto text-theme fs-16px my-n1"></i></a>
						<div class="dropdown-divider"></div>
						
						<a class="dropdown-item d-flex align-items-center" href="{{ route('backend.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">LOGOUT <i class="fa-light fa-right-from-bracket ms-auto text-theme fs-16px my-n1"></i></a>
						<form id="logout-form" action="{{ route('backend.logout') }}" method="POST" class="d-none">
							@csrf
						</form>
					</div>
				</div>
			</div>
			<!-- END menu -->
		</div>
		<!-- END #header -->
		
		<!-- BEGIN #sidebar -->
		<div id="sidebar" class="app-sidebar">
			<!-- BEGIN scrollbar -->
			<div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
				<!-- BEGIN menu -->
				<div class="menu">
					<div class="menu-header">Navigation</div>
					<div class="menu-item {{(Route::currentRouteName() == 'backend.dashboard')?'active':''}}">
						<a href="{{route('backend.dashboard')}}" class="menu-link">
							<span class="menu-icon"><i class="fa-regular fa-gauge-high"></i></span>
							<span class="menu-text">Dashboard</span>
						</a>
					</div>
					<div class="menu-item {{(Route::currentRouteName() == 'backend.users.index')?'active':''}}">
						<a href="{{route('backend.users.index')}}" class="menu-link">
							<span class="menu-icon"><i class="fa-regular fa-users"></i></span>
							<span class="menu-text">User Management</span>
						</a>
					</div>
					<div class="menu-item {{in_array(Route::currentRouteName(), ['backend.wallet-addresses.index', 'backend.wallet-addresses.create', 'backend.wallet-addresses.edit'])?'active':''}}">
						<a href="{{route('backend.wallet-addresses.index')}}" class="menu-link">
							<span class="menu-icon"><i class="fa-regular fa-address-card"></i></span>
							<span class="menu-text">Wallet Addresses</span>
						</a>
					</div>

					<div class="menu-item has-sub {{(in_array(Route::currentRouteName(), ['backend.search-histories.index', 'backend.search-results.index', 'backend.search-results.show']))?'active':''}}">
						<a href="#" class="menu-link">
							<span class="menu-icon">
								<i class="fa-regular fa-magnifying-glass"></i>
							</span>
							<span class="menu-text">Searches</span>
							<span class="menu-caret"><b class="caret"></b></span>
						</a>
						<div class="menu-submenu">
							<div class="menu-item {{(Route::currentRouteName() == 'backend.search-histories.index')?'active':''}}">
								<a href="{{route('backend.search-histories.index')}}" class="menu-link">
									<span class="menu-text">History</span>
								</a>
							</div>
							<div class="menu-item {{(Route::currentRouteName() == 'backend.search-results.index')?'active':''}}">
								<a href="{{route('backend.search-results.index')}}" class="menu-link">
									<span class="menu-text">Results</span>
								</a>
							</div>
						</div>
					</div>

					<div class="menu-item has-sub {{(in_array(Route::currentRouteName(), ['backend.posts.edit','backend.posts.index', 'backend.posts.tag.index','backend.posts.tag.edit', 'backend.posts.category.index', 'backend.posts.category.edit','backend.posts.comment.index','backend.posts.newsletter-email.index','backend.posts.view.index','backend.posts.comment.show']))?'active':''}}">

						<a href="#" class="menu-link">
							<span class="menu-icon">
								<i class="fa-regular fa-solid fa-blog"></i>
							</span>
							<span class="menu-text">Crypto Blog</span>
							<span class="menu-caret"><b class="caret"></b></span>
						</a>
						<div class="menu-submenu">

							<div class="menu-item {{(in_array(Route::currentRouteName(),['backend.posts.category.index','backend.posts.category.edit']))?'active':''}}">
								<a href="{{route('backend.posts.category.index')}}" class="menu-link">
									<span class="menu-text">Category</span>
								</a>
							</div>

							<div class="menu-item {{(in_array(Route::currentRouteName(),['backend.posts.tag.index','backend.posts.tag.edit']))?'active':''}}">
								<a href="{{route('backend.posts.tag.index')}}" class="menu-link">
									<span class="menu-text">Tag</span>
								</a>
							</div>

							<div class="menu-item {{(in_array(Route::currentRouteName(),['backend.posts.index','backend.posts.edit']))?'active':''}}}}">
								<a href="{{route('backend.posts.index')}}" class="menu-link">
									<span class="menu-text">Post</span>
								</a>
							</div>

							<div class="menu-item {{(in_array(Route::currentRouteName(),['backend.posts.comment.index','backend.posts.comment.show']))?'active':''}}">
								<a href="{{route('backend.posts.comment.index')}}" class="menu-link">
									<span class="menu-text">Comments</span>
								</a>
							</div>

							<div class="menu-item {{(in_array(Route::currentRouteName(),['backend.posts.view.index']))?'active':''}}">
								<a href="{{route('backend.posts.view.index')}}" class="menu-link">
									<span class="menu-text">views</span>
								</a>
							</div>

							<div class="menu-item {{(in_array(Route::currentRouteName(),['backend.posts.newsletter-email.index']))?'active':''}}">
								<a href="{{route('backend.posts.newsletter-email.index')}}" class="menu-link">
									<span class="menu-text">NewsLetter Emails</span>
								</a>
							</div>

						</div>
					</div>

					<div class="menu-item has-sub {{(in_array(Route::currentRouteName(), ['backend.blockchain-searches.index', 'backend.blockchain-search-histories.index']))?'active':''}}">
						<a href="#" class="menu-link">
							<span class="menu-icon">
								<i class="fa-regular fa-magnifying-glass"></i>
							</span>
							<span class="menu-text">Blockchain Searches</span>
							<span class="menu-caret"><b class="caret"></b></span>
						</a>
						<div class="menu-submenu">
							<div class="menu-item {{(Route::currentRouteName() == 'backend.blockchain-search-histories.index')?'active':''}}">
								<a href="{{route('backend.blockchain-search-histories.index')}}" class="menu-link">
									<span class="menu-text">History</span>
								</a>
							</div>
							<div class="menu-item {{(Route::currentRouteName() == 'backend.blockchain-searches.index')?'active':''}}">
								<a href="{{route('backend.blockchain-searches.index')}}" class="menu-link">
									<span class="menu-text">Results</span>
								</a>
							</div>
						</div>
					</div>

					<div class="menu-item has-sub {{(in_array(Route::currentRouteName(), ['backend.plans.index', 'backend.plans.create', 'backend.plans.edit', 'backend.crypto-plans.index', 'backend.crypto-plans.create', 'backend.crypto-crypto-plans.edit']))?'active':''}}">
						<a href="#" class="menu-link">
							<span class="menu-icon">
								<i class="fa-regular fa-clipboard-list-check"></i>
							</span>
							<span class="menu-text">Plans</span>
							<span class="menu-caret"><b class="caret"></b></span>
						</a>
						<div class="menu-submenu">
							<div class="menu-item {{(Route::currentRouteName() == 'backend.plans.index')?'active':''}}">
								<a href="{{route('backend.plans.index')}}" class="menu-link">
									<span class="menu-text">Credits Plan</span>
								</a>
							</div>
							<div class="menu-item {{(Route::currentRouteName() == 'backend.crypto-plans.index')?'active':''}}">
								<a href="{{route('backend.crypto-plans.index')}}" class="menu-link">
									<span class="menu-text">Crypto Plan</span>
								</a>
							</div>
						</div>
					</div>

					<div class="menu-item has-sub {{(in_array(Route::currentRouteName(), ['backend.subscription.index', 'backend.subscription.create', 'backend.subscription.edit','backend.subscription.upgrade','backend.subscription.downgrade','backend.subscription.renew','backend.transaction.index','backend.transaction.show']))?'active':''}}">
						<a href="#" class="menu-link">
							<span class="menu-icon">
								<i class="fa-regular fa-user-check"></i>
							</span>
							<span class="menu-text">User Subscription</span>
							<span class="menu-caret"><b class="caret"></b></span>
						</a>
						<div class="menu-submenu">
							<div class="menu-item {{(Route::currentRouteName() == 'backend.plans.index')?'active':''}}">
								<a href="{{route('backend.subscription.index')}}" class="menu-link">
									<span class="menu-text">List</span>
								</a>
							</div>
							<div class="menu-item {{(Route::currentRouteName() == 'backend.crypto-plans.index')?'active':''}}">
								<a href="{{route('backend.transaction.index')}}" class="menu-link">
									<span class="menu-text">Transactions</span>
								</a>
							</div>
						</div>
					</div>

					<div class="menu-item {{(in_array(Route::currentRouteName(), ['backend.user-credits.index', 'backend.user-credits.create', 'backend.user-credits.edit']))?'active':''}}">
						<a href="{{route('backend.user-credits.index')}}" class="menu-link">
							<span class="menu-icon"><i class="fa-regular fa-coin-vertical"></i></span>
							<span class="menu-text">User Credits</span>
						</a>
					</div>

					<div class="menu-item {{(in_array(Route::currentRouteName(), ['backend.contact.index', 'backend.contact.create', 'backend.contact.edit']))?'active':''}}">
						<a href="{{route('backend.contact.index')}}" class="menu-link">
							<span class="menu-icon"><i class="fa-thin fa-solid fa-file"></i></span>
							<span class="menu-text">Inquiries</span>
						</a>
					</div>

					<div class="menu-item {{(in_array(Route::currentRouteName(), ['backend.crypto-monitoring.index', 'backend.crypto-monitoring.create', 'backend.crypto-monitoring.edit']))?'active':''}}">
						<a href="{{route('backend.crypto-monitoring.index')}}" class="menu-link">
							<span class="menu-icon"><i class="fa-thin fa-solid fa-envelope"></i></span>
							<span class="menu-text">Monitoring</span>
						</a>
					</div>

					<div class="menu-item {{(in_array(Route::currentRouteName(), ['backend.investigation.index', 'backend.investigation.create', 'backend.investigation.index']))?'active':''}}">
						<a href="{{route('backend.investigation.index')}}" class="menu-link">
							<span class="menu-icon"><i class="fa-thin fa-message-text"></i></span>
							<span class="menu-text">Investigation</span>
						</a>
					</div>
					
                    <div class="menu-item has-sub {{(in_array(Route::currentRouteName(), ['backend.telegram.users.index','backend.telegram.package.index','backend.telegram.subscription','backend.telegram.transaction','backend.partners.create','backend.partners.edit','backend.telegram.package.create','backend.telegram.package.edit','backend.telegram.transaction.details']))?'active':''}}">
						<a href="#" class="menu-link">
							<span class="menu-icon">
								<i class="fab fa-lg fa-fw me-2 fa-telegram-plane"></i>
							</span>
							<span class="menu-text">Telegram</span>
							<span class="menu-caret"><b class="caret"></b></span>
						</a>
						<div class="menu-submenu">
							<div class="menu-item {{(Route::currentRouteName() == 'backend.telegram.users.index')?'active':''}}">
								<a href="{{route('backend.telegram.users.index')}}" class="menu-link">
									<span class="menu-text">Users</span>
								</a>
							</div>

							<div class="menu-item {{(in_array(Route::currentRouteName(), ['backend.telegram.package.index','backend.telegram.package.create','backend.telegram.package.edit']))?'active':''}}">
								<a href="{{route('backend.telegram.package.index')}}" class="menu-link">
									<span class="menu-text">Package</span>
								</a>
							</div>
							
							<div class="menu-item {{(in_array(Route::currentRouteName(), ['backend.telegram.subscription']))?'active':''}}">
								<a href="{{route('backend.telegram.subscription')}}" class="menu-link">
									<span class="menu-text">Subscription</span>
								</a>
							</div>

							<div class="menu-item {{(in_array(Route::currentRouteName(), ['backend.telegram.transaction','backend.telegram.transaction.details']))?'active':''}}">
								<a href="{{route('backend.telegram.transaction')}}" class="menu-link">
									<span class="menu-text">Transaction</span>
								</a>
							</div>

						</div>
					</div>


					<div class="menu-item has-sub {{(in_array(Route::currentRouteName(), ['backend.settings.view','backend.cms.index','backend.cms.edit','backend.partners.index','backend.partners.create','backend.partners.edit']))?'active':''}}">
						<a href="#" class="menu-link">
							<span class="menu-icon">
								<i class="fa-thin fa-solid fa-gear"></i>
							</span>
							<span class="menu-text">Settings</span>
							<span class="menu-caret"><b class="caret"></b></span>
						</a>
						<div class="menu-submenu">
							<div class="menu-item {{(Route::currentRouteName() == 'backend.settings.view')?'active':''}}">
								<a href="{{route('backend.settings.view', ['page' => 'general'])}}" class="menu-link">
									<span class="menu-text">General</span>
								</a>
							</div>

							<div class="menu-item {{(in_array(Route::currentRouteName(), ['backend.cms.index','backend.cms.edit']))?'active':''}}">
								<a href="{{route('backend.cms.index')}}" class="menu-link">
									<span class="menu-text">CMS Setting</span>
								</a>
							</div>
							
							<div class="menu-item {{(in_array(Route::currentRouteName(), ['backend.partners.index','backend.partners.create','backend.partners.edit']))?'active':''}}">
								<a href="{{route('backend.partners.index')}}" class="menu-link">
									<span class="menu-text">Partners</span>
								</a>
							</div>

						</div>
					</div>

					<div class="menu-item {{(in_array(Route::currentRouteName(), ['backend.flag.index', 'backend.flag.show']))?'active':''}}">
						<a href="{{route('backend.flag.index')}}" class="menu-link">
							<span class="menu-icon"><i class="fa-thin fa-solid fa-pen-nib"></i></span>
							<span class="menu-text">Reported Addresses</span>
						</a>
					</div>

					<div class="menu-item {{(in_array(Route::currentRouteName(), ['backend.labels.index','backend.labels.edit', 'backend.labels.show']))?'active':''}}">
						<a href="{{route('backend.labels.index')}}" class="menu-link">
							<span class="menu-icon"><i class="fa-thin fa-brands fa-slack"></i></span>
							<span class="menu-text">Address Labels</span>
						</a>
					</div>

					<div class="menu-item {{(in_array(Route::currentRouteName(), ['backend.ads.index','backend.ads.edit']))?'active':''}}">
						<a href="{{route('backend.ads.index')}}" class="menu-link">
							<span class="menu-icon"><i class="fa-thin fa-solid fa-paper-plane"></i></span>
							<span class="menu-text">Ads</span>
						</a>
					</div>

					<div class="menu-item {{(in_array(Route::currentRouteName(), ['backend.faq.index','backend.faq.create','backend.faq.edit','backend.faq.show']))?'active':''}}">
						<a href="{{route('backend.faq.index')}}" class="menu-link">
							<span class="menu-icon"><i class="fa-thin fa-solid fa-layer-group"></i></span>
							<span class="menu-text">Faq</span>
						</a>
					</div>

					<div class="menu-item {{(in_array(Route::currentRouteName(), ['backend.seo.index','backend.seo.edit']))?'active':''}}">
						<a href="{{route('backend.seo.index')}}" class="menu-link">
							<span class="menu-icon"><i class="fa-thin fa-solid fa-desktop"></i></span>
							<span class="menu-text">SEO</span>
						</a>
					</div>

					<div class="menu-item has-sub {{(in_array(Route::currentRouteName(), ['backend.auth-log.admin.index', 'backend.auth-log.user.index']))?'active':''}}">
						<a href="#" class="menu-link">
							<span class="menu-icon">
								<i class="fa-thin fa-brands fa-readme"></i>
							</span>
							<span class="menu-text">Auth log</span>
							<span class="menu-caret"><b class="caret"></b></span>
						</a>
						<div class="menu-submenu">
							<div class="menu-item {{(Route::currentRouteName() == 'backend.auth-log.admin.index')?'active':''}}">
								<a href="{{route('backend.auth-log.admin.index')}}" class="menu-link">
									<span class="menu-text">Admin log</span>
								</a>
							</div>
							<div class="menu-item {{(Route::currentRouteName() == 'backend.auth-log.user.index')?'active':''}}">
								<a href="{{route('backend.auth-log.user.index')}}" class="menu-link">
									<span class="menu-text">User log</span>
								</a>
							</div>
						</div>
					</div>

					<div class="menu-item {{(in_array(Route::currentRouteName(), ['backend.api-services.index', 'backend.api-services.create', 'backend.api-services.edit']))?'active':''}}">
						<a href="{{route('backend.api-services.index')}}" class="menu-link">
							<span class="menu-icon"><i class="fa-thin fa-solid fa-cloud"></i></span>
							<span class="menu-text">API Services</span>
						</a>
					</div>

				</div>
			</div>
			<!-- END scrollbar -->
		</div>
		<!-- END #sidebar -->

		<!-- BEGIN mobile-sidebar-backdrop -->
		<button class="app-sidebar-mobile-backdrop" data-toggle-target=".app" data-toggle-class="app-sidebar-mobile-toggled"></button>
		<!-- END mobile-sidebar-backdrop -->
		
		<!-- BEGIN #content -->
		<div id="content" class="app-content">
			@yield('content')
		</div>
		<!-- END #content -->
		
		<!-- BEGIN btn-scroll-top -->
		<a href="#" data-toggle="scroll-to-top" class="btn-scroll-top fade"><i class="fa fa-arrow-up"></i></a>
		<!-- END btn-scroll-top -->
	</div>
	<!-- END #app -->

	<script type="text/javascript">
		var backend_url = @json(url('/'.admin_url()));
	</script>

	<!-- ================== BEGIN core-js ================== -->
	<script src="{{asset('assets/backend/js/vendor.min.js')}}"></script>
	<script src="{{asset('assets/backend/js/app.min.js')}}"></script>
	<!-- ================== END core-js ================== -->

	<!--begin::Page Vendors Scripts -->
	<script src="{{asset('assets/backend/plugins/fullcalendar/fullcalendar.bundle.js')}}" type="text/javascript"></script>
	<!--end::Page Vendors Scripts -->

	<!-- Datatable -->
	<script src="{{asset('assets/backend/plugins/datatables/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('assets/backend/plugins/datatables/js/dataTables.bootstrap5.min.js')}}"></script>

	<!-- Sweet Alert 2 -->
	<script src="{{asset('assets/backend/plugins/sweet-alert/js/sweetalert2.min.js')}}"></script>

	<!-- Select 2  -->
	<script src="{{asset('assets/backend/plugins/select2/js/select2.min.js')}}"></script>

	<!-- toastr -->
	<script src="{{asset('assets/backend/plugins/toastr/js/toastr.min.js') }}"></script>

	<!-- Custom common js -->
	<script src="{{asset('assets/backend/js/common.js')}}" type="text/javascript"></script>

	<!-- blockUI -->
	<script src="{{asset('assets/backend/plugins/blockUI/js/jquery.blockUI.js') }}"></script>

	<!-- TagInput -->
	<script src="{{asset('assets/backend/js/bootstrap-tagsinput.min.js') }}"></script>

	<!-- Repeter Js -->
	<script src="{{asset('assets/backend/js/repeater.min.js') }}"></script>

	<!-- Laravel Javascript Validation -->
	<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
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
	
</body>

</html>	