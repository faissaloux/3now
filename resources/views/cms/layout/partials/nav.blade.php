<div class="site-sidebar">
	<div class="custom-scroll custom-scroll-light">
		<ul class="sidebar-menu">
			<li class="active">
				<a href="#" class="waves-effect waves-light">
					<span class="s-icon"><i class="ti-control-record"></i></span>
					<span class="s-text">Dashboard</span>
				</a>
			</li>

			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
					<span class="s-caret"><i class="fa fa-angle-down"></i></span>
					<span class="s-icon"><i class="ti-layout"></i></span>
					<span class="s-text">Pages</span>
				</a>
				<ul>
					<li><a href="{{ url('cms/page/') }}">All Pages</a></li>
					<li><a href="{{ url('cms/page/create') }}">Add Pages</a></li>
                    
                    
				</ul>
			</li>
			
			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
					<span class="s-caret"><i class="fa fa-angle-down"></i></span>
					<span class="s-icon"><i class="ti-thought"></i></span>
					<span class="s-text">Blogs</span>
				</a>
				<ul>
					<li><a href="{{ url('cms/blog/') }}">All Blogs</a></li>
					<li><a href="{{ url('cms/blog/create') }}">Add Blog</a></li>
                    
                    
				</ul>
			</li>
			
			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
					<span class="s-caret"><i class="fa fa-angle-down"></i></span>
					<span class="s-icon"><i class="ti-email"></i></span>
					<span class="s-text">Email</span>
				</a>
				<ul>
					<li><a href="#">All Email</a></li>
					<li><a href="#">Manage Email</a></li>
                    
                    
				</ul>
			</li>
			
			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
					<span class="s-caret"><i class="fa fa-angle-down"></i></span>
					<span class="s-icon"><i class="ti-clipboard"></i></span>
					<span class="s-text">Translation</span>
				</a>
				<ul>
					<li><a href="#">All Language</a></li>
					<li><a href="#">Add New</a></li>
                    
                    
				</ul>
			</li>
			
			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
					<span class="s-caret"><i class="fa fa-angle-down"></i></span>
					<span class="s-icon"><i class="ti-comment-alt"></i></span>
					<span class="s-text">FAQ</span>
				</a>
				<ul>
					<li><a href="#">All FAQ</a></li>
					<li><a href="#">Add New</a></li>
                    
                    
				</ul>
			</li>
			
			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
					<span class="s-caret"><i class="fa fa-angle-down"></i></span>
					<span class="s-icon"><i class="ti-agenda"></i></span>
					<span class="s-text">Profile</span>
				</a>
				<ul>
					<li><a href="#">Account Settings</a></li>
					<li><a href="#">Change Password</a></li>
                    
                    
				</ul>
			</li>

			<li class="compact-hide">
				<a href="{{ url('/cms/logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
					<span class="s-icon"><i class="ti-power-off"></i></span>
					<span class="s-text">Logout</span>
                </a>

                <form id="logout-form" action="{{ url('/cms/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
			</li>
			
		</ul>
	</div>
</div>