@extends('default')

@section('content')

<h3>Adverts</h3>

<div id="left">
	<div class="pagecontainer">
			@include('objects/advertItem')
	</div>
</div>
<div id="right">

	<!-- PHP Driven self updating ?? -->
	{!! Form::open(['url' => 'dashboard/advert', 'method' => 'POST']) !!}
		<ul>
			<li><input type="text" name="txtAdvertName" placeholder="Advert Name..."/>
			<!--<li><button type="button" onclick="location.href='{{ URL::to('dashboard/advert/create') }}';">New</button></li>-->
			<li><button name="btnNewAdvert" type="submit">New</button></li>
			<div class="clear"></div>
		</ul>
	{!! Form::close() !!}

</div>
@endsection
