@extends('default')

@section('content')

@include('objects/modal_locations', array('object' => 'Locations',
																			'heading' => 'Create New Location',
																			'allowed_departments' => $allowed_departments))

<script>
	$('document').ready(function() {
		ModalManager.token = "{{ csrf_token() }}";
		ModalManager.action = "/dashboard/settings/locations/";
		ModalManager.register_eventhandlers();
	});
</script>

<div class="global">
	<div class="row">
		{!! Form::open(['route' => 'dashboard.settings.locations.process', 'method' => 'POST']) !!}
			<h3>Locations</h3>
				<ul>
					<li>
						<input type="name" name="txtLocationName" placeholder="Location name...."
									 value="{{ $searchItem or '' }}"/>
						<label>Department:</label>
 						@include('objects/dropdown_departments', array('allowed_departments' => $allowed_departments))
						@if (isset($user))
							<!-- Only show to admins -->
							@if ($user->is_super_user == true || $user->getAdmin() == true)
								<a href="#LocationsModal" data-displayCreateModal="true"
																					data-modalObject="Locations"
																					data-modalMethod="POST"
																					data-modalRoute="{{ URL::route('dashboard.settings.locations.store') }}">
									<button type="button" name="btnAddLocation">Add</button>
								</a>
							@endif
						@endif
						<button type="submit" name="btnFindLocation">Find</button>
						<button type="submit" name="btnFindAll">Find all</button>
					</li>
				</ul>
		{!! Form::close() !!}
	</div>

	<div class="row">
			@include('objects/listLocations')
	</div>
</div>
@endsection
