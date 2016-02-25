@extends('default')

@section('content')

<script>
	$('document').ready(function() {
		AdvertAssign.token = "{{ csrf_token() }}";

		AdvertAssign.action = "/dashboard/playlist/{{ $selectedPlaylist }}/remove";
		AdvertAssign.redirectPath = "/dashboard/playlist/{{ $selectedPlaylist }}/edit";

		AdvertAssign.playlist = {{ $selectedPlaylist or 1 }};
		SelectManager.multi = true;
		SelectManager.register_eventhandlers();
		AdvertAssign.register_eventhandlers();
	});
</script>

<div class="global">
	<div class="row">
		<h3>Delete Mode</h3>
		<h5>Remove selected adverts from playlist</h5>
		<ul>
			<li>
				<button name="btnRemoveAdvert" type="button">Remove</button>
			</li>
		</ul>
	</div>

	<div class="row">
		@include('objects/listAdverts', array('selectable' => true))
	</div>
</div>
@endsection
