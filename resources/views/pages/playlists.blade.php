@extends('default')

@section('content')

@include('objects/modal_playlist', array('object' => 'Playlist',
																			'heading' => 'Create New Playlist',
																			'allowed_departments' => $allowed_departments))

<script>
	$('document').ready(function() {
		ModalManager.token = "{{ csrf_token() }}";
		ModalManager.action = "/dashboard/playlist/";
		ModalManager.register_eventhandlers();
	});
</script>

<div class="global">
	<div class="row">
		{!! Form::open(['route' => 'dashboard.playlist.filter', 'method' => 'POST']) !!}
			<h3>Playlists</h3>
			@if (Session::has('message'))
				<div>
					<h4>{{Session::get('message')}}</h4>
				</div>
			@endif
			<ul>
				<li>
					<input type="text" name="txtPlaylistName" placeholder="Playlist name...."
								 value="{{ $searchItem or '' }}"/>
					<label>Department:</label>
 					@include('objects/dropdown_departments', array('allowed_departments' => $allowed_departments))
 					@if (isset($user))
						@if ($user->is_super_user)
							<a href="#PlaylistModal" data-displayCreateModal="true"
																			 data-modalObject="Playlist"
																			 data-modalMethod="POST"
																			 data-modalRoute="{{ URL::route('dashboard.playlist.store') }}">
								<button type="button" name="btnAddPlaylist">Add</button>
							</a>
						@endif
					@endif
					<button type="submit" name="btnFindPlaylist">Find</button>
					<button type="submit" name="btnFindAll">Find All</button>
				</li>
			</ul>
		{!! Form::close() !!}
	</div>

	<div class="row">
		@include('objects/listPlaylists', array('editMode' => true))
	</div>
</div>
@endsection
