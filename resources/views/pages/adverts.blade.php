@extends('default')

@section('content')

@include('objects/modal_advert', array('object' => 'Advert',
																			'heading' => 'Create New Advert',
																			'allowed_departments' => $allowed_departments))
@if (isset($selectedPlaylist))

	<script>
		$('document').ready(function() {
			AdvertAssign.token = "{{ csrf_token() }}";
	@if (isset($deleteMode))
			AdvertAssign.action = "/dashboard/playlist/{{ $selectedPlaylist }}/remove";
			AdvertAssign.redirectPath = "/dashboard/playlist/{{ $selectedPlaylist }}/edit";
	@else
			AdvertAssign.action = "/dashboard/playlist/{{ $selectedPlaylist }}/add";
	@endif
			AdvertAssign.redirectPath = "/dashboard/playlist/{{ $selectedPlaylist }}/edit";
			AdvertAssign.playlist = {{ $selectedPlaylist or 1 }};
			SelectManager.multi = true;
			SelectManager.register_eventhandlers();
			AdvertAssign.register_eventhandlers();
		});
	</script>
@endif

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
					@if (isset($deleteMode))
						<button name="btnRemoveAdvert" type="button">Remove</button>
					@elseif (isset($selectedPlaylist))
						<button name="btnAddAdvert" type="button">Add</button>
					@else
						<a href="#AdvertModal" data-displayCreateModal="true"
																	 data-modalObject="Advert"
																	 data-modalMethod="POST"
																	 data-modalRoute="{{ URL::route('dashboard.advert.store') }}">
							<button type="button" name="btnAddAdvert">Add</button>
						</a>
					@endif

					<button type="submit" name="btnFindAdvert">Find</button>
					<button type="submit" name="btnFindAll">Find All</button>
				</li>
			</ul>
		{!! Form::close() !!}
	</div>

	<div class="row">
		@if (isset($selectedPlaylist))
			@include('objects/listAdverts', array('selectable' => true))
		@else
			@include('objects/listAdverts', array('selectable' => false))
		@endif
	</div>
</div>
@endsection
