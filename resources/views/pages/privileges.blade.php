@extends('default')

@section('content')

@include('objects/modal_skins', array('object' => 'Skins',
																			'heading' => 'Create New Skin'))

<script>
	$('document').ready(function() {
		ModalManager.token = "{{ csrf_token() }}";
		ModalManager.action = "/dashboard/settings/privileges/";
		ModalManager.register_eventhandlers();
	});
</script>

<div class="global">
	<div class="row">
				<h3>Assign Privileges</h3>
				@if (Session::has('message'))
					<div>
						<h4>{{Session::get('message')}}</h4>
					</div>
				@endif
				<ul name="lstPrivilegeControls">
					<li>
						{!! Form::open(['route' => 'dashboard.settings.privileges.filter', 'method' => 'POST']) !!}
							<label>Department:</label>
							@include('objects/dropdown_departments', array('allowed_departments' => $allowed_departments))
							<label>Privilege:</label>
							@include('objects/dropdown_privileges', array('privileges' => $privileges))

							<button type="submit" name="btnFindAll">Find All</button>
						{!! Form::close() !!}

						{!! Form::open(['route' => 'dashboard.settings.privileges.addMode']) !!}
							<button type="submit" name="btnAddPrivilege">Add Mode</button>
						{!! Form::close() !!}

						{!! Form::open(['route' => 'dashboard.settings.privileges.removeMode']) !!}
							<button type="submit" name="btnRemovePrivilege">Remove Mode</button>
						{!! Form::close() !!}

					</li>
				</ul>
	</div>

	<div class="row">
		@include('objects/listUsers')
	</div>
</div>
@endsection
