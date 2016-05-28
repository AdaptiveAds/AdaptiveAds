@extends('backend')

@section('content')

<div class="global">
	<div class="row">
				<h3>View Privileges</h3>
				@if (Session::has('message'))
					<h5>{{Session::pull('message')}}</h5>
				@else
					<h5>Assign users to departments and modify their access level</h5>
				@endif
				<ul name="lstPrivilegeControls">
					<li>
						{!! Form::open(['route' => 'dashboard.settings.privileges.process', 'method' => 'POST']) !!}
							<label>Department:</label>
							@include('objects/dropdown_departments', array('allowed_departments' => $allowed_departments))

							<button type="submit" name="btnRemoveMode">Remove Mode</button>

							<button type="submit" name="btnAddMode">Add Mode</button>

							<button type="submit" name="btnFindAll">Filter</button>
						{!! Form::close() !!}
					</li>
				</ul>
				<div class="clear"></div>
	</div>

	<div class="row">
		@include('objects/listPermissions')
	</div>
</div>
@endsection
