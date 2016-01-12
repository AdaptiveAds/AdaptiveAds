@extends('default')

@section('content')

<h3>Advert Editor</h3>
<h3>Title: {{ $playlist->playlist_name or 'New Playlist' }}</h3>

<div id="left">
	<div class="pagecontainer">
		@include('objects/advertItem')
	</div>
	<div class="pagecontainer">
		{!! Form::open(['route' => ['dashboard.advert.select', $playlist->id], 'method' => 'POST']) !!}
			<li><button type="submit" name="btnAddAdvert">Add Advert</button></li>
		{!! Form::close() !!}

		{!! Form:: open(['route' => ['dashboard.playlist.removeMode', $playlist->id], 'method' => 'POST']) !!}
			<li><button type="submit" name="btnRemoveAdvert">Remove Mode</button></li>
		{!! Form::close() !!}

		<!--<li><button type="button">Edit Ad</button></li>
		<li><button type="button">Ad Details</button></li>-->
		<li><button type="button">Edit Timings</button></li>
		<!--<li><button type="button">Remove Ad</button></li> -->
		<!--<li><button type="button">Playlist Name</button></li>-->
		{!! Form::open(['route' => ['dashboard.playlist.destroy', $playlist->id], 'method' => 'DELETE']) !!}
			<li><button type="submit" name="btnDeletePlaylist">Delete Playlist</button></li>
		{!! Form::close() !!}
	</div>
</div>
<div id="right">

	<!-- PHP Driven self updating ?? -->
	<form name="advertlist" action="index_submit" method="get" accept-charset="utf-8">
		<ul>
			<li><button type="button">Up</button></li>
			<li><button type="button">Down</button></li>
			<!-- ensures form fills parent div w3c validation compliant -->
			<div class="clear"></div>
		</ul>
	</form>
</div>
@endsection
