@extends('default')

@section('content')

<div class="global">
	<div class="row">
		{!! Form::open(['route' => 'dashboard.settings.departments.process', 'method' => 'POST']) !!}
			<h3>Departments</h3>
			<ul>
				<li>
					<input type="name" name="txtDepartmentName" placeholder="Department Name..." value="{{ $departmentName or '' }}"/>
					<label>Skins:</label>
					@include('objects/skins_dropdown', array('skins' => $skins))

					<!-- Only super suer can add departments -->
					@if (isset($user))
						@if ($user->is_super_user)
							<button type="submit" name="btnAddDepartment">Add</button>
						@endif
					@endif
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
