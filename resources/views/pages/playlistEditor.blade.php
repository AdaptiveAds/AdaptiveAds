@extends('default')

@section('content')

<script>
	$('document').ready(function() {
		SelectManager.token = '{{ csrf_token() }}';
		SelectManager.action = '/dashboard/playlist/{{$playlist->id}}/updateIndexes';
		SelectManager.register_eventhandlers();
	});
</script>

<div class="global">
	<div class="row">
			<!-- TODO ADD FORM -->
			<h3>Playlist Editor</h3>
			<ul>
				<li>
 					@if (isset($playlist))
						{!! Form::open(['route' => 'dashboard.playlist.process', 'method' => 'POST']) !!}
							<input type="name" name="txtPlaylistName" placeholder="Playlist name...."
										 value="{{ $searchItem or '' }}"/>
							<button id="btnUp" type="button" disabled>Up</button>
		 					<button id="btnDown" type="button" disabled>Down</button>
							<button type="button" name="btnNewPage" onclick="location.href='';">+ New Page</button>
							{!! Form::open(['route' => ['dashboard.advert.select', $playlist->id], 'method' => 'POST']) !!}
								<button type="submit" name="btnAddAdvert">Add Advert</button>
							{!! Form::close() !!}

							{!! Form:: open(['route' => ['dashboard.playlist.removeMode', $playlist->id], 'method' => 'POST']) !!}
								<button type="submit" name="btnRemoveAdvert">Remove Mode</button>
							{!! Form::close() !!}

							<button type="button">Edit Timings</button>

							{!! Form::open(['route' => ['dashboard.playlist.destroy', $playlist->id], 'method' => 'DELETE']) !!}
								<button type="submit" name="btnDeletePlaylist">Delete Playlist</button>
							{!! Form::close() !!}
						{!! Form::close() !!}
					@endif
				</li>
			</ul>
	</div>

	<div class="row">
		@include('objects/advertItem', array('selectable' => true))
	</div>
</div>
@endsection
