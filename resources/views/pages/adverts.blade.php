@extends('default')

@section('content')

@include('objects/modal_advert', array('object' => 'Advert',
																			'heading' => 'Create New Advert',
																			'allowed_departments' => $allowed_departments))

<script>
	$('document').ready(function() {
		ModalManager.token = "{{ csrf_token() }}";
		ModalManager.action = "/dashboard/advert/";
		ModalManager.register_eventhandlers();
	});
</script>

<div class="global">
	<div class="row">
		{!! Form::open(['route' => 'dashboard.advert.process', 'method' => 'POST']) !!}
			<h3>Adverts</h3>
			<ul>
				<li>
					<input type="text" name="txtAdvertName" placeholder="Advert name...."
								 value="{{ $searchItem or '' }}"/>
					<label>Department:</label>
 					@include('objects/dropdown_departments', array('allowed_departments' => $allowed_departments))
					<a href="#AdvertModal" data-displayCreateModal="true"
																		data-modalObject="Advert"
																		data-modalMethod="POST"
																		data-modalRoute="{{ URL::route('dashboard.advert.store') }}">
						<button type="button" name="btnAddAdvert">Add</button>
					</a>

					<button type="submit" name="btnFindAdvert">Find</button>
					<button type="submit" name="btnFindAll">Find All</button>
				</li>
			</ul>
		{!! Form::close() !!}
	</div>

	<div class="row">
		@include('objects/listAdverts', array('selectable' => false))
	</div>
</div>
@endsection
