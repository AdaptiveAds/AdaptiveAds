@extends('backend')

@section('content')

@include('objects/modal_screens', array('object' => 'Screens',
																			'heading' => 'Create New Screen',
																			'locations' => $locations,
																			'playlists' => $playlists))

@include('objects/modal_delete', array('object' => 'Delete'))

<script>
	$('document').ready(function() {
		ModalManager.token = "{{ csrf_token() }}";
		ModalManager.action = "/dashboard/settings/screens/";
		ModalManager.register_eventhandlers();
	});
</script>

<div class="global">
	<div class="row">
		{!! Form::open(['route' => 'dashboard.settings.screens.filter', 'method' => 'POST']) !!}
			<h3>Screens</h3>
			@if (Session::has('message'))
				<h5>{{Session::pull('message')}}</h5>
			@else
				<h5>Register/Manage new and existing screens</h5>
			@endif
			<ul name="lstScreenControls">
				<li>
					<input type="name" name="txtScreenID" placeholder="Screen id..." value="{{ $screenID or '' }}"/>
					<label>Locations:</label>
					@include('objects/dropdown_locations', array('locations' => $locations))
					@if (isset($user))
						@if ($user->is_super_user)
							<a href="#ScreensModal" data-displayCreateModal="true"
																				data-modalObject="Screens"
																				data-modalMethod="POST"
																				data-modalRoute="{{ URL::route('dashboard.settings.screens.store') }}">
								<button type="button" name="btnAddScreen">Add</button>
							</a>
						@endif
					@endif
					<button type="submit" name="btnFindScreen">Filter</button>
					<button type="submit" name="btnFindAll">Clear Filter</button>
				</li>
			</ul>
		{!! Form::close() !!}
	</div>

	<div class="row">
			@include('objects/listScreens', array('editMode' => true))
	</div>
</div>
@endsection
