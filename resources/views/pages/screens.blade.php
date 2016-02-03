@extends('default')

@section('content')

<div class="settings">
	<div class="row">
		{!! Form::open(['route' => 'dashboard.settings.screens.process', 'method' => 'POST']) !!}
			<h3>Screens</h3>
			<ul>
				<li>
					<input type="name" name="txtScreenID" placeholder="Screen id..." value="{{ $screenID or '' }}"/>
					<label>Locations:</label>
					@include('objects/locations_dropdown', array('locations' => $locations))
					<button type="submit" name="btnAddScreen">Add</button>
					<button type="submit" name="btnFindScreen">Find</button>
					<button type="submit" name="btnFindAll">Find All</button>
				</li>
			</ul>
		{!! Form::close() !!}
	</div>

	<div class="row">
			@include('objects/screenItems')
	</div>
</div>
@endsection
