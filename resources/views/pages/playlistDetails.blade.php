@extends('default')

@section('content')

<h3>Playlist Details</h3>
<h3>Page Title</h3>

<div class="topbutton"><button type="button">Ad Details</button></div>
<div id="left">
	<div class="pagecontainer"></div>
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
