<ul name="lstPlaylistItem">
@if (isset($playlists))
  @if($playlists->count() > 0)
    @foreach($playlists as $playlist)
      <li class="advertItem">
        <a href="{{ URL::route('dashboard.playlist.edit', [$playlist->id])}}">{{ $playlist->name }}</a>

        {{-- Only show edit options if in mode --}}
        @if (isset($editMode))

          <a href="#PlaylistModal" data-displayEditModal="true"
                                   data-modalObject="Playlist"
                                   data-modalMethod="PUT"
                                   data-modalRoute="{{ URL::route('dashboard.playlist.update', $playlist->id) }}"
                                   data-userID="{{ $playlist->id }}">
            <button type="button" name="btnEdit">Edit</button>
          </a>

          @if ($user->getAdmin())
            {{-- Show correct button to disable ot enable --}}
            {!! Form::open(['route' => ['dashboard.playlist.destroy', $playlist->id], 'method' => 'DELETE']) !!}
              @if ($playlist->isGlobal == false)
                <button type="submit" name="btnDelete">Delete</button>
              @endif
            {!! Form::close() !!}
          @endif
        @endif
      </li>
    @endforeach
  @else
    <li name-"itmNone">
      <h3>No playlists found.</h3>
    <li>
  @endif
@endif
</ul>
