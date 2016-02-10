@extends('default')

@section('content')

@include('objects/modal_users', array('object' => 'Users',
																			'heading' => 'Create New User',
																			'allowed_departments' => $allowed_departments))

<script>
	$('document').ready(function() {
		ModalManager.token = "{{ csrf_token() }}";
		ModalManager.action = "/dashboard/settings/users/1";
		ModalManager.register_eventhandlers();
	});
</script>

<div class="global">
	<div class="row">
		{!! Form::open(['route' => 'dashboard.settings.users.process', 'method' => 'POST']) !!}
			<h3>Users</h3>
			<ul name="listUsersControls">
				<li>
					<input type="name" name="txtUsername" placeholder="Name" value="{{ $username or '' }}"/>
					<label>Department:</label>
					@include('objects/departments_dropdown', array('allowed_departments' => $allowed_departments))
					@if (isset($user))
						@if ($user->is_super_user)
							<button type="submit" name="btnFindUser">Find</button>
						@endif
					@endif
					<button type="submit" name="btnFindAll">Find All</button>
					<a href="#UsersModal" data-displayCreateModal="true"
																data-modalObject="Users"
																data-modalRoute="dashboard.settings.users.create">
						<button type="button" name="btnCreateUser">Create</button>
					</a>

				</li>
			</ul>
		{!! Form::close() !!}
	</div>

	<div class="row">
			@include('objects/listUsers')
	</div>
</div>
@endsection
