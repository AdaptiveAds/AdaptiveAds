@extends('backend')

@section('content')

<h3>Advert Details</h3>
<h3>Page Title</h3>

<div class="topbutton"><button type="button">Page Details</button></div>
<div id="left">
	<div class="pagecontainer"></div>
</div>
<div id="right">

	<!-- PHP Driven self updating ?? -->
	<form name="advertlist" action="index_submit" method="get" accept-charset="utf-8">
		<ul>
			<li><button name="btnUp" type="button">Up</button></li>
			<li><button name="btnDown" type="button">Down</button></li>
			<!-- ensures form fills parent div w3c validation compliant -->
			<div class="clear"></div>
		</ul>
	</form>
</div>
@endsection
