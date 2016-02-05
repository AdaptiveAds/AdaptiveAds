@extends('default')

@section('content')

@include('objects/model_create', array('object' => 'Playlist',
																			 'allowed_departments' => $allowed_departments,
																			 'route' => 'dashboard.playlist.store'))

<div class="global">
	<div class="row">
			<h3>Playlists</h3>
			<ul>
				<li>
					<a href="#PlaylistModal"><button type="submit" name="btnAddPlaylist">New</button></a>
				</li>
			</ul>
	</div>

	<div class="row">
		@include('objects/playlistItem')
	</div>
</div>
@endsection
