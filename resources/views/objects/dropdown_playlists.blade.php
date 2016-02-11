<select name="drpPlaylists">
  @foreach ($playlists as $playlist)
    <option value="{{$playlist->id}}">{{$playlist->name}}</option>
  @endforeach
</select>
