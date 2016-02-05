<ul class="advertList">
@if (isset($playlists))
  @foreach($playlists as $playlist)
    <li class="advertItem">
      <a href="{{ URL::to('dashboard/playlist/' . $playlist->id)}}">{{ $playlist->name }}</a>
      <button type="submit">Edit</button>
      @if ($playlist->deleted == 0)
        <button type="submit">Disable</button>
      @else
        @if ($user->getAdmin())
          <button type="submit">Enable</button>
        @endif
      @endif
    </li>
  @endforeach
@endif
</ul>
