<select name="drpSkins">
  @foreach ($skins as $skin)
    <option value="{{$skin->id}}">{{$skin->name}}</option>
  @endforeach
</select>
