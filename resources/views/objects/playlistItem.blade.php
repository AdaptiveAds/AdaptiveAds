<ul class="advertList">
@if (isset($playlists))
  @foreach($playlists as $playlist)
    <li class="advertItem">
      <a href="{{ URL::to('dashboard/playlist/' . $playlist->id)}}">{{ $playlist->name }}</a>
      <button type="submit" name="btnEditPlaylist">Edit</button>
      @if ($playlist->deleted == 0)
        <button type="submit" name="btnDisablePlaylist">Disable</button>
      @else
        @if ($user->getAdmin())
          <button type="submit" name="btnEnablePlaylist">Enable</button>
        @endif
      @endif
    </li>
  @endforeach
@endif
</ul>
