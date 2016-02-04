@extends('default')

@section('content')

<div class="global">
	<div class="row">
		{!! Form::open(['route' => 'dashboard.settings.departments.process', 'method' => 'POST']) !!}
			<h3>Departments</h3>
			<ul>
				<li>
					<input type="name" name="txtDepartmentName" placeholder="Department Name..." value="{{ $departmentName or '' }}"/>
					<label>Locations:</label>
					@include('objects/locations_dropdown', array('locations' => $locations))
					<label>Skins:</label>
					@include('objects/skins_dropdown', array('skins' => $skins))
					<button type="submit" name="btnAddDepartment">Add</button>
					<button type="submit" name="btnFindDepartment">Find</button>
					<button type="submit" name="btnFindAll">Find All</button>
				</li>
			</ul>
		{!! Form::close() !!}
	</div>

	<div class="row">
			@include('objects/departmentItems')
	</div>
</div>
@endsection
