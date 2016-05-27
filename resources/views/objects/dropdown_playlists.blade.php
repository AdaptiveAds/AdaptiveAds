<select name="drpPlaylists">
  <option selected>Select a Playlist</option>
  @foreach ($playlists as $playlist)
    <option value="{{$playlist->id}}">{{$playlist->name}}</option>
  @endforeach
</select>
