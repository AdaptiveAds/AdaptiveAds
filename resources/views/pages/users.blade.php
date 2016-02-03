@extends('default')

@section('content')

<div class="settings">
	<div class="row">
		{!! Form::open(['route' => 'dashboard.settings.users.process', 'method' => 'POST']) !!}
			<h3>Users</h3>
			<ul>
				<li>
					<input type="name" name="txtUsername" placeholder="Name" value="{{ $username or '' }}"/>
					<label>Department:</label>
					@include('objects/departments_dropdown', array('allowed_departments' => $allowed_departments))
					<button type="submit" name="btnFindUser">Find</button>
					<button type="submit" name="btnFindAll">Find All</button>
				</li>
			</ul>
		{!! Form::close() !!}
	</div>

	<div class="row">
			@include('objects/userItems')
	</div>
</div>
@endsection
