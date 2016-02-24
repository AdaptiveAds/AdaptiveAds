<ul name="lstPlaylistItem">
@if (isset($playlists))
  @if($playlists->count() > 0)
    @foreach($playlists as $playlist)
      <li class="advertItem">
        <a href="{{ URL::route('dashboard.playlist.edit', [$playlist->id])}}">{{ $playlist->name }}</a>

        <a href="#PlaylistModal" data-displayEditModal="true"
                                 data-modalObject="Playlist"
                                 data-modalMethod="PUT"
                                 data-modalRoute="{{ URL::route('dashboard.playlist.update', $playlist->id) }}"
                                 data-userID="{{ $playlist->id }}">
          <button type="button" name="btnEdit">Edit</button>
        </a>

        {{-- Show correct button to disable ot enable --}}
        {!! Form::open(['route' => ['dashboard.playlist.toggleDeleted', $playlist->id], 'method' => 'POST']) !!}
          @if ($playlist->isGlobal == false)
            @if ($playlist->deleted == 0)
              <button type="submit" name="btnDisablePlaylist">Disable</button>
            @else
              @if ($user->getAdmin())
                <button type="submit" name="btnEnablePlaylist">Enable</button>
              @endif
            @endif
          @endif
        {!! Form::close() !!}
      </li>
    @endforeach
  @else
    <li name-"itmNone">
      <h3>No playlists found.</h3>
    <li>
  @endif
@endif
</ul>
