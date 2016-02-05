@extends('default')

@section('content')

@include('objects/model_create', array('object' => 'Advert',
																			 'allowed_departments' => $allowed_departments,
																			 'route' => 'dashboard.advert.store'))

<div class="global">
	<div class="row">
			<h3>Adverts</h3>
			<ul>
				<li>
					<a href="#AdvertModal"><button name="btnNewAdvert">New</button></a>
				</li>
			</ul>
	</div>

	<div class="row">
		@include('objects/advertItem')
	</div>
</div>
@endsection
