@extends('default')

@section('content')

@include('objects/modal_create', array('object' => 'Advert',
																			 'allowed_departments' => $allowed_departments,
																			 'route' => 'dashboard.advert.process'))
@include('objects/modal_create', array('object' => 'Playlist',
																			 'allowed_departments' => $allowed_departments,
																			 'route' => 'dashboard.playlist.process'))

<div class="dashboard">
	<div class="row">
		<div class="options">
			<h4>Options</h4>

				<ul>
					<li>
						<a name="lnkPlaylists" href="{{ URL::to('dashboard/playlist')}}">
							<i class="fa fa-list-ul">
							<!-- temp name ofc -->
								<span>Playlists</span>
							</i>
						</a>
					</li>
					<li>
						<a name="lnkCreatePlaylist" href="#PlaylistModal">
							<i class="fa fa-list-ul">
							<!-- temp name ofc -->
								<span>Create Playlist</span>
							</i>
						</a>
					</li>

					<li>
						<a name="lnkAdverts" href="{{ URL::to('dashboard/advert')}}">
							<i class="fa fa-list-ul">
							<!-- temp name ofc -->
								<span>Adverts</span>
							</i>
						</a>
					</li>
					<li>
						<a name="lnkCreateAdvert" href="#AdvertModal">
							<i class="fa fa-list-ul">
							<!-- temp name ofc -->
								<span>Create Advert</span>
							</i>
						</a>
					</li>
				</ul>
				<div class="clear"></div>

		</div>
		<!-- Only show if user is admin -->
		@if (isset($user))
			@if ($user->getAdmin())
		<div class="options">
			<h4>Admin Settings</h4>

				<ul>

							<li>
								<a name="lnkLocations" href="{{ URL::to('dashboard/settings/locations/')}}">
									<i class="fa fa-map-marker">
										<span>Locations</span>
									</i>
								</a>
							</li>
							<li>
								<a name="lnkDepartments" href="{{ URL::to('dashboard/settings/departments/')}}">
									<i class="fa fa-university">
										<span>Departments</span>
									</i>
								</a>
							</li>
							<li>
								<a name="lnkScreens" href="{{ URL::to('dashboard/settings/screens')}}">
									<i class="fa fa-desktop">
										<span>Screens</span>
									</i>
								</a>
							</li>
							<li>
								<a name="lnkUsers" href="{{ URL::to('dashboard/settings/users')}}">
									<i class="fa fa-users">
										<span>Users</span>
									</i>
								</a>
							</li>
							<li>
								<a name="lnkTemplates" href="{{ URL::to('dashboard/settings/templates')}}">
									<i class="fa fa-navicon">
										<span>Templates</span>
									</i>
								</a>
							</li>
						</ul>
						<div class="clear"></div>

		</div>
			@endif
		@endif

		<!-- Only show if user is super user -->
		@if (isset($user))
			@if ($user->is_super_user)
				<div class="options">
					<h4>Super User Settings</h4>

						<ul>
							<li>
								<a href="{{ URL::to('dashboard/settings/locations/')}}">
									<i class="fa fa-map-marker">
										<span>Locations</span>
									</i>
								</a>
							</li>
							<li>
								<a href="{{ URL::to('dashboard/settings/screens')}}">
									<i class="fa fa-desktop">
										<span>Screens</span>
									</i>
								</a>
							</li>

							<li>
								<a href="{{ URL::to('dashboard/settings/users')}}">
									<i class="fa fa-users">
										<span>Admins</span>
									</i>
								</a>
							</li>
						</ul>
						<div class="clear"></div>
				</div>
			@endif
		@endif
	</div><!-- row-->
</div>
@endsection
