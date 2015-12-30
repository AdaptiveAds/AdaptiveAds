@extends('default')

@section('content')

<h3>Adverts</h3>

<div id="left">
	<div class="pagecontainer">
		<ul>
			@foreach($adverts as $advert)
				<li><a href="{{ URL::to('dashboard/advert/' . $advert->id . '/edit')}}">{{ $advert->advert_name }}</a></li>
			@endforeach
		</ul>

	</div>
</div>
<div id="right">

	<!-- PHP Driven self updating ?? -->
	{!! Form::open(['url' => 'dashboard/advert', 'method' => 'POST']) !!}
		<ul>
			<li><input type="text" name="advertName" placeholder="Advert Name..."/>
			<!--<li><button type="button" onclick="location.href='{{ URL::to('dashboard/advert/create') }}';">New</button></li>-->
			<li><button type="submit">New</button></li>
			<div class="clear"></div>
		</ul>
	{!! Form::close() !!}

</div>
@endsection
