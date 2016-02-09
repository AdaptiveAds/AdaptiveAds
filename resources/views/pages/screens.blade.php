@extends('default')

@section('content')

<div class="global">
	<div class="row">
		{!! Form::open(['route' => 'dashboard.settings.screens.process', 'method' => 'POST']) !!}
			<h3>Screens</h3>
			<ul name="listScreenControls">
				<li>
					<input type="name" name="txtScreenID" placeholder="Screen id..." value="{{ $screenID or '' }}"/>
					<label>Locations:</label>
					@include('objects/locations_dropdown', array('locations' => $locations))
					@if (isset($user))
						@if ($user->is_super_user)
							<button type="submit" name="btnAddScreen">Add</button>
						@endif
					@endif
					<button type="submit" name="btnFindScreen">Find</button>
					<button type="submit" name="btnFindAll">Find All</button>
				</li>
			</ul>
		{!! Form::close() !!}
	</div>

	<div class="row">
			@include('objects/listScreens')
	</div>
</div>
@endsection
