<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @yield('title')
  <!-- Bootstrap Css -->
  
  <link rel="stylesheet" href="{{asset('assets/account/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="{{asset('assets/frontend/css/sweetalert2.min.css')}}">
  <!-- main css file -->

  <link rel="stylesheet" href="{{asset('assets/account/fontawesome/css/all.min.css')}}">

  <link rel="stylesheet" href="{{asset('assets/account/css/style.css')}}">

  @yield('styles')
</head>
<body>
  
  <header id="header" class="collapsed">
    <div class="sidenav-btn" id="toggleSidebar">
      <i class="fa fa-bars"></i>
    </div>
    <div class="social-icons">
      <div class="header-icons ml-auto d-flex">  
        <div class="icon"> 
          <i class="fa fa-fw fa-bell"></i> <!-- Notification icon --> 
        </div>

        <div class="icon dropdown">
          <span class="dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
            <button class="button" id="user-btn">
              <i class="fa fa-fw fa-user fx-1"></i>My Account
            </button>
          </span>
          <ul class="dropdown-menu custom-position">
            <li><a class="dropdown-item" href="{{route('account.index')}}"><i class="fa fa-gear fa-spin px-1"></i>Settings</a></li>
            <li><a class="dropdown-item" href="{{route('history.index')}}"><i class="fa-solid fa-clock-rotate-left px-1"></i>Search History</a></li>

            <li><a class="dropdown-item" href="{{route('blockchain-search-history.index')}}"><i class="fa-solid fa-clock-rotate-left px-1"></i>Blockchain Search History</a></li>

            <li><a class="dropdown-item" href="#"><i class="fa-solid fa-award px-1"></i>Loyalty</a></li>
            <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa-solid fa-arrow-right-from-bracket px-1"></i>Log Out</a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </li>

          </ul>
        </div>
      </div>
    </div>
  </header>

  <div id="sidebar" class="collapsed">
    <div class="d-flex">
      <img src="{{asset('assets/account/images/logo.png')}}" alt="Logo" class="logo">
      <div class="mobile-nav-close" id="mobile-nav-close-btn">
        <i class="fa fa-bars" style="color: #d6ebf8;"></i>
      </div>
    </div>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link {{(Route::currentRouteName() == 'workspace')?'active':''}}" href="{{route('workspace')}}"><img src="{{asset('assets/account/images/Sidebar/Workspace.svg')}}" height="25" alt=""> Workspace</a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link dropdown-icon" href="#" id="Cryptomenu" role="button" data-bs-toggle="collapse" data-bs-target="#cryptoSubMenu" aria-expanded="false" aria-controls="cryptoSubMenu">
          <img src="{{asset('assets/account/images/favicon/analysis-ico.png')}}" height="30" alt="">
          Crypto Analysis

          @if(in_array(Route::currentRouteName(), ['crypto-analysis', 'favorites', 'investigation.index','monitoring.index','alerts']))
          <i class="fas fa-chevron-right rotate-icon rotated"></i>
        </a>
        <ul>
          @else
          <i class="fas fa-chevron-right rotate-icon"></i>
        </a>
        <ul class="collapse submenu" id="cryptoSubMenu" aria-labelledby="Cryptomenu">

          @endif
          <li class="d-flex"><a href="{{route('crypto-analysis')}}" class="nav-link {{(Route::currentRouteName() == 'crypto-analysis')?'active':''}}"><img src="{{asset('assets/account/images/favicon/analysis-ico.png')}}" height="25" alt=""> Crypto Analysis</a></li>

          <li class="d-flex"><a href="{{route('favorites')}}" class="nav-link {{(Route::currentRouteName() == 'favorites')?'active':''}}"><img src="{{asset('assets/account/images/Sidebar/favourite.svg')}}" height="25" alt=""> Favourite</a>
          </li>

          <li class="d-flex"><a href="{{route('investigation.index')}}" class="nav-link {{(Route::currentRouteName() == 'investigation.index')?'active':''}}"><img src="{{asset('assets/account/images/favicon/investigation-ico.png')}}" height="25" alt=""> Investigation</a>
          </li>

          <li class="d-flex"><a href="{{route('monitoring.index')}}" class="nav-link {{(Route::currentRouteName() == 'monitoring.index')?'active':''}}"><img src="{{asset('assets/account/images/favicon/monitoring-ico.png')}}" height="30" alt=""> Monitoring</a>
          </li>

          <li class="d-flex">
            <a href="{{route('alerts')}}" class="nav-link {{(Route::currentRouteName() == 'alerts')?'active':''}}"><img src="{{asset('assets/account/images/Sidebar/alert.svg')}} " height="25" alt=""> Alerts</a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{route('search.index')}}"><img src="{{asset('assets/account/images/Sidebar/OSINT.svg')}}" height="25" alt=""> OSINT<i class="fas fa-lock lock"></i></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="#"><img src="{{asset('assets/account/images/Sidebar/Darknet-intel.svg')}}" height="25" alt="">  Darknet intelligence<i class="fas fa-lock lock-dark"></i></a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{(Route::currentRouteName() == 'account.profile.subscription')?'active':''}}" href="{{route('account.profile.subscription')}}"><img src="{{asset('assets/account/images/icons/subscribe-icon.svg')}}" height="25" alt=""> Subscription</a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{(Route::currentRouteName() == 'account.private-key')?'active':''}}" href="{{route('account.private-key')}}"><img src="{{asset('assets/account/images/icons/key.svg')}}" height="25" alt=""> Private key</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="https://docs.spyderlab.org/" target="_blank"><img src="{{asset('assets/account/images/Sidebar/api.svg')}}" height="25" alt=""> APIs</a>
      </li>
      
    </ul>
  </div>

  @yield('content')
  @include('frontend.layouts.partials.alert-message')

  <footer id="footer" class="collapsed">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="copyright">
            <h5>&copy; Copyright {{date('Y')}}<script></script><a href="https://www.patterndrive.com"> Pattern Drive Private Limited. </a>All Rights Reserved</h5>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="{{asset('assets/frontend/js/jquery-3.6.1.min.js')}}"></script>

  <script src="{{asset('assets/account/js/bootstrap.bundle.min.js')}}"></script>
  <!-- FontAwesome for icons (Minified and from CDN) -->

  <script src="{{asset('assets/account/fontawesome/js/all.min.js')}}"></script>

  <script src="{{asset('assets/account/js/main.js')}}"></script>

  <script src="{{asset('assets/frontend/js/jquery.blockUI.js')}}"></script>

  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>

  <script src="{{asset('assets/frontend/js/sweetalert2.min.js')}}"></script>

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

    function copyToClipboard(element,id=null) {
        
        var $temp = $("<input>");
        $("body").append($temp);
        if(id != null){
            $temp.val($(element+id).text()).select();
        }else{
            $temp.val($(element).text()).select();
        }

        document.execCommand("copy");
        $temp.remove();
        if(id != null){
            $(element+id).addClass('text-success');
        }else{
            $(element).addClass('text-success');
        }

        setTimeout(function(){
            if(id != null){
                $(element+id).removeClass('text-success');
            }else{
                $(element).removeClass('text-success');
            }
        },1200)
    }

    // copy_to_clipboard

    </script>

  @yield('scripts')
</body>
</html>
