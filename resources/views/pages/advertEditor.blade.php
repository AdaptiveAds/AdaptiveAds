@extends('default')

@section('content')

<h3>Advert Editor</h3>
<h3>Title: {{ $advert->name or "Advert Page Title"}}</h3>

<script>
	$('document').ready(function() {
		SelectManager.token = '{{ csrf_token() }}';
		SelectManager.action = '/dashboard/advert/1/updateIndexes';
		SelectManager.register_eventhandlers();
	});
</script>

<div id="left">
	<div class="pagecontainer">

			@include('objects/pageItem')

	</div>
	<div class="pagecontainer">
		<li><button type="button" name="btnNewPage" onclick="location.href='{{ URL::route('dashboard.advert.{adID}.page.create', $advert->id) }}';">+ New Page</button></li>
		<!--<li><button type="button">Edit Page</button></li>
		<li><button type="button">Page Details</button></li>
		<li><button type="button">Preview</button></li>
		<li><button type="button">Delete Page</button></li>-->
		<!-- <li><button type="button">Ad Name</button></li> NOTE just delete and recreate under a new name -->
		@if (isset($advert))
		{!! Form::open(['route' => ['dashboard.advert.destroy', $advert->id], 'method' => 'DELETE']) !!}
			<li><button name="btnDeleteAdvert" type="submit">Delete Ad</button></li>
		{!! Form::close() !!}
		@endif
	</div>
</div>
<div id="right">

	<!-- PHP Driven self updating ?? -->
	<form name="advertlist" action="index_submit" method="get" accept-charset="utf-8">
		<ul>
			<li><button id="btnUp" type="button">Up</button></li>
			<li><button id="btnDown" type="button">Down</button></li>
			<!-- ensures form fills parent div w3c validation compliant -->
			<div class="clear"></div>
		</ul>
	</form>
</div>
@endsection
