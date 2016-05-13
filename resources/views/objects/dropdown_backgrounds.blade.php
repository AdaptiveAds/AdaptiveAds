<select name="drpBackgrounds">
  @foreach ($backgrounds as $background)
    <option value="{{$background->id}}">{{$background->name}}</option>
  @endforeach
</select>
