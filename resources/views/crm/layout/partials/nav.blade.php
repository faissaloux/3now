<div class="site-sidebar">
	<div class="custom-scroll custom-scroll-light">
		<ul class="sidebar-menu">
			<li class="active">
				<a href="{{ route('cms.dashboard') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="ti-control-record"></i></span>
					<span class="s-text">Dashboard</span>
				</a>
			</li> 
			
			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
					<span class="s-caret"><i class="fa fa-angle-down"></i></span>
					<span class="s-icon"><i class="ti-user"></i></span>
					<span class="s-text">Benutzer</span>
				</a>
				<ul>
					<li><a href="{{ route('crm.user.index') }}">alle Benutzer</a></li>
					<li><a href="{{ route('crm.user.create') }}">Benutzer hinzufügen</a></li>
				</ul>
			</li>
			    
            <li class="with-sub">
				<a href="{{ route('crm.contact') }}" class="waves-effect  waves-light">
					<span class="s-icon"><i class="ti-user"></i></span>
					<span class="s-text">kontaktiere uns</span>
				</a>
			</li>
            <li>
				<a href="{{ route('crm.complaint') }}" class="waves-effect  waves-light">
					<span class="s-icon"><i class="ti-receipt"></i></span>
					<span class="s-text">Beschwerde</span>
				</a>  
			</li>
			<li>
				<a href="{{ route('crm.lost-management') }}" class="waves-effect  waves-light">
					<span class="s-icon"><i class="ti-receipt"></i></span>
					<span class="s-text">Verlorenes Management</span>
				</a>  
			</li>
			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
					<span class="s-caret"><i class="fa fa-angle-down"></i></span>
					<span class="s-icon"><i class="ti-basketball"></i></span>
					<span class="s-text">Treiber</span>
				</a>
				<ul>
					<li><a href="{{ route('crm.provider.index') }}">alle Fahrer</a></li>
					<li><a href="{{ route('crm.provider.create') }}">Treiber hinzufügen</a></li>
				</ul>
			</li>
			
			<li class="with-sub">
				<a href="#" class="waves-effect  waves-light">
					<span class="s-caret"><i class="fa fa-angle-down"></i></span>
					<span class="s-icon"><i class="ti-pie-chart"></i></span>
					<span class="s-text">Fahrten</span>
				</a>
				<ul>
					<li><a href="{{ url('crm/onGoingTrip') }}">laufende Fahrten</a></li>
					<li><a href="{{ url('crm/scheduledTrip') }}">geplante Fahrt</a></li>
					<li><a href="{{ url('crm/cancelTrip') }}">Fahrt abgesagt</a></li>
					<li><a href="{{ url('crm/completedTrip') }}">Fahrt abgeschlossen</a></li>
				</ul>
			</li>
			 
			
			<li>
				<a href="{{ route('crm.profile') }}" class="waves-effect  waves-light">
					<span class="s-icon"><i class="ti-write"></i></span>
					<span class="s-text">Profile</span>
				</a>  
			</li>

			<li>
				<a href="/crm/map" class="waves-effect  waves-light">
					<span class="s-icon"><i class="ti-map-alt"></i></span>
					<span class="s-text">Live-Standort</span>
				</a>  
			</li>
			
			<li class="compact-hide" style="margin-bottom: -16px;">
				<a href="{{ url('/crm/logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
					<span class="s-icon"><i class="ti-power-off"></i></span>
					<span class="s-text">Ausloggen</span>
                </a>

                <form id="logout-form" action="{{ url('/crm/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
			</li>
			
		</ul>
	</div>
</div>