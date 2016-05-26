@extends('backend')

@section('content')

@include('objects/modal_advert', array('object' => 'Advert',
																			'heading' => 'Create New Advert',
																			'allowed_departments' => $allowed_departments))

@include('objects/modal_delete', array('object' => 'Delete'))

<script>
	$('document').ready(function() {
		ModalManager.token = "{{ csrf_token() }}";
		ModalManager.action = "/dashboard/advert/";
		ModalManager.register_eventhandlers();
	});
</script>

<div class="global">
	<div class="row">
		{!! Form::open(['route' => 'dashboard.advert.filter', 'method' => 'POST']) !!}
			<h3>Adverts</h3>
			@if (Session::has('message'))
				<h5>{{Session::pull('message')}}</h5>
			@else
				<h5>Manage adverts</h5>
			@endif
			<ul>
				<li>
					<input name="txtAdvertSearch" type="text" placeholder="Advert name...."
								 value="{{ $searchItem or '' }}"/>
					<label name="lblDepartment">Department:</label>
 					@include('objects/dropdown_departments', array('allowed_departments' => $allowed_departments))

					<a href="#AdvertModal" data-displayCreateModal="true"
																 data-modalObject="Advert"
																 data-modalMethod="POST"
																 data-modalRoute="{{ URL::route('dashboard.advert.store') }}">
						<button type="button" name="btnAddAdvert">Add</button>
					</a>

					<button name="btnFindAdvert" type="submit">Filter</button>
					<button name="btnFindAll" type="submit">Clear Filter</button>
				</li>
			</ul>
		{!! Form::close() !!}
	</div>

	<div class="row">
		@include('objects/listAdverts', array('selectable' => false, 'editMode' => true))
	</div>
</div>
@endsection
