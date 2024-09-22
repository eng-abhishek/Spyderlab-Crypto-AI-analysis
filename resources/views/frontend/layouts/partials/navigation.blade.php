<!-- Sticky Navbar -->
<nav class="navbar navbar-expand-lg sticky-top">
	<div class="container">

		<a class="navbar-brand" href="{{route('home')}}"><img src="{{asset('assets/frontend/images/icons/logo.png')}}" alt="Websecurely Logo"></a>

		<button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
			<span class=""><i class="fa fa-bars fa-2x"></i></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav ms-auto">
				<li class="nav-item">
					<a class="nav-link" href="{{route('home')}}">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{route('blockchain-analysis')}}">Crypto Tracking</a>
				</li>

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						OSINT Tools
					</a>
					<ul class="dropdown-menu" aria-labelledby="navbarDropdown1">
						<li><a class="dropdown-item" href="{{route('search.index')}}">Darknet Intelligence</a></li>
						<li><a class="dropdown-item" href="{{route('search.index')}}">Phone Number Lookup</a></li>
						<li><a class="dropdown-item" href="{{route('search.index')}}">Email OSINT</a></li>
						<li><a class="dropdown-item" href="{{route('search.index')}}">Social OSINT</a></li>
					</ul>
				</li>

				<li class="nav-item">
					<a class="nav-link" href="{{route('threat-map')}}">Threat Map</a>
				</li>

				<li class="nav-item">
					<a class="nav-link" href="{{route('pricing')}}">Pricing</a>
				</li>

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						About
					</a>
					<ul class="dropdown-menu" aria-labelledby="navbarDropdown2">
						<li><a class="dropdown-item" href="{{route('about-us')}}">About Us</a></li>
						<li><a class="dropdown-item" href="{{route('contact-us')}}">Contact Us</a></li>
					</ul>
				</li>

				<li class="nav-item">
					<a class="nav-link" href="{{route('blog.index')}}">Blog</a>
				</li>

				@auth('web')

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" aria-expanded="false">
						<i class="fa fa-user px-2"></i>My Account
					</a>
					<ul class="dropdown-menu custom-position" aria-labelledby="accountDropdown">
						
						<li><a class="dropdown-item" href="{{route('workspace')}}"><i class="fa fa-user px-1"></i>Workspace</a></li>

						<li><a class="dropdown-item" href="{{route('account.index')}}"><i class="fa fa-gear fa-spin px-1"></i>Settings</a></li>

						<li><a class="dropdown-item" href="{{route('history.index')}}"><i class="fa-solid fa-clock-rotate-left px-1"></i>Search History</a></li>

						<li><a class="dropdown-item" href="{{route('blockchain-search-history.index')}}"><i class="fa-solid fa-clock-rotate-left px-1"></i>Blockchain Seach History</a></li>

						<li><a class="dropdown-item" href="#"><i class="fa-solid fa-award px-1"></i>Loyalty</a></li>

						<li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa-solid fa-arrow-right-from-bracket px-1"></i>Log Out</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
								@csrf
							</form>
						</li>
					</ul>
				</li>
				@else
				<li class="nav-item">
					<a class="nav-link" href="{{route('login')}}">Login</a>
				</li>
				@endauth
			</ul>
		</div>
	</div>
</nav>

<!-- Offcanvas for Mobile Menu -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
	<div class="offcanvas-header">
		<h5 class="offcanvas-title" id="offcanvasNavbarLabel"><span>Menu</span></h5>
		<span data-bs-dismiss="offcanvas"><i class="fa-solid fa-close fa-2x"></i></span>
	</div>
	<div class="offcanvas-body-all d-flex flex-column justify-content-between">
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" href="{{route('home')}}">Home</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{route('blockchain-analysis')}}">Crypto Tracking</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{route('blog.index')}}">Blog</a>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="osintDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
					OSINT Tools
				</a>
				<ul class="dropdown-menu" aria-labelledby="osintDropdown">
					<li><a class="dropdown-item" href="{{route('search.index')}}">Darknet Intelligence</a></li>
					<li><a class="dropdown-item" href="{{route('search.index')}}">Phone Number Lookup</a></li>
					<li><a class="dropdown-item" href="{{route('search.index')}}">Email OSINT</a></li>
					<li><a class="dropdown-item" href="{{route('search.index')}}">Social OSINT</a></li>
				</ul>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Threat Map</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{route('pricing')}}">Pricing</a>
			</li>
		</ul>
		<ul class="navbar-nav">
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="aboutDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
					About
				</a>
				<ul class="dropdown-menu" aria-labelledby="aboutDropdown">
					<li><a class="dropdown-item" href="{{route('about-us')}}">About Us</a></li>
					<li><a class="dropdown-item" href="{{route('contact-us')}}">Contact Us</a></li>
				</ul>
			</li>

			@auth('web')
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
					<i class="fa fa-user px-2"></i>My Account
				</a>
				<ul class="dropdown-menu" aria-labelledby="accountDropdown">

					<li><a class="dropdown-item" href="{{route('workspace')}}"><i class="fa fa-user px-1"></i>Workspace</a></li>

					<li><a class="dropdown-item" href="{{route('account.index')}}"><i class="fa fa-gear fa-spin px-1"></i>Settings</a></li>

					<li><a class="dropdown-item" href="{{route('history.index')}}"><i class="fa-solid fa-clock-rotate-left px-1"></i>Search History</a></li>

					<li><a class="dropdown-item" href="{{route('blockchain-search-history.index')}}"><i class="fa-solid fa-clock-rotate-left px-1"></i>Blockchain Seach History</a></li>

					<li><a class="dropdown-item" href="#"><i class="fa-solid fa-award px-1"></i>Loyalty</a></li>

					<li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa-solid fa-arrow-right-from-bracket px-1"></i>Log Out</a>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
							@csrf
						</form>
					</li>
				</ul>
			</li>
			@else

			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
					Login/Sign Up
				</a>
				<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
					<li><a class="dropdown-item" href="{{route('login')}}">Login</a></li>
					<li><a class="dropdown-item" href="{{route('register')}}">Sign Up</a></li>
				</ul>
			</li>
			@endauth
		</ul>
	</div>
</div>