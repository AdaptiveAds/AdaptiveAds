@extends('default')

@section('content')

<script>
	$('document').ready(function() {
		IndexUpdater.token = '{{ csrf_token() }}';
		IndexUpdater.action = '/dashboard/playlist/{{$playlist->id}}/updateIndexes';
		SelectManager.multi = false;
		SelectManager.register_eventhandlers();
		IndexUpdater.register_eventhandlers();
	});
</script>

<div class="global">
	<div class="row">
			<h3>Playlist Editor - {{ $playlist->name or '' }}</h3>
			<h5>Add or remove adverts and update their indexes</h5>
			<ul>
				<li>
 					@if (isset($playlist))
						<button id="btnUp" type="button" disabled>Up</button>
	 					<button id="btnDown" type="button" disabled>Down</button>

						{!! Form::open(['route' => ['dashboard.advert.select', $playlist->id], 'method' => 'POST']) !!}
							<button type="submit" name="btnAddAdvert">Add Advert</button>
						{!! Form::close() !!}

						{!! Form:: open(['route' => ['dashboard.advert.removeMode', $playlist->id], 'method' => 'POST']) !!}
							<button type="submit" name="btnRemoveAdvert">Remove Mode</button>
						{!! Form::close() !!}

						<button type="button">Edit Timings</button>
					@endif
				</li>
			</ul>
	</div>

	<div class="row">
		@include('objects/listAdverts', array('selectable' => true))
	</div>
</div>
@endsection
