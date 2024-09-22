                    <div class="sticky-top top-16 mb-3">
                    	<ul class="list-unstyled tracking-sidebar tracking-sidebar-height mb-0">
                    		<li class="{{(Route::currentRouteName() == 'account.index')?'active':''}}"><a href="{{route('account.index')}}"><i class="fa-light fa-desktop tracking-sidebar-icon"></i>My Account</a></li> 

                    		<li class="{{(Route::currentRouteName() == 'account.profile.view')?'active':''}}"><a href="{{route('account.profile.view')}}"><i class="fa-light fa-star tracking-sidebar-icon"></i>Edit Profile</a></li>

                    		<li class="{{(Route::currentRouteName() == 'account.change-password.view')?'active':''}}"><a href="{{route('account.change-password.view')}}"><i class="fa-light fa-radar tracking-sidebar-icon"></i>Change Password</a></li>

                    		<li class="{{(Route::currentRouteName() == 'account.profile.subscription')?'active':''}}"><a href="{{route('account.profile.subscription')}}"><i class="fa-light fa-crosshairs tracking-sidebar-icon"></i>My Subscription</a></li>

                    		<li class="{{(Route::currentRouteName() == 'account.private-key')?'active':''}}"><a href="{{route('account.private-key')}}"><i class="fa-light fa-sensor-triangle-exclamation tracking-sidebar-icon"></i>Private Key</a></li>
                    	</ul>                          
                    	<p class="sidebar-footer-text text-center mb-0"></p>
                    </div>