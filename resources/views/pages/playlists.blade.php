@extends('default')

@section('content')

<h3>Playlists</h3>

<div id="left">
	<div class="pagecontainer">
		@include('objects/playlistItem')
	</div>
</div>
<div id="right">

	<!-- PHP Driven self updating ?? -->
	{!! Form::open(['url' => 'dashboard/playlist', 'method' => 'POST']) !!}
		<ul>
			<li><input type="text" name="playlistName" placeholder="Playlist name..."/></li>
			<li><button type="submit">New</button></li>
			<!--<li><button type="button">Edit</button></li>
			<li><button type="button">Preview</button></li>
			<li><button type="button">Details</button></li>-->
			<!-- ensures form fills parent div w3c validation compliant -->
			<div class="clear"></div>
		</ul>
		{!! Form::close() !!}
	</form>
</div>
@endsection
