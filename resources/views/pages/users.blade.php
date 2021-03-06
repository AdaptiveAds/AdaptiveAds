@extends('backend')

@section('content')

@include('objects/modal_users', array('object' => 'Users',
																			'heading' => 'Create New User',
																			'allowed_departments' => $allowed_departments))

@include('objects/modal_delete', array('object' => 'Delete'))

<script>
	$('document').ready(function() {
		ModalManager.token = "{{ csrf_token() }}";
		ModalManager.action = "/dashboard/settings/users/";
		ModalManager.register_eventhandlers();
	});
</script>

<div class="global">
	<div class="row">
		{!! Form::open(['route' => 'dashboard.settings.users.filter', 'method' => 'POST']) !!}
			<h3>Users</h3>
			@if (Session::has('message'))
          <h5>{{Session::pull('message')}}</h5>
			@else
				<h5>Manage user accounts</h5>
			@endif
			<ul name="listUsersControls">
				<li>
					<input type="name" name="txtUsername" placeholder="Name" value="{{ $username or '' }}"/>
					{{--<label>Department:</label>
					@include('objects/dropdown_departments', array('allowed_departments' => $allowed_departments))--}}
					@if (isset($requestUser))
						@if ($requestUser->is_super_user)
							<button type="submit" name="btnFindUser">Filter</button>
						@endif
					@endif
					<button type="submit" name="btnFindAll">Clear Filter</button>
					<a href="#UsersModal" data-displayCreateModal="true"
																data-modalObject="Users"
																data-modalMethod="POST"
																data-modalRoute="{{ URL::route('dashboard.settings.users.store') }}">
						<button type="button" name="btnCreateUser">Create</button>
					</a>

				</li>
			</ul>
		{!! Form::close() !!}
	</div>

	<div class="row">
			@include('objects/listUsers', array('editMode' => true))
	</div>
</div>
@endsection
