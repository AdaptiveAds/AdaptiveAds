@extends('backend')

@section('content')

@include('objects/modal_backgrounds', array('object' => 'Backgrounds',
																			'heading' => 'Create New Background'))

@include('objects/modal_delete', array('object' => 'Delete'))

<script>
	$('document').ready(function() {
		ModalManager.token = "{{ csrf_token() }}";
		ModalManager.action = "/dashboard/settings/backgrounds/";
		ModalManager.register_eventhandlers();
	});
</script>

<div class="global">
	<div class="row">
			{!! Form::open(['route' => 'dashboard.settings.backgrounds.filter', 'method' => 'POST']) !!}
				<h3>Backgrounds Editor</h3>
				@if (Session::has('message'))
					<h5>{{Session::pull('message')}}</h5>
				@else
					<h5>Manage department Background(s)</h5>
				@endif
				<ul name="lstBackgroundControls">
					<li>
						<input type="text" name="txtBackgroundName" placeholder="Background Name...."
									 value="{{ $searchItem or '' }}"/>

						<a href="#BackgroundsModal" data-displayCreateModal="true"
																	data-modalObject="Backgrounds"
																	data-modalMethod="POST"
																	data-modalRoute="{{ URL::route('dashboard.settings.backgrounds.store') }}">
							<button type="button" name="btnAddBackground">Add</button>
						</a>
						<button type="submit" name="btnFindBackground">Filter</button>
						<button type="submit" name="btnFindAll">Clear Filter</button>
					</li>
				</ul>
			{!! Form::close() !!}
	</div>

	<div class="row">
		@include('objects/listBackgrounds', array('editMode' => true))
	</div>
</div>
@endsection
