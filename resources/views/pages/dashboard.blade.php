@extends('backend')

@section('content')

@include('objects/modal_create', array('object' => 'Advert',
																			 'allowed_departments' => $allowed_departments,
																			 'route' => 'dashboard.advert.store'))
@include('objects/modal_create', array('object' => 'Playlist',
																			 'allowed_departments' => $allowed_departments,
																			 'route' => 'dashboard.playlist.store'))

<div class="dashboard">
	<div class="row">
		<div class="options">
			<h4>Options</h4>
				<ul>
					<li name="liPlaylistModal">
						<a href="#PlaylistModal">
							<i class="fa fa-list-ul">
							<!-- temp name ofc -->
								<span>Create Playlist</span>
							</i>
						</a>
					</li>
					<li name="liPlaylist">
						<a href="{{ URL::to('dashboard/playlist')}}">
							<i class="fa fa-list-ul">
							<!-- temp name ofc -->
								<span>Playlists</span>
							</i>
						</a>
					</li>
					<li name="liModal">
						<a href="#AdvertModal">
							<i class="fa fa-list-ul">
							<!-- temp name ofc -->
								<span>Create Advert</span>
							</i>
						</a>
					</li>
					<li name="liAdvert">
						<a href="{{ URL::to('dashboard/advert')}}">
							<i class="fa fa-list-ul">
							<!-- temp name ofc -->
								<span>Adverts</span>
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
					<li name="liUsers">
						<a href="{{ URL::to('dashboard/settings/users')}}">
							<i class="fa fa-users">
								<span>Users</span>
							</i>
						</a>
					</li>
					<li name="liPrivileges">
						<a href="{{ URL::to('dashboard/settings/privileges')}}">
							<i class="fa fa-key">
								<span>Privileges</span>
							</i>
						</a>
					</li>
					<li name="liDepartments">
						<a href="{{ URL::to('dashboard/settings/departments/')}}">
							<i class="fa fa-university">
								<span>Departments</span>
							</i>
						</a>
					</li>
					<li name="liLocations">
						<a href="{{ URL::to('dashboard/settings/locations/')}}">
							<i class="fa fa-map-marker">
								<span>Locations</span>
							</i>
						</a>
					</li>

					<li name="liScreens">
						<a href="{{ URL::to('dashboard/settings/screens')}}">
							<i class="fa fa-desktop">
								<span>Screens</span>
							</i>
						</a>
					</li>
					<li name="liBackgrounds">
						<a href="{{ URL::to('dashboard/settings/backgrounds')}}">
							<i class="fa fa-photo">
								<span>Page Backgrounds</span>
							</i>
						</a>
					</li>
					<li name="liTemplates">
						<a href="{{ URL::to('dashboard/settings/templates')}}">
							<i class="fa fa-navicon">
								<span>Page Templates</span>
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
