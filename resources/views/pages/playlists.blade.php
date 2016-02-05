@extends('default')

@section('content')

@include('objects/model_create', array('object' => 'Playlist',
																			 'allowed_departments' => $allowed_departments,
																			 'route' => 'dashboard.playlist.store'))

<div class="global">
	<div class="row">
			<!-- TODO ADD FORM -->
			<h3>Playlists</h3>
			<ul>
				<li>
					<input type="name" name="txtPlaylistName" placeholder="Playlist name...."
								 value="{{ $searchItem or '' }}"/>
					<a href="#PlaylistModal"><button type="submit" name="btnAddPlaylist">New</button></a>
				</li>
			</ul>
	</div>

	<div class="row">
		@include('objects/playlistItem')
	</div>
</div>
@endsection
