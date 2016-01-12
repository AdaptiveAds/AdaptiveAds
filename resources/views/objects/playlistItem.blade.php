<ul class="advertList">
@if (isset($playlists))
  @foreach($playlists as $playlist)
    <li class="advertItem"><a href="{{ URL::to('dashboard/playlist/' . $playlist->id)}}">{{ $playlist->playlist_name }}</a></li>
  @endforeach
@endif
</ul>
