@extends('default')

@section('content')

<h3>Advert Editor</h3>
<h3>Title: {{ $playlist->playlist_name or 'New Playlist' }}</h3>

<div id="left">
	<div class="pagecontainer">
		@include('objects/advertItem')
	</div>
	<div class="pagecontainer">
		{!! Form::open('route' => ['', ''], 'method') !!}
		<li><button type="button">New Ad</button></li>
		{!! Form::close() !!}
		<li><button type="button">Existing Ad</button></li> <!-- TODO what the hell is this!?!?
		<li><button type="button">Edit Ad</button></li>
		<li><button type="button">Ad Details</button></li> -- >
		<li><button type="button">Edit Timings</button></li>
		<!--<li><button type="button">Remove Ad</button></li> -->
		<!--<li><button type="button">Playlist Name</button></li>-->
		{!! Form::open(['url' => '', 'method' => 'DELETE']) !!}
		<li><button type="button">Delete Playlist</button></li>
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
