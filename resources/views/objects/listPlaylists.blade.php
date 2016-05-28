<ul name="lstPlaylistItem">
@if (isset($playlists))
  @if($playlists->count() > 0)
    @foreach($playlists as $playlist)
      <li class="advertItem listItem" name="{{ $playlist->name }}">
        <label>{{ $playlist->name }}</label>
        <a href="{{ URL::route('dashboard.playlist.edit', [$playlist->id])}}">
          <button type="button" name="">Design</button>
        </a>

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
            @if ($playlist->isGlobal == false)
              <a href="#DeleteModal" data-displayDeleteModal="true"
                        data-modalObject="Delete"
                        data-modalMethod="DELETE"
                        data-modalRoute="{{ URL::route('dashboard.playlist.destroy', $playlist->id)}}">
                        <button type="button" name="btnDeleted">Delete</button>
              </a>
            @endif
          @endif
        @endif
      </li>
    @endforeach
  @else
    <li name-"itmNone" class="listItem">
      <h3>No playlists found.</h3>
    <li>
  @endif
@endif
</ul>
