@extends('default')

@section('content')

<div class="settings">
	<div class="row">
		{!! Form::open(['route' => 'dashboard.settings.locations.process', 'method' => 'POST']) !!}
			<h3>Locations</h3>
				<ul>
					<li>
						<input type="name" name="txtLocationName" placeholder="Location name...."
									 value="{{ $searchItem or '' }}"/>
						<label>Department:</label>
 						@include('objects/departments_dropdown', array('allowed_departments' => $allowed_departments))
						<button type="submit" name="btnAddLocation">Add</button>
						<button type="submit" name="btnFindLocation">Find</button>
						<button type="submit" name="btnFindAll">Find all</button>
					</li>
				</ul>
		{!! Form::close() !!}
	</div>

	<div class="row">
		<!-- TODO REMOVE FORM -->
			<form>
			@include('objects/locationItems')
		</form>
	</div>
</div>
@endsection
