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

		<ul>
				{!! Form::open(['url' => 'dashboard/advert', 'method' => 'POST']) !!}
					<li><input type="text" name="txtAdvertName" placeholder="Advert Name..."/>
					<li><button name="btnNewAdvert" type="submit">New</button></li>
				{!! Form::close() !!}
			<div class="clear"></div>
		</ul>


</div>
@endsection
