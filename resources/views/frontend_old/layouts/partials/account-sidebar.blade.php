              {{--<div class="sticky-top top-16 mb-3">
              	<ul class="list-unstyled tracking-sidebar tracking-sidebar-height mb-0">
              		<li class="{{(Route::currentRouteName() == 'workspace')?'active':''}}"><a href="{{route('workspace')}}"><i class="fa-light fa-desktop tracking-sidebar-icon"></i> Workspace</a></li> 

              		<li class="{{(Route::currentRouteName() == 'crypto-analysis')?'active':''}}"><a href="{{route('crypto-analysis')}}"><i class="fa-light fa-desktop tracking-sidebar-icon"></i> Crypto Analysis</a></li> 


              		<li class="{{(Route::currentRouteName() == 'favorites')?'active':''}}"><a href="{{route('favorites')}}"><i class="fa-light fa-star tracking-sidebar-icon"></i> Favorites</a></li>

              		<li class="{{(Route::currentRouteName() == 'investigation.index')?'active':''}}"><a href="{{route('investigation.index')}}"><i class="fa-light fa-radar tracking-sidebar-icon"></i>Investigation</a></li>

              		<li class="{{(Route::currentRouteName() == 'monitoring.index')?'active':''}}"><a href="{{route('monitoring.index')}}"><i class="fa-light fa-crosshairs tracking-sidebar-icon"></i> Monitoring</a></li>

              		<li class="{{(Route::currentRouteName() == 'alerts')?'active':''}}"><a href="{{route('alerts')}}"><i class="fa-light fa-sensor-triangle-exclamation tracking-sidebar-icon"></i> Alerts</a></li>

                  <li class="{{(Route::currentRouteName() == 'search.index')?'active':''}}"><a href="{{route('search.index')}}"><i class="fa-light fa-radar tracking-sidebar-icon"></i>AOSINT</a></li>

              		<li class=""><a href="#"><i class="fa-light fa-crosshairs tracking-sidebar-icon"></i>Darknet intelligence</a></li>

              		<li class=""><a href="#"><i class="fa-light fa-sensor-triangle-exclamation tracking-sidebar-icon"></i> API</a></li>
              	</ul>                          
              	<p class="sidebar-footer-text text-center mb-0"></p>
              </div> --}}

              <div class="sticky-top top-16 mb-3 sidebar">
              	<div class="container-fluid side-nav">

              		<div class="row">
              			<div class="col-12 text-start">
              				<h6 class="main-menu">
              					<a href="{{route('workspace')}}" class="text-black"><img src="{{asset('assets/frontend/images/icons/workspace-ico.png')}}" class="img-fluid sidebar-ico"></img>
              					Workspace</a>
              				</h6>
              			</div>
              		</div>

              		<div class="row">
              			<div class="col-12 text-start">
              				<h6 class="main-menu">
              					<a class="text-black" href="{{route('crypto-analysis')}}"><img src="{{asset('assets/frontend/images/icons/analysis-ico.png')}}" class="img-fluid sidebar-ico"></img>
              					crypto Analysis</a>
              				</h6>
              			</div>
              		</div>

              		<div class="row sub-menus-row">
              			<div class="col-12">
              				<h6 class="sub-menus">
              					<a class="text-black" href="{{route('favorites')}}"><img src="{{asset('assets/frontend/images/icons/favourite-ico.png')}}" class="img-fluid sidebar-sub-ico"></img>
                                             Favourite</h6></a>
                                             <h6 class="sub-menus">
                                                   <a class="text-black" href="{{route('investigation.index')}}"><img src="{{asset('assets/frontend/images/icons/investigation-ico.png')}}" class="img-fluid sidebar-sub-ico"></img>
                                                   Investigation</a> </h6>
                                                   <h6 class="sub-menus">
                                                          <a class="text-black" href="{{route('monitoring.index')}}"><img src="{{asset('assets/frontend/images/icons/monitoring-ico.png')}}" class="img-fluid sidebar-sub-ico"></img>
                                                          Monitoring</a> </h6>
                                                          <h6 class="sub-menus">
                                                                 <a class="text-black" href="{{route('alerts')}}"><img src="{{asset('assets/frontend/images/icons/alert-ico.png')}}" class="img-fluid sidebar-sub-ico"></img>
                                                                 Alert</a> </h6>
                                                          </div>
                                                   </div>

                                                   <div class="row">
                                                     <div class="col-12 text-start">
                                                           <h6 class="main-menu">
                                                                  <a href="{{route('search.index')}}" class="text-black"><img src="{{asset('assets/frontend/images/icons/intelli-ico.png')}}" class="img-fluid sidebar-ico"></img>
                                                                  OSINT</a></h6>
                                                           </div>
                                                    </div>

                                                    <div class="row">
                                                     <div class="col-12 text-start">
                                                           <h6 class="main-menu">
                                                                  <a href="#" class="text-black"><img src="{{asset('assets/frontend/images/icons/darknet-ico.png')}}" class="img-fluid sidebar-ico"></img>
                                                                  Darknet intelligence</a></h6>
                                                           </div>
                                                    </div>

                                                    <div class="row">
                                                     <div class="col-12 text-start">
                                                           <h6 class="main-menu">
                                                                 <a href="#" class="text-black"><img src="{{asset('assets/frontend/images/icons/api-ico.png')}}" class="img-fluid sidebar-ico"></img>
                                                                 API</a></h6>
                                                          </div>
                                                   </div>
                                            </div>
                                     </div>
