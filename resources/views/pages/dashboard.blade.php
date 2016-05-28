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
							<img src="../images/icons/dashboardPlaylistAdd.png" title="Create Playlist" alt="Create Playlist">
								<span>Create Playlist</span>
						</a>
					</li>
					<li name="liPlaylist">
						<a href="{{ URL::to('dashboard/playlist')}}">
							<img src="../images/icons/dashboardPlaylist.png" title="List Playlists" alt="List Playlists">
								<span>Playlists</span>
						</a>
					</li>
					<li name="liModal">
						<a href="#AdvertModal">
							<img src="../images/icons/dashboardAdvertAdd.png" title="Create Advert" alt="Create Advert">
								<span>Create Advert</span>
						</a>
					</li>
					<li name="liAdvert">
						<a href="{{ URL::to('dashboard/advert')}}">
							<img src="../images/icons/dashboardAdvert.png" title="List Adverts" alt="List Adverts">
								<span>Adverts</span>
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
							<img src="../images/icons/dashboardUsers.png" title="List Users" alt="Users">
								<span>Users</span>
						</a>
					</li>
					<li name="liPrivileges">
						<a href="{{ URL::to('dashboard/settings/privileges')}}">
							<img src="../images/icons/dashboardPrivileges.png" title="User Privileges" alt="User Privileges">
								<span>Privileges</span>
						</a>
					</li>
					<li name="liDepartments">
						<a href="{{ URL::to('dashboard/settings/departments/')}}">
							<img src="../images/icons/dashboardDepartments.png" title="Departments" alt="Departments">
								<span>Departments</span>
						</a>
					</li>
					<li name="liLocations">
						<a href="{{ URL::to('dashboard/settings/locations/')}}">
							<img src="../images/icons/dashboardLocations.png" title="Locations" alt="Locations">
								<span>Locations</span>
						</a>
					</li>

					<li name="liScreens">
						<a href="{{ URL::to('dashboard/settings/screens')}}">
							<img src="../images/icons/dashboardScreens.png" title="Screens" alt="Screens">
								<span>Screens</span>
						</a>
					</li>
					<li name="liBackgrounds">
						<a href="{{ URL::to('dashboard/settings/backgrounds')}}">
							<img src="../images/icons/dashboardPageBackgrounds.png" title="Page Backgrounds" alt="Page Backgrounds">
								<span>Page Backgrounds</span>
						</a>
					</li>
					<li name="liTemplates">
						<a href="{{ URL::to('dashboard/settings/templates')}}">
							<img src="../images/icons/dashboardPageTemplates.png" title="Page Templates" alt="Page Templates">
								<span>Page Templates</span>
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
