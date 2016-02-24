@extends('default')

@section('content')

@include('objects/modal_departments', array('object' => 'Departments',
																			'heading' => 'Create New Department',
																			'skins' => $skins))

<script>
	$('document').ready(function() {
		ModalManager.token = "{{ csrf_token() }}";
		ModalManager.action = "/dashboard/settings/departments/";
		ModalManager.register_eventhandlers();
	});
</script>

<div class="global">
	<div class="row">
		{!! Form::open(['route' => 'dashboard.settings.departments.filter', 'method' => 'POST']) !!}
			<h3>Departments</h3>
			<ul>
				<li>
					<input type="name" name="txtDepartmentName" placeholder="Department Name..." value="{{ $departmentName or '' }}"/>
					<label>Skins:</label>
					@include('objects/dropdown_skins', array('skins' => $skins))

					<!-- Only super suer can add departments -->
					@if (isset($user))
						@if ($user->is_super_user)
							<a href="#DepartmentsModal" data-displayCreateModal="true"
																				data-modalObject="Departments"
																				data-modalMethod="POST"
																				data-modalRoute="{{ URL::route('dashboard.settings.departments.store') }}">
								<button type="button" name="btnAddDepartment">Add</button>
							</a>
						@endif
					@endif
					<button type="submit" name="btnFindDepartment">Find</button>
					<button type="submit" name="btnFindAll">Find All</button>
				</li>
			</ul>
		{!! Form::close() !!}
	</div>

	<div class="row">
			@include('objects/listDepartments')
	</div>
</div>
@endsection
