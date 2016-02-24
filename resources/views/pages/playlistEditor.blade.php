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
			<ul>
				<li>
 					@if (isset($playlist))
						{!! Form::open(['route' => 'dashboard.playlist.process', 'method' => 'POST']) !!}
								<input type="name" name="txtAdvertName" placeholder="Advert name...."
											 value="{{ $searchItem or '' }}"/>
								<button id="btnUp" type="button" disabled>Up</button>
			 					<button id="btnDown" type="button" disabled>Down</button>
								<button type="button" name="btnNewPage" onclick="location.href='';">+ New Page</button>
							{!! Form::close() !!}
							{!! Form::open(['route' => ['dashboard.advert.select', $playlist->id], 'method' => 'POST']) !!}
								<button type="submit" name="btnAddAdvert">Add Advert</button>
							{!! Form::close() !!}

							{!! Form:: open(['route' => ['dashboard.advert.removeMode', $playlist->id], 'method' => 'POST']) !!}
								<button type="submit" name="btnRemoveAdvert">Remove Mode</button>
							{!! Form::close() !!}

							<button type="button">Edit Timings</button>

							{!! Form::open(['route' => ['dashboard.playlist.destroy', $playlist->id], 'method' => 'DELETE']) !!}
								<button type="submit" name="btnDeletePlaylist">Delete Playlist</button>
							{!! Form::close() !!}
					@endif
				</li>
			</ul>
	</div>

	<div class="row">
		@include('objects/listAdverts', array('selectable' => true))
	</div>
</div>
@endsection
