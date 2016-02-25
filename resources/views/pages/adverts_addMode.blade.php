@extends('default')

@section('content')

@include('objects/modal_error', array('object' => 'Error'))

<script>
	$('document').ready(function() {
		AdvertAssign.token = "{{ csrf_token() }}";
		AdvertAssign.action = "/dashboard/playlist/{{ $selectedPlaylist }}/add";

		AdvertAssign.redirectPath = "/dashboard/playlist/{{ $selectedPlaylist }}/edit";
		AdvertAssign.playlist = {{ $selectedPlaylist or 1 }};
		SelectManager.multi = true;
		SelectManager.register_eventhandlers();
		AdvertAssign.register_eventhandlers();
	});
</script>

<div class="global">
	<div class="row">
			<h3>Add Mode</h3>
			<h5>Add an existing advert to the playlist</h5>
			<ul>
				<li>
					<button name="btnAddAdvert" type="button">Add</button>
				</li>
			</ul>
	</div>

	<div class="row">
		@include('objects/listAdverts', array('selectable' => true))
	</div>
</div>
@endsection
