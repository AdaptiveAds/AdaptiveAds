@extends('default')

@section('content')

@include('objects/model_create', array('object' => 'Advert',
																			 'allowed_departments' => $allowed_departments,
																			 'route' => 'dashboard.advert.store'))
<h3>Adverts</h3>

<div id="left">
	<div class="pagecontainer">
			@include('objects/advertItem')
	</div>
</div>
<div id="right">

	<!-- PHP Driven self updating ?? -->

		<ul>
			<li><a href="#AdvertModal"><button name="btnNewAdvert">New</button></a></li>
			<div class="clear"></div>
		</ul>


</div>
@endsection
