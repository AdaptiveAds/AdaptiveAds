@extends('default')

@section('content')

@include('objects/model_create', array('object' => 'Advert',
																			 'allowed_departments' => $allowed_departments,
																			 'route' => 'dashboard.advert.store'))

<div class="global">
	<div class="row">
		<!-- TODO ADD FORM -->
			<h3>Adverts</h3>
			<ul>
				<li>
					<input type="name" name="txtAdvertName" placeholder="Advert name...."
								 value="{{ $searchItem or '' }}"/>
					<a href="#AdvertModal"><button type="submit" name="btnNewAdvert">New</button></a>
				</li>
			</ul>
	</div>

	<div class="row">
		@include('objects/advertItem')
	</div>
</div>
@endsection
