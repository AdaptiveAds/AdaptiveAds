@extends('default')

@section('content')

<div class="global">
	<div class="row">
		{!! Form::open(['route' => 'dashboard.playlist.process', 'method' => 'POST']) !!}
			<h3>Playlists</h3>
			<ul>
				<li>
					<input type="text" name="txtPlaylistName" placeholder="Playlist name...."
								 value="{{ $searchItem or '' }}"/>
					<label>Department:</label>
 					@include('objects/departments_dropdown', array('allowed_departments' => $allowed_departments))
 					@if (isset($user))
						@if ($user->is_super_user)
							<button type="submit" name="btnAddPlaylist">Add</button>
						@endif
					@endif
					<button type="submit" name="btnFindPlaylist">Find</button>
					<button type="submit" name="btnFindAll">Find All</button>
				</li>
			</ul>
		{!! Form::close() !!}
	</div>

	<div class="row">
		@include('objects/listPlaylists')
	</div>
</div>
@endsection
