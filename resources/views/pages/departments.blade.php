@extends('default')

@section('content')

<div class="settings">
	<div class="row">
		{!! Form::open(['route' => 'dashboard.settings.departments.process', 'method' => 'POST']) !!}
			<h3>Departments</h3>
			<ul>
				<li>
					<input type="name" name="txtDepartmentName" placeholder="Department Name..." value="{{ $departmentName or '' }}"/>
					<label>Playlists:</label>
					@include('objects/playlists_dropdown', array('playlists' => $playlists))
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
