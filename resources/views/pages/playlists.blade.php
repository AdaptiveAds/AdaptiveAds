@extends('backend')

@section('content')

@include('objects/modal_playlist', array('object' => 'Playlist',
																			'heading' => 'Create New Playlist',
																			'allowed_departments' => $allowed_departments,
																			'playlists' => $playlists))

@include('objects/modal_delete', array('object' => 'Delete'))

<script>
	$('document').ready(function() {
		ModalManager.token = "{{ csrf_token() }}";
		ModalManager.action = "/dashboard/playlist/";
		ModalManager.register_eventhandlers();
	});
</script>

<div class="global">
	<div class="row">
			<div class="titles">
		{!! Form::open(['route' => 'dashboard.playlist.filter', 'method' => 'POST']) !!}
			<h3>Playlists</h3>
			@if (Session::has('message'))
				<h5>{{Session::pull('message')}}</h5>
			@else
				<h5>Create and manage playlists</h5>
			@endif
			</div>
			<ul>
				<li>
					<input type="text" name="txtPlaylistSearch" placeholder="Playlist name...."
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
					<button type="submit" name="btnFindPlaylist">Filter</button>
					<button type="submit" name="btnFindAll">Clear Filter</button>
				</li>
			</ul>
		{!! Form::close() !!}
	</div>

	<div class="row">
		@include('objects/listPlaylists', array('editMode' => true))
	</div>
</div>
@endsection
