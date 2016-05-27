<select name="drpBackgrounds">
  <option selected>Select a Background</option>
  @foreach ($backgrounds as $background)
    <option value="{{$background->id}}">{{$background->name}}</option>
  @endforeach
</select>
