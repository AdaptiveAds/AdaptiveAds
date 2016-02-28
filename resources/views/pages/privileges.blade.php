@extends('default')

@section('content')

<div class="global">
	<div class="row">
				<h3>View Privileges</h3>
				@if (Session::has('message'))
					<div>
						<h4>{{Session::get('message')}}</h4>
					</div>
				@endif
				<ul name="lstPrivilegeControls">
					<li>
						{!! Form::open(['route' => 'dashboard.settings.privileges.process', 'method' => 'POST']) !!}
							<label>Department:</label>
							@include('objects/dropdown_departments', array('allowed_departments' => $allowed_departments))

							<button type="submit" name="btnRemovePrivilege">Remove Mode</button>

							<button type="submit" name="btnAddPrivilege">Add Mode</button>

							<button type="submit" name="btnFindAll">Find All</button>
						{!! Form::close() !!}
					</li>
				</ul>
	</div>

	<div class="row">
		@include('objects/listPermissions')
	</div>
</div>
@endsection
