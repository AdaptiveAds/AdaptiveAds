@extends('default')

@section('content')

@include('objects/model_create', array('object' => 'Playlist',
																			 'allowed_departments' => $allowed_departments,
																			 'route' => 'dashboard.playlist.store'))

<h3>Playlists</h3>

<div id="left">
	<div class="pagecontainer">
		@include('objects/playlistItem')
	</div>
</div>
<div id="right">

	<!-- PHP Driven self updating ?? -->
		<ul>
			<li><a href="#PlaylistModal"><button type="submit" name="btnNewPlaylist">New</button></a></li>
			<!--<li><button type="button">Edit</button></li>
			<li><button type="button">Preview</button></li>
			<li><button type="button">Details</button></li>-->
			<!-- ensures form fills parent div w3c validation compliant -->
			<div class="clear"></div>
		</ul>
	</form>
</div>
@endsection
