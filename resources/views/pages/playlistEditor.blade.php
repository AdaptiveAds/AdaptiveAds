@extends('default')

@section('content')

<h3>Advert Editor</h3>
<h3>Page Title</h3>

<div id="left">
	<div class="pagecontainer"></div>
	<div class="pagecontainer">
		<li><button type="button">New Ad</button></li>
		<li><button type="button">Existing Ad</button></li>
		<li><button type="button">Edit Ad</button></li>
		<li><button type="button">Ad Details</button></li>
		<li><button type="button">Edit Timings</button></li>
		<li><button type="button">Remove Ad</button></li>
		<li><button type="button">Playlist Name</button></li>
		<li><button type="button">Delete Playlist</button></li>
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
